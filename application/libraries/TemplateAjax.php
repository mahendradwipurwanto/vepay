<?php

class TemplateAjax
{
    protected $_ci;

    public function __construct()
    {
        $this->_ci = &get_instance();
    }

    public function view($content, $data = null)
    {
        $this->_ci->load->view('template/ajax/header', $data);
        $this->_ci->load->view($content, $data);
        $this->_ci->load->view('template/ajax/footer', $data);
    }
}
