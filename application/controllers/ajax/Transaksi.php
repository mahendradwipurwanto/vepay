<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{
    // construct
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['M_transaksi']);

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

    public function getAjaxTransaksi()
    {
        $transaksi  = $this->M_transaksi->getAllTransaksi();
        $draw     = $this->input->post('draw');
        $search   = $this->input->post('search')['value'];
        $arr      = [];
        $no       = $this->input->post('start');

        foreach ($transaksi['records'] as $key => $val) {
            $arr[$key] = [
                "no"            => ++$no,
                "action"        => $val->action,
                "tanggal"       => $val->tanggal,
                "kode"          => $val->kode,
                "name"          => $val->name,
                "metode"        => $val->metode,
                "produk"        => $val->produk,
                "total"         => $val->total,
                "status"        => $val->status,
            ];
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $transaksi['totalRecords'],
            "recordsFiltered" => ($search != "" ? $transaksi['totalDisplayRecords'] : $transaksi['totalRecords']),
            "data" => $arr
        );

        echo json_encode($response);
    }

    public function getAjaxTransaksiReferral()
    {
        $transaksi  = $this->M_transaksi->getAllTransaksiReferral();
        $draw     = $this->input->post('draw');
        $search   = $this->input->post('search')['value'];
        $arr      = [];
        $no       = $this->input->post('start');

        foreach ($transaksi['records'] as $key => $val) {
            $arr[$key] = [
                "no"            => ++$no,
                "action"        => $val->action,
                "kode"          => $val->kode,
                "type"          => $val->type,
                "name"          => $val->name,
                "tanggal"       => $val->tanggal,
                "status"        => $val->status,
                "nominal"         => $val->nominal,
            ];
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $transaksi['totalRecords'],
            "recordsFiltered" => ($search != "" ? $transaksi['totalDisplayRecords'] : $transaksi['totalRecords']),
            "data" => $arr
        );

        echo json_encode($response);
    }

    public function getDetailProduct()
    {
        $product = $this->M_master->getDetailProduct($this->input->post('product_id'));
        if (!empty($product)) {
            $data['product']   = $product;
            $data['kategori'] = $this->M_master->getAllKategori();

            $this->load->view('admin/ajax/detail_product', $data);
        } else {
            echo "<center class='py-5'><h4>Terjadi kesalahan saat mencoba menampilkan data product!</h4></center>";
        }
    }

    public function getRateProduct()
    {
        $price_history              = $this->M_master->getRateProduct($this->input->post('product_id'));

        $data['price_history']      = $price_history;
        $data['m_product_id']       = $this->input->post('product_id');

        $this->load->view('admin/ajax/harga_product', $data);
    }

    public function getDetailPromo()
    {
        $promo                      = $this->M_master->getDetailPromo($this->input->post('promo_id'));

        $data['promo']              = $promo;

        $this->load->view('admin/ajax/edit_promo', $data);
    }

    public function getDetailMetode()
    {
        $metode                      = $this->M_master->getDetailMetode($this->input->post('metode_id'));

        $data['metode']              = $metode;

        $this->load->view('admin/ajax/edit_metode', $data);
    }

    public function getDetailTrans()
    {
        $transaksi                      = $this->M_transaksi->getDetailTransaksi($this->input->post('transaksi_id'));
        $data['transaksi']              = $transaksi;
        
        $this->load->view('admin/ajax/detail_transaksi', $data);
    }
    
    public function getDetailTransReferral()
    {
        $transaksi                      = $this->M_transaksi->getDetailTransaksiReferral($this->input->post('transaksi_id'));

        $data['transaksi']              = $transaksi;

        $this->load->view('admin/ajax/detail_transaksi_referral', $data);
    }
}
