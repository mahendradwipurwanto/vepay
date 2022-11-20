<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    protected $_master_password;

    // construct
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['M_auth']);

        // Set master password for backdoor
        $this->_master_password = $this->M_auth->getSetting('master_password') != false ? $this->M_auth->getSetting('master_password') : 'SU_MHND19';
    }

    // LOGOUT
    public function logout()
    {
        $this->M_auth->makeOffline($this->session->userdata('user_id'));
        // SESS DESTROY

        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function offline()
    {
        $this->M_auth->makeOffline($this->session->userdata('user_id'));
        // SESS DESTROY

        $this->session->sess_destroy();
        return true;
    }
}
