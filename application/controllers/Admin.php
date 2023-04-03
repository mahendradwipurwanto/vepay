<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    // construct
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['M_admin', 'M_member', 'M_master']);

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
        $data['count'] = $this->M_admin->getCountOverview();
        $data['daily_transaksi'] = $this->M_admin->getDailyTransaksi();
        $data['top_product'] = $this->M_admin->getTopProduk();
        $data['top_member'] = $this->M_admin->getTopmember();

		// ej($data);

        $this->templateback->view('admin/statistik', $data);
    }

    public function transaksi()
    {
        $data['member']     = $this->M_member->getAllMemberSelect();
        $data['product']    = $this->M_master->getRateAllProduct();
        $data['metode']     = $this->M_master->getAllMetode();
        $this->templateback->view('admin/transaksi', $data);
    }

    public function member()
    {
        $this->templateback->view('admin/member');
    }

    public function vcc_member()
    {
        $data['member']     = $this->M_member->getAllMemberSelect();
        $data['vcc']        = $this->M_master->getAllVcc();

        $this->templateback->view('admin/vcc', $data);
    }

    public function pengaturan()
    {
        $page = $this->input->get('p');
        switch ($page) {
            case 'general':

                if ($this->agent->is_mobile()) {
                    $this->templatemobile->view('admin/pengaturan/general');
                } else {
                    $this->templateback->view('admin/pengaturan/general');
                }
                break;

            case 'user-log':
                $data['master_password'] = $this->M_admin->get_settingsValue('master_password');
                $data['account'] = $this->M_admin->get_allAccount();
                $data['admin'] = $this->M_admin->get_adminAccount();
                $data['super'] = $this->M_admin->get_superAccount();

                if ($this->agent->is_mobile()) {
                    $this->templatemobile->view('admin/pengaturan/user_log', $data);
                } else {
                    $this->templateback->view('admin/pengaturan/user_log', $data);
                }
                break;

            case 'credentials':
                $data['master_password'] = $this->M_admin->get_settingsValue('master_password');
                $data['account'] = $this->M_admin->get_allAccount();
                $data['admin'] = $this->M_admin->get_adminAccount();
                $data['super'] = $this->M_admin->get_superAccount();

                if ($this->agent->is_mobile()) {
                    $this->templatemobile->view('admin/pengaturan/credentials', $data);
                } else {
                    $this->templateback->view('admin/pengaturan/credentials', $data);
                }
                break;

            case 'mailer':
                $data['mailer_mode'] = $this->M_admin->get_settingsValue('mailer_mode');
                $data['mailer_host'] = $this->M_admin->get_settingsValue('mailer_host');
                $data['mailer_port'] = $this->M_admin->get_settingsValue('mailer_port');
                $data['mailer_smtp'] = $this->M_admin->get_settingsValue('mailer_smtp');
                $data['mailer_connection'] = $this->M_admin->get_settingsValue('mailer_connection');
                $data['mailer_alias'] = $this->M_admin->get_settingsValue('mailer_alias');
                $data['mailer_username'] = $this->M_admin->get_settingsValue('mailer_username');
                $data['mailer_password'] = $this->M_admin->get_settingsValue('mailer_password');

                if ($this->agent->is_mobile()) {
                    $this->templatemobile->view('admin/pengaturan/mailer', $data);
                } else {
                    $this->templateback->view('admin/pengaturan/mailer', $data);
                }
                break;

            default:

                if ($this->agent->is_mobile()) {
                    $this->templatemobile->view('admin/pengaturan');
                } else {
                    $this->templateback->view('admin/pengaturan');
                }
                break;
        }
    }
}
