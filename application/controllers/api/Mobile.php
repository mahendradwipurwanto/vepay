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

    function cek_session(){
        return $this->session->userdata('logged_in') === true ? true : false;
    }

    public function login_post()
    {
        if(!is_null($this->post('is_google')) && $this->post('is_google') == true){
            $validasi = [
                'email' => 'required'
            ];
        }else{
            $validasi = [
                'email' => 'required',
                'password' => 'required'
            ];
        }

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
            
            if (!is_null($this->post('is_google')) && $this->post('is_google') == true) {

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

				if (!empty($user)) {
					if(!is_null($user->photo) && isset($user->photo) && $user->photo !== ""){
						$user->photo = base_url().$user->photo;
					}else{
						$user->photo = base_url()."assets/images/profile.png";
					}
				}

                // Set the response and exit
                $this->response([
                    'status' => true,
                    'data' => $user
                ], 200);
            }

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

				if (!empty($user)) {
					if(!is_null($user->photo) && isset($user->photo) && $user->photo !== ""){
						$user->photo = base_url().$user->photo;
					}else{
						$user->photo = base_url()."assets/images/profile.png";
					}
				}

				if($user->status == 0){

                    // menghapus token permintaan lupa password sebelumnya
                    $this->M_auth->del_token($user->user_id, 1);

                    // create token for recovery
                    do {
                        $token = bin2hex(random_bytes(32));
                    } while ($this->M_auth->cek_tokenRecovery($token) == true);

                    $token = $token;
                    // atur data untuk menyimpan token recovery password
                    $data = [
                        'user_id' => $user->user_id,
                        'key' => $token,
                        'type' => 1, //1. Verifikasi
                        'date_created' => time()
                    ];

                    // simpan data token recovery password
                    $this->M_auth->insert_token($data);

					$subject = "Verifikasi email anda - Vepay";
					$message = "Hai, selamat bergabung dengan Vepay.id untuk mulai menggunakan akun anda verifikasi email dengan menekan tombol dibawah ini<br><br><a href='".base_url()."authentication/verifikasi_email/".$token."' class='btn btn-soft-primary'>Verifikasi Email</a>";

					sendMail($email, $subject, $message);

					$this->response([
						'status' => false,
						'data' => "Harap verifikasi email, email verifikasi telah dikirim ke email anda!"
					], 403);	
				}

                // Set the response and exit
                $this->response([
                    'status' => true,
                    'data' => $user
                ], 200);
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
        if(!is_null($this->post('is_google')) && $this->post('is_google') == true){
            $validasi = [
                'email' => 'required'
            ];
        }else{
            $validasi = [
                'email' => 'required',
                'password' => 'required',
                'nama' => 'required'
            ];
        }

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

            // cek apakahemailtelah digunakan
            if ($this->M_auth->get_auth($email) == false) {

                if(!is_null($this->post('is_google')) && $this->post('is_google') == true){
                    $params = [
                        'is_google' => true,
                        'email' => $email,
                        'nama' => $nama,
                    ];
                }else{
                    $params = [
                        'is_google' => false,
                        'email' => $email,
                        'password' => $password,
                        'nama' => $nama,
                        'phone' => $phone
                    ];
                }

                // mendaftarkan user ke sistem
                if ($this->M_api->register_user($params) == true) {


                    // mengambil data user dengan param email
                    $user = $this->M_auth->get_auth($email);

                    // menghapus token permintaan lupa password sebelumnya
                    $this->M_auth->del_token($user->user_id, 1);

                    // create token for recovery
                    do {
                        $token = bin2hex(random_bytes(32));
                    } while ($this->M_auth->cek_tokenRecovery($token) == true);

                    $token = $token;
                    // atur data untuk menyimpan token recovery password
                    $data = [
                        'user_id' => $user->user_id,
                        'key' => $token,
                        'type' => 1, //1. Verifikasi
                        'date_created' => time()
                    ];

                    // simpan data token recovery password
                    $this->M_auth->insert_token($data);

					if(is_null($this->post('is_google')) || $this->post('is_google') == false){

						$subject = "Verifikasi email anda - Vepay";
						$message = "Hai, selamat bergabung dengan Vepay.id untuk mulai menggunakan akun anda verifikasi email dengan menekan tombol dibawah ini<br><br><a href='".base_url()."authentication/verifikasi_email/".$token."' class='btn btn-soft-primary'>Verifikasi Email</a>";

						// mengirim email
						if (sendMail($email, $subject, $message) == true) {
							// mengambil data user dengan param email
							$user = $this->M_auth->get_auth($email);

							if (!empty($user)) {
								if(!is_null($user->photo) && isset($user->photo) && $user->photo !== ""){
									$user->photo = base_url().$user->photo;
								}else{
									$user->photo = base_url()."assets/images/profile.png";
								}
							}

							// Set the response and exit
							$this->response([
								'status' => true,
								'data' => $user
							], 200);
						} else {

							// Set the response and exit
							$this->response([
								'status' => false,
								'message' => 'Terjadi kesalahan saat mengirim email verifikasi'
							], 422);
						}
					}else{
						// mengambil data user dengan param email
						$user = $this->M_auth->get_auth($email);

						if (!empty($user)) {
							if(!is_null($user->photo) && isset($user->photo) && $user->photo !== ""){
								$user->photo = base_url().$user->photo;
							}else{
								$user->photo = base_url()."assets/images/profile.png";
							}
						}

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

    public function forgot_password_post(){

        $validasi = [
            'email' => 'required',
        ];
        \GUMP::set_field_name('email', 'Email');

        if (validate($this->get(), $validasi) === false) {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => validate($this->get(), $validasi)
            ], 422);
        }
        
        // mengambil data user dengan param email
        $user = $this->M_auth->get_auth($this->post('email'));

        if(!$user){
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Tidak dapat menemukan akun dengan email tersebut !'
            ], 422);
        }

		// menghapus token permintaan lupa password sebelumnya
		$this->M_auth->del_token($user->user_id, 2);

		// create token for recovery
		do {
			$token = bin2hex(random_bytes(32));
		} while ($this->M_auth->cek_tokenRecovery($token) == true);

		$token = $token;
		// atur data untuk menyimpan token recovery password
		$data = [
			'user_id' => $user->user_id,
			'key' => $token,
			'type' => 2, //2. CHANGE PASSWORD
			'date_created' => time()
		];

		// simpan data token recovery password
		$this->M_auth->insert_token($data);

        $subject = "Permintaan lupa password - Vepay";
        $message = "Hai, kami mendapatkan permintaan reset password atas akun anda. Anda dapat mengatur ulang password anda dengan menekan tombol dibawah ini<br><br><a href='".base_url()."reset-password/".$token."' class='btn btn-soft-primary'>Reset Password</a>";

        // mengirim email
        if (sendMail($user->email, $subject, $message) == true) {

            // Set the response and exit
            $this->response([
                'status' => true,
                'data' => "Berhasil mengirim link reset password ke email {$user->email}"
            ], 200);
        } else {

            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengirim reset password'
            ], 422);
        }
    }

    public function request_verifikasi_post(){

        $validasi = [
            'email' => 'required',
        ];
        \GUMP::set_field_name('email', 'Email');

        if (validate($this->get(), $validasi) === false) {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => validate($this->get(), $validasi)
            ], 422);
        }
        
        // mengambil data user dengan param email
        $user = $this->M_auth->get_auth($this->post('email'));

        if(!$user){
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Tidak dapat menemukan akun dengan email tersebut !'
            ], 422);
        }

        // menghapus token permintaan lupa password sebelumnya
        $this->M_auth->del_token($user->user_id, 1);

		// create token for recovery
		do {
			$token = bin2hex(random_bytes(32));
		} while ($this->M_auth->cek_tokenRecovery($token) == true);

		$token = $token;
		// atur data untuk menyimpan token recovery password
		$data = [
			'user_id' => $user->user_id,
			'key' => $token,
			'type' => 1, //1. Verifikasi
			'date_created' => time()
		];

		// simpan data token recovery password
		$this->M_auth->insert_token($data);

        $subject = "Verifikasi email anda - Vepay";
        $message = "Hai, selamat bergabung dengan Vepay.id untuk mulai menggunakan akun anda verifikasi email dengan menekan tombol dibawah ini<br><br><a href='".base_url()."authentication/verifikasi_email/".$token."' class='btn btn-soft-primary'>Verifikasi Email</a>";

        // mengirim email
        if (sendMail($this->post('email'), $subject, $message) == true) {
            // mengambil data user dengan param email
            $user = $this->M_auth->get_auth($this->post('email'));

            // Set the response and exit
            $this->response([
                'status' => true,
                'data' => "Berhasil mengirim link verifikasi ke email"
            ], 200);
        } else {

            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengirim email verifikasi'
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
                    $val->photo = base_url()."assets/images/profile.png";
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
                $member->photo = base_url()."assets/images/profile.png";
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

        if(validate($this->put(), $validasi) === false){
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

			$member = $this->M_api->getDetailMember($user_id);

			if (!empty($member)) {
				if(!is_null($member->photo) && isset($member->photo) && $member->photo !== ""){
					$member->photo = base_url().$member->photo;
				}else{
					$member->photo = base_url()."assets/images/profile.png";
				}
			}
            if($result == true){
                // Set the response and exit
                $this->response([
                    'status' => true,
                    'data' => $member
                ], 200);
            }else{
                // Set the response and exit
                $this->response([
                    'status' => true,
                    'data' => $member
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
                    $val->image = base_url()."assets/images/profile.png";
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
                $product->image = base_url()."assets/images/profile.png";
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
                    $val->image = base_url()."assets/images/profile.png";
                }
				if($val->maksimal_promo > 0){
					$val->maksimal_promo = (float) $val->maksimal_promo;
				}else{
                    $val->maksimal_promo = (float) 0;
                }
                $val->value = (float) $val->value;
                $val->quota = is_null($val->quota) ? 'unlimited' : $val->quota;
				$val->jenis_pengguna_txt = $val->jenis_pengguna == 0 ? "Semua Pengguna" : "Penguna Baru";
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

        // $validasi = [
        //     'id' => 'required',
        // ];
        // \GUMP::set_field_name('id', 'ID Promo');

        // if (validate($this->get(), $validasi) === false) {
        //     // Set the response and exit
        //     $this->response([
        //         'status' => false,
        //         'message' => validate($this->get(), $validasi)
        //     ], 422);
        // }

        $id = $this->get('id');
        $kode = $this->get('kode');
        $promo = $this->M_api->getDetailPromo($id, $kode);

        if (!empty($promo)) {
			if($promo->quota <= 0 && !is_null($promo->quota)){
				// Set the response and exit
				$this->response([
					'status' => false,
					'message' => "Mohon maaf quota untuk promo ini telah mencapai batas"
				], 422);
			}
			
			if($promo->expired < time()){
				// Set the response and exit
				$this->response([
					'status' => false,
					'message' => "Mohon maaf promo telah kadaluarsa"
				], 422);
			}

            if(!is_null($promo->image)){
                $promo->image = base_url().$promo->image;
            }else{
                $promo->image = base_url()."assets/images/profile.png";
            }
			
			if($promo->maksimal_promo > 0){
				$promo->maksimal_promo = (float) $promo->maksimal_promo;
			}else{
                $promo->maksimal_promo = (float) 0;
            }
            $promo->value = (float) $promo->value;
            $promo->quota = is_null($promo->quota) ? 'unlimited' : $promo->quota;
            
			$promo->jenis_pengguna_txt = $promo->jenis_pengguna == 0 ? "Semua Pengguna" : "Penguna Baru";
            // Set the response and exit
            $this->response([
                'status' => true,
                'data' => $promo
            ], 200);
        } else {

			$kode = isset($kode) ? "kode" : "id";

            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => "Promo dengan {$kode} tersebut tidak tersedia"
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
                    $val->image = base_url()."assets/images/profile.png";
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

    public function get_all_withdraw_get()
    {

        $params = [
            'limit' => $this->get('limit')
        ];

        $withdraw = $this->M_api->getAllWithdraw($params);

        if (!empty($withdraw)) {
            foreach ($withdraw as $key => $val) {
                if(!is_null($val->image)){
                    $val->image = base_url().$val->image;
                }else{
                    $val->image = base_url()."assets/images/profile.png";
                }
            }
            // Set the response and exit
            $this->response([
                'status' => true,
                'data' => $withdraw
            ], 200);
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Tidak ada withdraw yang tersedia'
            ], 422);
        }   
    }

    public function get_all_blockchain_get()
    {

        $params = [
            'limit' => $this->get('limit')
        ];

        $blockchain = $this->M_api->getAllBlockchain($params);

        if (!empty($blockchain)) {
            // Set the response and exit
            $this->response([
                'status' => true,
                'data' => $blockchain
            ], 200);
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Tidak ada blockchain yang tersedia'
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
                    $val->image = base_url()."assets/images/profile.png";
                }
                if(!is_null($val->categories)){
                    $val->categories = strtolower($val->categories);
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

        $params = [
            'limit' => $this->get('limit'),
            'user_id' => $this->get('user_id')
        ];

        $vcc = $this->M_api->getAllVcc($params);

        if (!empty($vcc)) {
            foreach ($vcc as $key => $val) {
                if(!is_null($val->photo)){
                    $val->photo = base_url().$val->photo;
                }else{
                    $val->photo = base_url()."assets/images/profile.png";
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
                $vcc->photo = base_url()."assets/images/profile.png";
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

        $params = [
            'user_id' => $this->get('user_id'),
            'type' => $this->get('type'),
            'product' => $this->get('product'),
            'start_date' => $this->get('start_date'),
            'end_date' => $this->get('end_date'),
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
                if(!is_null($val->img_product)){
                    $val->img_product = base_url().$val->img_product;
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
            if(!is_null($transaction->img_product)){
                $transaction->img_product = base_url().$transaction->img_product;
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
            'm_rate_id' => 'required',
            'jumlah' => 'required',
            'sub_total' => 'required',
            'total_bayar' => 'required'
        ];
        \GUMP::set_field_name('user_id', 'User ID');
        \GUMP::set_field_name('m_rate_id', 'Rate Harga');
        \GUMP::set_field_name('jumlah', 'Jumlah Pembelian');
        \GUMP::set_field_name('sub_total', 'Sub Total');
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
            'account' => $this->post('akun_tujuan'),
            'no_tujuan' => $this->post('no_tujuan'),
            'no_rek' => $this->post('no_rek'),
            'm_blockchain_id' => $this->post('blockchain'),
            'm_vcc_id' => $this->post('id_vcc'),
            'jenis_transaksi_vcc' => $this->post('jenis_transaksi_vcc'),
            'm_metode_id' => $this->post('m_metode_id'),
            'm_promo_id' => $this->post('m_promo_id'),
            'sub_total' => $this->post('total_bayar'),
            'created_by' => $this->post('user_id'),
            'created_at' => time()
        ];

        $body_detail = [
            'm_price_id' => $this->post('m_rate_id'),
            'quantity' => $this->post('jumlah'),
            'total' => $this->post('sub_total'),
            'created_by' => $this->post('user_id'),
            'created_at' => time()
        ];

        $transaksi = $this->M_api->create_transaction($body_transaction, $body_detail);
        
        if($transaksi['status'] === true){
            
            if(!is_null($transaksi['data']->bukti)){
                $transaksi['data']->bukti = base_url().$transaksi['data']->bukti;
            }
            if(!is_null($transaksi['data']->img_method)){
                $transaksi['data']->img_method = base_url().$transaksi['data']->img_method;
            }
            if(!is_null($transaksi['data']->img_product)){
                $transaksi['data']->img_product = base_url().$transaksi['data']->img_product;
            }

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
            'bukti' => 'required',
            'user_id' => 'required'
        ];
        \GUMP::set_field_name('id', 'ID Transaksi');
        \GUMP::set_field_name('bukti', 'Bukti Transfer');
        \GUMP::set_field_name('user_id', 'User ID');

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
            $path = "berkas/user/{$this->post('user_id')}/transaksi/{$id}/";

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
                'modified_by' => $this->post('user_id'),
                'modified_at' => time()
            ];

            $transaksi = $this->M_api->bayar_transaction($id, $body);
            
            if($transaksi['status'] === true){
            
                if(!is_null($transaksi['data']->bukti)){
                    $transaksi['data']->bukti = base_url().$transaksi['data']->bukti;
                }
                if(!is_null($transaksi['data']->img_method)){
                    $transaksi['data']->img_method = base_url().$transaksi['data']->img_method;
                }
                if(!is_null($transaksi['data']->img_product)){
                    $transaksi['data']->img_product = base_url().$transaksi['data']->img_product;
                }
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
    
    public function delete_transaction_delete($id)
    {

        if (!isset($id)) {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => "Id transaksi tidak dikenali"
            ], 422);
        }

        $transaction = $this->M_api->delete_transaction($id);

        if (!empty($transaction)) {
            // Set the response and exit
            $this->response([
                'status' => true,
                'message' => 'Berhasil menghapus transaksi dengan id '.$id
            ], 200);
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'VCC dengan id tersebut tidak tersedia'
            ], 422);
        }

    }
}
