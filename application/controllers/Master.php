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

    public function promo()
    {
        $data['promo'] = $this->M_master->getAllPromo();
        $this->templateback->view('admin/master/promo', $data);
    }

    public function penggunaan_promo($id = null)
    {
        $data['promo'] = $this->M_master->getPenggunaanPromo($id);
        $this->templateback->view('admin/master/promo_penggunaan', $data);
    }

    public function metode()
    {
        $data['metode'] = $this->M_master->getAllMetode();

        $this->templateback->view('admin/master/metode', $data);
    }

    public function withdraw()
    {
        $data['withdraw'] = $this->M_master->getAllWithdraw();

        $this->templateback->view('admin/master/withdraw', $data);
    }

    public function blockchain()
    {
        $data['blockchain'] = $this->M_master->getAllBlockchain();

        $this->templateback->view('admin/master/blockchain', $data);
    }

    public function faq()
    {
        $data['faq'] = $this->M_master->getAllFaq();

        $this->templateback->view('admin/master/faq', $data);
    }
}
