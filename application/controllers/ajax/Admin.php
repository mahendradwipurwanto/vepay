<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    // construct
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['M_admin', 'M_member', 'M_transaksi']);

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
    
    public function getAjaxMember(){
        
        $draw     = $this->input->post('draw');
        $search   = $this->input->post('search')['value'];
        $no       = $this->input->post('start');
        
        $members  = $this->M_member->getAllMember();
        
        $arr      = [];
        foreach ($members['records'] as $key => $val) {

            $arr[$key] = [
                "no"            => ++$no,
                "action"        => $val->action,
                "name"          => $val->name,
                "email"         => $val->email,
                "whatsapp"      => $val->phone,
                "joined_at"     => $val->joined_at,
            ];
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $members['totalRecords'],
            "recordsFiltered" => ($search != "" ? $members['totalDisplayRecords'] : $members['totalRecords']),
            "data" => $arr
        );

        echo json_encode($response);
    }
    
    public function getAjaxUserLog(){
        
        $draw     = $this->input->post('draw');
        $search   = $this->input->post('search')['value'];
        $no       = $this->input->post('start');
        
        $members = $this->M_admin->get_allAccount();
        $arr      = [];
        foreach ($members['records'] as $key => $val) {

            $arr[$key] = [
                "no"            => ++$no,
                "user"        => $val->name,
                "status"          => $val->status,
                "last_access"         => $val->log_time,
                "device"      => $val->device,
            ];
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $members['totalRecords'],
            "recordsFiltered" => ($search != "" ? $members['totalDisplayRecords'] : $members['totalRecords']),
            "data" => $arr
        );

        echo json_encode($response);
    }

    public function getDetailMember(){

        $member = $this->M_member->getDetailMember($this->input->post('user_id'));
        $transaksi = $this->M_transaksi->getAllTransaksiUser(['user_id' => $this->input->post('user_id')]);
		if (!empty($member)) {
        
            $data['member']      = $member;
            $data['transaksi']   = $transaksi;

            $this->load->view('admin/ajax/detail_member', $data);

		} else {
			echo "<center class='py-5'><h4>Terjadi kesalahan saat mencoba menampilkan data member!</h4></center>";
		}
    }
}