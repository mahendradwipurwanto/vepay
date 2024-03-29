<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Utility extends CI_Controller
{

    // construct
    public function __construct()
    {
        parent::__construct();
    }

    public function not_found()
    {
        $this->templateauth->view('utility/not_found');
    }

    public function generateKodeReferral(){
        $this->load->model('M_master');
        $this->M_master->generateKodeReferral();
    }

    public function generateNameMember(){
        $this->load->model('M_master');
        $this->M_master->generateNameMember();
    }
}
