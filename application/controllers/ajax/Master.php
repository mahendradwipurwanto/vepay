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
                "categories"    => $val->categories,
                "status"        => $val->status,
                "price"         => "<ul class='list-unstyled list-py-2'>{$val->price}</ul>",
                "fee"           => $val->fee,
                "description"   => $val->description,
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

    public function getRateProduct(){

        $price_history              = $this->M_master->getRateProduct($this->input->post('product_id'));
        
        $data['price_history']      = $price_history;
        $data['m_product_id']       = $this->input->post('product_id');

        $this->load->view('admin/ajax/harga_product', $data);
    }

    public function getDetailPromo(){

        $promo                      = $this->M_master->getDetailPromo($this->input->post('promo_id'));
        
        $data['promo']              = $promo;

        $this->load->view('admin/ajax/edit_promo', $data);
    }

    public function getDetailMetode(){

        $metode                      = $this->M_master->getDetailMetode($this->input->post('metode_id'));
        
        $data['metode']              = $metode;

        $this->load->view('admin/ajax/edit_metode', $data);
    }

    public function getDetailBlockchain(){

        $blockchain                      = $this->M_master->getDetailBlockchain($this->input->post('blockchain_id'));
        
        $data['blockchain']              = $blockchain;

        $this->load->view('admin/ajax/edit_blockchain', $data);
    }

    public function getDetailVcc(){

        $vcc                      = $this->M_master->getDetailVcc($this->input->post('VCC_id'));
        
        $data['vcc']              = $vcc;

        $this->load->view('admin/ajax/edit_vcc', $data);
    }
}
