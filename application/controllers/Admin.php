<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    // construct
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['M_admin']);

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

    public function index()
    {
        $data['count'] = $this->M_admin->getCountOverview();
        $this->templateback->view('admin/dashboard', $data);
    }

    public function statistik()
    {
        $this->templateback->view('admin/statistik');
    }

    public function transaksi()
    {
        $this->templateback->view('admin/transaksi');
    }

    public function member()
    {
        $this->templateback->view('admin/member');
    }

    public function pengaturan()
    {
        $this->templateback->view('admin/pengaturan');
    }
}