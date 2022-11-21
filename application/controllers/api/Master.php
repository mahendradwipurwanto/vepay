<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
    // construct
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['M_admin', 'M_master']);

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

    function addProduct(){
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $date = date('m/Y');
            $path = "berkas/product/{$date}/";
            $upload = $this->uploader->uploadImage($_FILES['image'], $path);
            if ($upload == true) {
                if ($this->M_master->addProduct($upload['filename']) == true) {
                    $this->session->set_flashdata('notif_success', 'Berhasil menambahkan produk ');
                    redirect(site_url('master/produk'));
                } else {
                    $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menambahkan produk, harap coba lagi');
                    redirect($this->agent->referrer());
                }
            } else {
                $this->session->set_flashdata('notif_warning', $upload['message']);
                redirect($this->agent->referrer());
            }
        } else {
            if ($this->M_master->addProduct() == true) {
                $this->session->set_flashdata('notif_success', 'Berhasil menambahkan produk ');
                redirect(site_url('master/produk'));
            } else {
                $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menambahkan produk, harap coba lagi');
                redirect($this->agent->referrer());
            }
        }
    }

    function editProduct(){
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $date = date('m/Y');
            $path = "berkas/product/{$date}/";
            $upload = $this->uploader->uploadImage($_FILES['image'], $path);
            if ($upload == true) {
                if ($this->M_master->editProduct($upload['filename']) == true) {
                    $this->session->set_flashdata('notif_success', 'Berhasil mengubah produk ');
                    redirect(site_url('master/produk'));
                } else {
                    $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba mengubah produk, harap coba lagi');
                    redirect($this->agent->referrer());
                }
            } else {
                $this->session->set_flashdata('notif_warning', $upload['message']);
                redirect($this->agent->referrer());
            }
        } else {
            if ($this->M_master->editProduct() == true) {
                $this->session->set_flashdata('notif_success', 'Berhasil mengubah produk ');
                redirect(site_url('master/produk'));
            } else {
                $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba mengubah produk, harap coba lagi');
                redirect($this->agent->referrer());
            }
        }
    }

    function deleteProduct(){
        if ($this->M_master->deleteProduct() == true) {
            $this->session->set_flashdata('notif_success', 'Berhasil menghapus produk ');
            redirect(site_url('master/produk'));
        } else {
            $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menghapus produk, harap coba lagi');
            redirect($this->agent->referrer());
        }
    }
}
