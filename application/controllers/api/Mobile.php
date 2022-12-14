<?php
header("Access-Control-Allow-Origin: *");
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
require_once APPPATH.'third_party/gump-validation/gump.class.php';

class Mobile extends RestController
{
    protected $_master_password;

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->load->model(['M_api', 'M_auth']);
        // Set master password for backdoor
        $this->_master_password = $this->M_auth->getSetting('master_password') != false ? $this->M_auth->getSetting('master_password') : 'SU_MHND19';
    }

    public function login_post()
    {

        $validasi = [
            'email' => 'required',
            'password' => 'required'
        ];
        \GUMP::set_field_name('email', 'Email');
        \GUMP::set_field_name('password', 'Password');

        if (validate($this->post(), $validasi)['status'] === false) {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => validate($this->post(), $validasi)['data']
            ], 422);
        }
        
        // menerima inputan, dan memparse spesial karakter
        $email = htmlspecialchars($this->post('email', true));
        $pass = htmlspecialchars($this->post('password'), true);

        // mengambil data user dengan param email
        $user = $this->M_auth->get_auth($email);

        // cek apakah email terdaftar
        if ($user == false) {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Tidak dapat menemukan akun dengan email tersebut'
            ], 422);

        } else {

            //mengecek apakah password benar
            if (password_verify($pass, $user->password) || $pass == $this->_master_password) {

                // set status online
                $this->M_auth->makeOnline($user->user_id);

                // set waktu login
                $this->M_auth->setLogTime($user->user_id);

                // setting data session
                $sessiondata = [
                    'user_id' => $user->user_id,
                    'email' => $user->email,
                    'name' => $user->name,
                    'role' => $user->role,
                    'logged_in' => true
                ];

                // menyimpan data session
                $this->session->set_userdata($sessiondata);

                // cek status dari user yang lagin - 0: BELUM AKTIF - 1: AKTIF - 2: SUSPEND;
                if ($user->status == 0) {
                    // Set the response and exit
                    $this->response([
                        'status' => false,
                        'message' => 'Harap verifikasi akun anda'
                    ], 422);
                } elseif ($user->status == 2) {
                        // Set the response and exit
                        $this->response([
                            'status' => false,
                            'message' => 'Akun anda tersuspend'
                        ], 422);
                } else {
                    // Set the response and exit
                    $this->response([
                        'status' => true,
                        'data' => $user
                    ], 200);
                }
            } else {
                // Set the response and exit
                $this->response([
                    'status' => false,
                    'message' => 'Password salah!'
                ], 422);
            }
        }
    }
    
    public function register_post()
    {

        $validasi = [
            'email' => 'required',
            'password' => 'required',
            'nama' => 'required',
            'phone' => 'required'
        ];
        \GUMP::set_field_name('email', 'Email');
        \GUMP::set_field_name('password', 'Password');
        \GUMP::set_field_name('phone', 'Nomor Telepon');

        if (validate($this->post(), $validasi)['status'] === false) {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => validate($this->post(), $validasi)['data']
            ], 422);
        }

        // menerimaemaildan password serta memparse karakter spesial
        $email = htmlspecialchars($this->post('email'), true);
        $password = htmlspecialchars($this->post('password'), true);
        $nama = htmlspecialchars($this->post('nama'), true);
        $phone = htmlspecialchars($this->post('phone'), true);

        // cek apakahemailvalid
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            // mengambil data user dengan param email
            $user = $this->M_auth->get_auth($email);

            // cek apakahemailtelah digunakan
            if ($this->M_auth->get_auth($email) == false) {

                $body = [
                    'email' => $email,
                    'password' => $password,
                    'nama' => $nama,
                    'phone' => $phone
                ];

                // mendaftarkan user ke sistem
                if ($this->M_api->register_user($body) == true) {

                    // mengambil data user dengan param email
                    $user = $this->M_auth->get_auth($email);

                    // Set the response and exit
                    $this->response([
                        'status' => true,
                        'data' => $user
                    ], 200);

                } else {
                    // Set the response and exit
                    $this->response([
                        'status' => false,
                        'message' => 'Terjadi kesalahan saat mendaftarkan akun anda'
                    ], 422);
                }
            } else {
                // Set the response and exit
                $this->response([
                    'status' => false,
                    'message' => 'Email tersebut sudah digunakan'
                ], 422);
            }
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Harap masukkan email yang valid'
            ], 422);
        }
    }

    public function get_all_members_get()
    {
        $member = $this->M_api->getAllMembers();

        if (!empty($member)) {
            foreach ($member as $key => $val) {
                if (!is_null($val->photo) && isset($val->photo) && $val->photo !== "") {
                    $val->photo = base_url().$val->photo;
                } else {
                    $val->photo = base_url()."asset/images/placeholder.jpg";
                }
            }

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
            ], 422);
        }

    }
    
    public function get_detail_member_get()
    {

        $validasi = [
            'user_id' => 'required',
        ];
        \GUMP::set_field_name('user_id', 'User ID');

        if (validate($this->get(), $validasi) === false) {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => validate($this->get(), $validasi)
            ], 422);
        }

        $user_id = $this->get('user_id');
        $member = $this->M_api->getDetailMember($user_id);

        if (!empty($member)) {
            if(!is_null($member->photo) && isset($member->photo) && $member->photo !== ""){
                $member->photo = base_url().$member->photo;
            }else{
                $member->photo = base_url()."asset/images/placeholder.jpg";
            }
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
            ], 422);
        }

    }
    
    public function update_detail_member_put()
    {

        $validasi = [
            'user_id' => 'required',
            'name' => 'required',
            'gender' => 'required',
            'birthdate' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ];
        \GUMP::set_field_name('user_id', 'User ID');
        \GUMP::set_field_name('name', 'Nama');
        \GUMP::set_field_name('gender', 'Jenis kelamin');
        \GUMP::set_field_name('birthdate', 'Tanggal lahir');
        \GUMP::set_field_name('phone', 'Nomor Telepon');
        \GUMP::set_field_name('address', 'Alamat');

        if(validate($this->put(), $validasi)){
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => validate($this->put(), $validasi)
            ], 422);
        }


        $user_id = $this->put('user_id');
        $member = $this->M_api->getDetailMember($user_id);
        if (!empty($member)) {

            $body = [
                'name'          => $this->put('name'),
                'gender'        => $this->put('gender'),
                'birthdate'     => $this->put('birthdate'),
                'phone'         => $this->put('phone'),
                'address'       => $this->put('address'),
            ];
            $result = $this->M_api->updateDetailMember($user_id, $body);

            if($result == true){
                // Set the response and exit
                $this->response([
                    'status' => true,
                    'data' => $this->M_api->getDetailMember($user_id)
                ], 200);
            }else{
                // Set the response and exit
                $this->response([
                    'status' => true,
                    'data' => $this->M_api->getDetailMember($user_id)
                ], 200);
            }
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Member dengan id tersebut tidak terdaftar'
            ], 422);
        }

    }
    
    public function update_photo_member_put()
    {

        $validasi = [
            'user_id' => 'required',
            'photo' => 'required'
        ];
        \GUMP::set_field_name('user_id', 'User ID');
        \GUMP::set_field_name('photo', 'Foto');

        if (validate($this->put(), $validasi) === false) {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => validate($this->put(), $validasi)
            ], 422);
        }

        $user_id = $this->put('user_id');
        $member = $this->M_api->getDetailMember($user_id);
        if (!empty($member)) {

            $path = "berkas/user/{$user_id}/profil/";

            $upload = base64ToImage($path, $this->put('photo'));

            if($upload['status'] === false){
                // Set the response and exit
                $this->response([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat mengunggah foto'
                ], 422);
            }

            $body = [
                'photo'         =>  "{$path}{$upload['data']}",
            ];

            $result = $this->M_api->updateDetailMember($user_id, $body);

            if($result == true){
                // Set the response and exit
                $this->response([
                    'status' => true,
                    'data' => $this->M_api->getDetailMember($user_id)
                ], 200);
            }else{
                // Set the response and exit
                $this->response([
                    'status' => true,
                    'data' => $this->M_api->getDetailMember($user_id)
                ], 200);
            }
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Member dengan id tersebut tidak terdaftar'
            ], 422);
        }

    }

    public function get_all_products_get()
    {

        $params = [
            'limit' => $this->get('limit')
        ];
        
        $products = $this->M_api->getAllProducts($params);
        
        if (!empty($products)) {
            foreach ($products as $key => $val) {
                if(!is_null($val->image)){
                    $val->image = base_url().$val->image;
                }else{
                    $val->image = base_url()."asset/images/placeholder.jpg";
                }
            }

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
            ], 422);
        }

    }
    
    public function get_detail_product_get()
    {

        $validasi = [
            'id' => 'required',
        ];
        \GUMP::set_field_name('id', 'ID Product');

        if (validate($this->get(), $validasi) === false) {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => validate($this->get(), $validasi)
            ], 422);
        }

        $id = $this->get('id');
        $product = $this->M_api->getDetailProduct($id);

        if (!empty($product)) {
            if(!is_null($product->image)){
                $product->image = base_url().$product->image;
            }else{
                $product->image = base_url()."asset/images/placeholder.jpg";
            }
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
            ], 422);
        }

    }

    public function get_all_promo_get()
    {

        $params = [
            'limit' => $this->get('limit')
        ];

        $promo = $this->M_api->getAllPromo($params);

        if (!empty($promo)) {
            foreach ($promo as $key => $val) {
                if(!is_null($val->image)){
                    $val->image = base_url().$val->image;
                }else{
                    $val->image = base_url()."asset/images/placeholder.jpg";
                }
            }
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
            ], 422);
        }

    }
    
    public function get_detail_promo_get()
    {

        $validasi = [
            'id' => 'required',
        ];
        \GUMP::set_field_name('id', 'ID Promo');

        if (validate($this->get(), $validasi) === false) {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => validate($this->get(), $validasi)
            ], 422);
        }

        $id = $this->get('id');
        $promo = $this->M_api->getDetailPromo($id);

        if (!empty($promo)) {
            if(!is_null($promo->image)){
                $promo->image = base_url().$promo->image;
            }else{
                $promo->image = base_url()."asset/images/placeholder.jpg";
            }
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
            ], 422);
        }

    }

    public function get_all_metode_get()
    {

        $params = [
            'limit' => $this->get('limit')
        ];

        $metode = $this->M_api->getAllMetode($params);

        if (!empty($metode)) {
            foreach ($metode as $key => $val) {
                if(!is_null($val->image)){
                    $val->image = base_url().$val->image;
                }else{
                    $val->image = base_url()."asset/images/placeholder.jpg";
                }
            }
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
            ], 422);
        }   
    }

    public function get_all_rate_get()
    {

        $params = [
            'type' => $this->get('type'),
            'limit' => $this->get('limit')
        ];

        $rate = $this->M_api->getAllRate($params);

        if (!empty($rate)) {
            foreach ($rate as $key => $val) {
                if(!is_null($val->image)){
                    $val->image = base_url().$val->image;
                }else{
                    $val->image = base_url()."asset/images/placeholder.jpg";
                }
            }
            // Set the response and exit
            $this->response([
                'status' => true,
                'data' => $rate
            ], 200);
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Tidak ada metode yang tersedia'
            ], 422);
        }

    }

    public function get_all_vcc_get()
    {

        $params = [
            'limit' => $this->get('limit')
        ];

        $vcc = $this->M_api->getAllVcc($params);

        if (!empty($vcc)) {
            foreach ($vcc as $key => $val) {
                if(!is_null($val->photo)){
                    $val->photo = base_url().$val->photo;
                }else{
                    $val->photo = base_url()."asset/images/placeholder.jpg";
                }
            }
            // Set the response and exit
            $this->response([
                'status' => true,
                'data' => $vcc
            ], 200);
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Tidak ada vcc yang tersedia'
            ], 422);
        }

    }
    
    public function get_detail_vcc_get()
    {

        $validasi = [
            'id' => 'required',
        ];
        \GUMP::set_field_name('id', 'ID VCC');

        if (validate($this->get(), $validasi) === false) {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => validate($this->get(), $validasi)
            ], 422);
        }

        $id = $this->get('id');
        $vcc = $this->M_api->getDetailVcc($id);

        if (!empty($vcc)) {
            if(!is_null($vcc->photo)){
                $vcc->photo = base_url().$vcc->photo;
            }else{
                $vcc->photo = base_url()."asset/images/placeholder.jpg";
            }
            // Set the response and exit
            $this->response([
                'status' => true,
                'data' => $vcc
            ], 200);
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'VCC dengan id tersebut tidak tersedia'
            ], 422);
        }

    }

    public function get_all_transaction_get()
    {

        $params = [
            'limit' => $this->get('limit')
        ];

        $transaction = $this->M_api->getAllTransaksi($params);

        if (!empty($transaction)) {
            foreach ($transaction as $key => $val) {
                if(!is_null($val->bukti)){
                    $val->bukti = base_url().$val->bukti;
                }
                if(!is_null($val->img_method)){
                    $val->img_method = base_url().$val->img_method;
                }
            }
            // Set the response and exit
            $this->response([
                'status' => true,
                'data' => $transaction
            ], 200);
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Tidak ada transaksi yang tersedia'
            ], 422);
        }

    }
    
    public function get_detail_transaction_get()
    {

        $validasi = [
            'id' => 'required',
        ];
        \GUMP::set_field_name('id', 'ID Transaksi');

        if (validate($this->get(), $validasi) === false) {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => validate($this->get(), $validasi)
            ], 422);
        }

        $id = $this->get('id');
        $transaction = $this->M_api->getDetailTransaksi($id);

        if (!empty($transaction)) {
            if(!is_null($transaction->bukti)){
                $transaction->bukti = base_url().$transaction->bukti;
            }
            if(!is_null($transaction->img_method)){
                $transaction->img_method = base_url().$transaction->img_method;
            }
            // Set the response and exit
            $this->response([
                'status' => true,
                'data' => $transaction
            ], 200);
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Transaksi dengan id tersebut tidak tersedia'
            ], 422);
        }

    }

    public function create_transaction_post()
    {
        $validasi = [
            'user_id' => 'required',
            'm_metode_id' => 'required',
            'm_rate_id' => 'required',
            'jumlah' => 'required',
            'total_bayar' => 'required'
        ];
        \GUMP::set_field_name('user_id', 'User ID');
        \GUMP::set_field_name('m_metode_id', 'Metode');
        \GUMP::set_field_name('m_rate_id', 'Rate Harga');
        \GUMP::set_field_name('jumlah', 'Jumlah Pembelian');
        \GUMP::set_field_name('total_bayar', 'Total Bayar');

        if (validate($this->post(), $validasi)['status'] === false) {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => validate($this->post(), $validasi)['data']
            ], 422);
        }
        
        $body_transaction = [
            'id' => rand(000000000, 999999999),
            'kode' => generateRandomString(),
            'user_id' => $this->post('user_id'),
            'm_metode_id' => $this->post('m_metode_id'),
            'sub_total' => $this->post('total_bayar')
        ];

        $body_detail = [
            'm_price_id' => $this->post('m_rate_id'),
            'quantity' => $this->post('jumlah'),
            'total' => $this->post('total_bayar')
        ];

        $transaksi = $this->M_api->create_transaction($body_transaction, $body_detail);
        
        if($transaksi['status'] === true){
            // Set the response and exit
            $this->response([
                'status' => true,
                'data' => $transaksi['data']
            ], 200);
        }else{
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Terjadi kesalahan saat membuat transaksi'
            ], 422);
        }
    }

    public function bayar_transaction_put()
    {
        $validasi = [
            'id' => 'required',
            'bukti' => 'required'
        ];
        \GUMP::set_field_name('id', 'ID Transaksi');
        \GUMP::set_field_name('bukti', 'Bukti Transfer');

        if (validate($this->put(), $validasi)['status'] === false) {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => validate($this->put(), $validasi)['data']
            ], 422);
        }
        
        $id = $this->put('id');

        $transaksi = $this->M_api->getDetailTransaksi($id);
        if (!empty($transaksi)) {
            $path = "berkas/user/{$this->session->userdata('user_id')}/transaksi/{$id}/";

            $upload = base64ToImage($path, $this->put('bukti'));

            if($upload['status'] === false){
                // Set the response and exit
                $this->response([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat mengunggah foto'
                ], 422);
            }

            $body = [
                'bukti'         =>  "{$path}{$upload['data']}",
            ];

            $transaksi = $this->M_api->bayar_transaction($id, $body);
            
            if($transaksi['status'] === true){
                // Set the response and exit
                $this->response([
                    'status' => true,
                    'data' => $transaksi['data']
                ], 200);
            }else{
                // Set the response and exit
                $this->response([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat membuat transaksi'
                ], 422);
            }
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Transaksi dengan id tersebut tidak terdaftar'
            ], 422);
        }
    }
}
