<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Referral extends CI_Controller
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
    public function transaksi()
    {
        $data['member']     = $this->M_member->getAllMemberSelect();
        $data['product']    = $this->M_master->getRateAllProduct();
        $data['metode']     = $this->M_master->getAllMetode();
        $this->templateback->view('admin/transaksi_referral', $data);
    }

    public function member()
    {
        $data['member']     = $this->M_member->getAllMemberReferral();
        $this->templateback->view('admin/referral/member', $data);
    }

    public function pengaturan()
    {
        $data['referral_interest'] = json_decode($this->M_admin->get_settingsValue('referral_interest'), true);
        $data['penggunaan_referral'] = $this->M_admin->get_settingsValue('penggunaan_referral');
        $data['referral_image'] = $this->M_admin->get_settingsValue('referral_image');
        $data['referral_title'] = $this->M_admin->get_settingsValue('referral_title');
        $data['referral_description'] = $this->M_admin->get_settingsValue('referral_description');
        $data['referral_withdraw_minimum'] = $this->M_admin->get_settingsValue('referral_withdraw_minimum');
        $data['desc_referral_intro'] = $this->M_admin->get_settingsValue('desc_referral_intro');
        $data['referral_desc_info'] = $this->M_admin->get_settingsValue('referral_desc_info');
        if ($this->agent->is_mobile()) {
            $this->templatemobile->view('admin/pengaturan/referral', $data);
        } else {
            $this->templateback->view('admin/pengaturan/referral', $data);
        }
    }
}
