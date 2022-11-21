<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
    // construct
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['M_master']);

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

    public function kategori()
    {
        $data['kategori'] = $this->M_master->getAllKategori();
        $this->templateback->view('admin/master/kategori', $data);
    }

    public function produk()
    {
        $data['kategori'] = $this->M_master->getAllKategori();
        $this->templateback->view('admin/master/produk', $data);
    }

    public function kupon()
    {
        $this->templateback->view('admin/master/kupon');
    }

    public function metode()
    {
        $this->templateback->view('admin/master/metode');
    }
}
