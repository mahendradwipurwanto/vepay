<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Website extends CI_Controller
{
    // construct
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['M_website']);
    }

    public function ubahGeneral()
    {
        if ($this->M_website->ubahGeneral() == true) {
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
