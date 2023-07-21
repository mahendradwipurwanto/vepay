<?php

class TemplateBack
{
    protected $_ci;

    public function __construct()
    {
        $this->_ci = &get_instance();
        $this->_ci->load->database();
    }

    public function getSettingsValue($key)
    {
        $query = $this->_ci->db->get_where('tb_settings', ['key' => $key]);
        return $query->row()->value;
    }

    public function getOnlineUsers()
    {
        $this->_ci->db->select('a.*, b.name')
        ->from('tb_auth a')
        ->join('tb_user b', 'a.user_id = b.user_id')
        ->where(['a.online' => 1])
        ;
        return $this->_ci->db->get()->result();

    }

    public function view($content, $data = null)
    {
        $data['app_version'] = $this->getSettingsValue('app_version');
        $data['web_title'] = $this->getSettingsValue('web_title');
        $data['web_desc'] = $this->getSettingsValue('web_desc');
        $data['web_icon'] = $this->getSettingsValue('web_icon');
        $data['web_logo'] = $this->getSettingsValue('web_logo');
        $data['web_logo_white'] = $this->getSettingsValue('web_logo_white');
        $data['web_alamat'] = $this->getSettingsValue('web_alamat');
        $data['web_telepon'] = $this->getSettingsValue('web_telepon');
        $data['web_website'] = $this->getSettingsValue('web_website');
        $data['web_email'] = $this->getSettingsValue('web_email');

        $data['sosmed_ig'] = $this->getSettingsValue('sosmed_ig');
        $data['sosmed_twitter'] = $this->getSettingsValue('sosmed_twitter');
        $data['sosmed_facebook'] = $this->getSettingsValue('sosmed_facebook');
        $data['sosmed_yt'] = $this->getSettingsValue('sosmed_yt');

        $data['web_app_name'] = $this->getSettingsValue('web_app_name');
        $data['web_splash_title'] = $this->getSettingsValue('web_splash_title');
        $data['web_splash_image'] = $this->getSettingsValue('web_splash_image');
        $data['web_splash_desc'] = $this->getSettingsValue('web_splash_desc');
        $data['web_info_desc'] = $this->getSettingsValue('web_info_desc');

        $data['online_users'] = $this->getOnlineUsers();

        $this->_ci->load->view('template/backend/header', $data);
        $this->_ci->load->view('template/alert', $data);
        $this->_ci->load->view('template/backend/navbar', $data);
        $this->_ci->load->view('template/backend/sidebar', $data);
        $this->_ci->load->view($content, $data);
        $this->_ci->load->view('template/backend/footer', $data);
    }
}
