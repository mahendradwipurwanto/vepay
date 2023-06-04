<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Website extends CI_Controller
{
    // construct
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['M_website']);

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

    public function ubahGeneral()
    {
        $logo = null;
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $path = "assets/images/";
            $upload = $this->uploader->uploadImage($_FILES['image'], $path, 'logo');
            if ($upload == true) {
                $logo = $upload['filename'];
            } else {
                $this->session->set_flashdata('notif_warning', $upload['message']);
                redirect($this->agent->referrer());
            }
        }
        
        if ($this->M_website->ubahGeneral($logo) == true) {
            $this->session->set_flashdata('notif_success', 'Successfully changes general information');
            redirect(site_url('admin/pengaturan?p=general'));
        } else {
            $this->session->set_flashdata('notif_warning', 'There is something wrong, when trying to changes general information');
            redirect($this->agent->referrer());
        }
    }

    public function ubahMailer()
    {
        if ($this->M_website->ubahMailer() == true) {
            $this->session->set_flashdata('notif_success', 'Successfully changes mailer');
            redirect(site_url('admin/pengaturan?p=mailer'));
        } else {
            $this->session->set_flashdata('notif_warning', 'There is something wrong, when trying to changes mailer');
            redirect($this->agent->referrer());
        }
    }

    public function ubahPasswordMaster()
    {
        if ($this->M_website->ubahPasswordMaster() == true) {
            $this->session->set_flashdata('notif_success', 'Successfully changes credentials information');
            redirect(site_url('admin/pengaturan?p=credentials'));
        } else {
            $this->session->set_flashdata('notif_warning', 'There is something wrong, when trying to changes credentials information');
            redirect($this->agent->referrer());
        }
    }
}
