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
        return $this->M_transaksi->verificationPayment();
        // if ($this->M_transaksi->verificationPayment() == true) {
        //     $this->session->set_flashdata('notif_success', 'Succesfuly verification payment ');
        //     redirect(site_url('admin/payments'));
        // } else {
        //     $this->session->set_flashdata('notif_warning', 'There is a problem when trying to verification payment, try again later');
        //     redirect($this->agent->referrer());
        // }
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
