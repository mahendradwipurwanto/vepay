<?php
header("Access-Control-Allow-Origin: *");
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Mobile extends RestController
{
    public function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('M_api');
    }

    public function get_all_members_get()
    {
        $member = $this->M_api->getAllMembers();

        if (!empty($member)) {
            // Set the response and exit
            $this->response([
                'status' => true,
                'data' => $member
            ], 200);
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Tidak ada member yang terdaftar'
            ], 404);
        }

    }
    
    public function get_detail_member_get()
    {
        $user_id = $this->get('user_id');
        $member = $this->M_api->getDetailMember($user_id);

        if (!empty($member)) {
            // Set the response and exit
            $this->response([
                'status' => true,
                'data' => $member
            ], 200);
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Member dengan id tersebut tidak terdaftar'
            ], 404);
        }

    }

    public function get_all_products_get()
    {
        $products = $this->M_api->getAllProducts();

        if (!empty($products)) {
            // Set the response and exit
            $this->response([
                'status' => true,
                'data' => $products
            ], 200);
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Tidak ada produk yang tersedia'
            ], 404);
        }

    }
    
    public function get_detail_product_get()
    {
        $id = $this->get('id');
        $product = $this->M_api->getDetailProduct($id);

        if (!empty($product)) {
            // Set the response and exit
            $this->response([
                'status' => true,
                'data' => $product
            ], 200);
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Produk dengan id tersebut tidak tersedia'
            ], 404);
        }

    }

    public function get_all_promo_get()
    {
        $promo = $this->M_api->getAllPromo();

        if (!empty($promo)) {
            // Set the response and exit
            $this->response([
                'status' => true,
                'data' => $promo
            ], 200);
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Tidak ada promo yang tersedia'
            ], 404);
        }

    }
    
    public function get_detail_promo_get()
    {
        $id = $this->get('id');
        $promo = $this->M_api->getDetailPromo($id);

        if (!empty($promo)) {
            // Set the response and exit
            $this->response([
                'status' => true,
                'data' => $promo
            ], 200);
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Promo dengan id tersebut tidak tersedia'
            ], 404);
        }

    }

    public function get_all_metode_get()
    {
        $metode = $this->M_api->getAllMetode();

        if (!empty($metode)) {
            // Set the response and exit
            $this->response([
                'status' => true,
                'data' => $metode
            ], 200);
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Tidak ada metode yang tersedia'
            ], 404);
        }

    }
}
