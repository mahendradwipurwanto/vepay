<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
    // construct
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['M_admin', 'M_master']);

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
    
    public function getAjaxProduct(){
        $products  = $this->M_master->getAllProduct();
        
        $draw     = $this->input->post('draw');
        $search   = $this->input->post('search')['value'];
        $arr      = [];
        $no       = $this->input->post('start');

        foreach ($products['records'] as $key => $val) {

            $arr[$key] = [
                "no"            => ++$no,
                "action"        => $val->action,
                "name"          => $val->name,
                "image"         => $val->image,
                "price"         => $val->price_txt,
                "categories"    => $val->categories,
            ];
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $products['totalRecords'],
            "recordsFiltered" => ($search != "" ? $products['totalDisplayRecords'] : $products['totalRecords']),
            "data" => $arr
        );

        echo json_encode($response);
    }

    public function getDetailProduct(){

        $product = $this->M_master->getDetailProduct($this->input->post('product_id'));
		if (!empty($product)) {
        
            $data['product']   = $product;
            $data['kategori'] = $this->M_master->getAllKategori();

            $this->load->view('admin/ajax/detail_product', $data);

		} else {
			echo "<center class='py-5'><h4>Terjadi kesalahan saat mencoba menampilkan data product!</h4></center>";
		}
    }
}