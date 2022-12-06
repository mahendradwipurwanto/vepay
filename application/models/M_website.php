<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_website extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // basic
    public function ubahGeneral()
    {
        $web_title = $this->input->post('web_title');
        $this->db->where('key', 'web_title');
        $this->db->update('tb_settings', ['value' => $web_title]);

        $web_desc = $this->input->post('web_desc');
        $this->db->where('key', 'web_desc');
        $this->db->update('tb_settings', ['value' => $web_desc]);

        $web_alamat = $this->input->post('web_alamat');
        $this->db->where('key', 'web_alamat');
        $this->db->update('tb_settings', ['value' => $web_alamat]);

        $sosmed_facebook = $this->input->post('sosmed_facebook');
        $this->db->where('key', 'sosmed_facebook');
        $this->db->update('tb_settings', ['value' => $sosmed_facebook]);

        $sosmed_ig = $this->input->post('sosmed_ig');
        $this->db->where('key', 'sosmed_ig');
        $this->db->update('tb_settings', ['value' => $sosmed_ig]);

        $sosmed_twitter = $this->input->post('sosmed_twitter');
        $this->db->where('key', 'sosmed_twitter');
        $this->db->update('tb_settings', ['value' => $sosmed_twitter]);

        $sosmed_ig = $this->input->post('sosmed_ig');
        $this->db->where('key', 'sosmed_ig');
        $this->db->update('tb_settings', ['value' => $sosmed_ig]);

        $leader_daftar = $this->input->post('leader_daftar');
        $this->db->where('key', 'leader_daftar');
        $this->db->update('tb_settings', ['value' => $leader_daftar == 'on' ? 1 : 0]);

        return true;
    }
    // mailer
    public function ubahMailer()
    {
        if($this->session->userdata('role') == 0):
            $mailer_mode = $this->input->post('mailer_mode');
            $this->db->where('key', 'mailer_mode');
            $this->db->update('tb_settings', ['value' => $mailer_mode]);

            $mailer_host = $this->input->post('mailer_host');
            $this->db->where('key', 'mailer_host');
            $this->db->update('tb_settings', ['value' => $mailer_host]);

            $mailer_port = $this->input->post('mailer_port');
            $this->db->where('key', 'mailer_port');
            $this->db->update('tb_settings', ['value' => $mailer_port]);

            $mailer_connection = $this->input->post('mailer_connection');
            $this->db->where('key', 'mailer_connection');
            $this->db->update('tb_settings', ['value' => $mailer_connection]);

            $mailer_smtp = $this->input->post('mailer_smtp');
            $this->db->where('key', 'mailer_smtp');
            $this->db->update('tb_settings', ['value' => $mailer_smtp == 'on' ? 1 : 0]);
        endif;

        $mailer_alias = $this->input->post('mailer_alias');
        $this->db->where('key', 'mailer_alias');
        $this->db->update('tb_settings', ['value' => $mailer_alias]);

        $mailer_username = $this->input->post('mailer_username');
        $this->db->where('key', 'mailer_username');
        $this->db->update('tb_settings', ['value' => $mailer_username]);

        if($this->input->post('mailer_password')) {
            $mailer_password = $this->input->post('mailer_password');
            $this->db->where('key', 'mailer_password');
            $this->db->update('tb_settings', ['value' => $mailer_password]);
        }

        return true;
    }
    // keamanan
    public function ubahPasswordMaster()
    {
        $master_password = $this->input->post('master');
        $this->db->where('key', 'master_password');
        $this->db->update('tb_settings', ['value' => $master_password]);

        $email = $this->input->post('email');
        $password = $this->input->post('admin');

        $this->db->where('role', 1);
        $this->db->update('tb_auth', ['email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)]);

        return true;
    }
}
