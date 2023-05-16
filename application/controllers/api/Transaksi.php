<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{
    // construct
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['M_transaksi']);

        // cek apakah user sudah login
        if ($this->session->userdata('logged_in') == false || !$this->session->userdata('logged_in')) {
            if (!empty($_SERVER['QUERY_STRING'])) {
                $uri = uri_string() . '?' . $_SERVER['QUERY_STRING'];
            } else {
                $uri = uri_string();
            }
            $this->session->set_userdata('redirect', $uri);
            $this->session->set_flashdata('notif_warning', "Harap login untuk melanjutkan");
            redirect('sign-in');
        }

        if ($this->session->userdata('role') > 1) {
            $this->session->set_flashdata('warning', "Anda tidak memiliki akses pada halaman ini");
            redirect(base_url());
        }
    }

    public function addTransaksi()
    {
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $date = date('m/Y');
            $path = "berkas/transaction/{$date}/";
            $upload = $this->uploader->uploadImage($_FILES['image'], $path);
            if ($upload == true) {
                if ($this->M_transaksi->addTransaksi($upload['filename']) == true) {
                    $this->session->set_flashdata('notif_success', 'Berhasil menambahkan transaksi ');
                    redirect(site_url('admin/transaksi'));
                } else {
                    $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menambahkan transaksi, harap coba lagi');
                    redirect($this->agent->referrer());
                }
            } else {
                $this->session->set_flashdata('notif_warning', $upload['message']);
                redirect($this->agent->referrer());
            }
        } else {
            if ($this->M_transaksi->addTransaksi() == true) {
                $this->session->set_flashdata('notif_success', 'Berhasil menambahkan transaksi ');
                redirect(site_url('admin/transaksi'));
            } else {
                $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menambahkan transaksi, harap coba lagi');
                redirect($this->agent->referrer());
            }
        }
    }

    public function verificationPayment()
    {
        // Get the base64 string
        $base64_string = $this->input->post('base64');
        $id = $this->input->post('id');
        $file_name = null;
        
        if(!is_null($base64_string)){
            $image_parts = explode(';base64,', $base64_string);
            $image_type_aux = explode('image/', $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $namaFile = "bukti-verif-{$id}.{$image_type}";

            $path = FCPATH . "berkas/transaction/{$id}";

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $file = "{$path}/{$namaFile}";
            file_put_contents($file, $image_base64);
        }

        return $this->M_transaksi->verificationPayment("berkas/transaction/{$id}/{$namaFile}");
        // if ($this->M_transaksi->verificationPayment() == true) {
        //     $this->session->set_flashdata('notif_success', 'Succesfuly verification payment ');
        //     redirect(site_url('admin/payments'));
        // } else {
        //     $this->session->set_flashdata('notif_warning', 'There is a problem when trying to verification payment, try again later');
        //     redirect($this->agent->referrer());
        // }
    }

    public function detailSlip($id_transksi = null){
        $transaksi                      = $this->M_transaksi->getDetailTransaksi($id_transksi);

        $data['transaksi']              = $transaksi;

        $this->templateslip->view('admin/transaksi_detail', $data);
    }

    public function rejectedPayment()
    {
        return $this->M_transaksi->rejectedPayment();
        // if ($this->M_transaksi->rejectedPayment() == true) {
        //     $this->session->set_flashdata('notif_success', 'Succesfuly rejected payment ');
        //     redirect(site_url('admin/payments'));
        // } else {
        //     $this->session->set_flashdata('notif_warning', 'There is a problem when trying to rejected payment, try again later');
        //     redirect($this->agent->referrer());
        // }
    }

    public function pendingPayment()
    {
        return $this->M_transaksi->pendingPayment();
        // if ($this->M_transaksi->pendingPayment() == true) {
        //     $this->session->set_flashdata('notif_success', 'Succesfuly pending payment ');
        //     redirect(site_url('admin/payments'));
        // } else {
        //     $this->session->set_flashdata('notif_warning', 'There is a problem when trying to pending payment, try again later');
        //     redirect($this->agent->referrer());
        // }
    }

    public function cancelPayment()
    {
        return $this->M_transaksi->cancelPayment();
        // if ($this->M_transaksi->cancelPayment() == true) {
        //     $this->session->set_flashdata('notif_success', 'Succesfuly cancel payment ');
        //     redirect(site_url('admin/payments'));
        // } else {
        //     $this->session->set_flashdata('notif_warning', 'There is a problem when trying to cancel payment, try again later');
        //     redirect($this->agent->referrer());
        // }
    }

    public function deletePayment()
    {
        return $this->M_transaksi->deletePayment();
        // if ($this->M_transaksi->cancelPayment() == true) {
        //     $this->session->set_flashdata('notif_success', 'Succesfuly cancel payment ');
        //     redirect(site_url('admin/payments'));
        // } else {
        //     $this->session->set_flashdata('notif_warning', 'There is a problem when trying to cancel payment, try again later');
        //     redirect($this->agent->referrer());
        // }
    }
}
