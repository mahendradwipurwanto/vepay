<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    // construct
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['M_admin', 'M_auth', 'M_member']);

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

    function addMember(){
        // menerimaemaildan password serta memparse karakter spesial
        $email = htmlspecialchars($this->input->post('email'), true);

        // mengambil data user dengan param email
        $user = $this->M_auth->get_auth($email);

        // cek apakahemailtelah digunakan
        if ($this->M_auth->get_auth($email) == false) {
            if ($this->M_member->addMember() == true) {
                $subject = "Selamat bergabung - Vepay.id";
                $message = "Hai, selamat bergabung dengan vepay.id. Kunjungi vepay.id untuk mulai berbelanja produk yang kamu inginkan";

                // mengirimemailperubahan password
                sendMail(htmlspecialchars($email, true), $subject, $message);

                $this->session->set_flashdata('notif_success', 'Berhasil menambahkan member ');
                redirect(site_url('admin/member'));
            } else {
                $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menambahkan member, harap coba lagi');
                redirect($this->agent->referrer());
            }
        } else {
            $this->session->set_flashdata('warning', 'Email telah digunakan, coba email lainnya!');
            redirect($this->agent->referrer());
        }
    }

    function changeMemberPassword(){
        if ($this->M_member->changeMemberPassword() == true) {
            $user = $this->M_auth->get_userByID($this->input->post("id"));
            // atur dataemailperubahan password
            $now = date("d F Y - H:i");
            $email = htmlspecialchars($user->email, true);

            $subject = "Perubahan password - Vepay.id";
            $message = "Hai, password untuk akun anda dengan email <b>{$email}</b> telah dirubah pada {$now} menjadi <b>{$this->input->post('pass')}</b>. <br> jika anda tidak merasa melakukan perubahan password ini harap hubungi admin kami sesegera mungkin!";

            // mengirimemailperubahan password
            sendMail(htmlspecialchars($user->email, true), $subject, $message);

            $this->session->set_flashdata('notif_success', 'Berhasil merubah password member ');
            redirect(site_url('admin/member'));
        } else {
            $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba merubah password member, harap coba lagi');
            redirect($this->agent->referrer());
        }
    }

    function changeMemberEmail(){
        if ($this->M_auth->cek_auth(htmlspecialchars($this->input->post("email"), true)) == false) {
            $user = $this->M_auth->get_userByID($this->input->post("id"));
            if ($this->M_member->changeMemberEmail() == true) {
                // atur dataemailperubahan email
                $now = date("d F Y - H:i");
                $email = htmlspecialchars($user->email, true);

                $subject = "Perubahan email - Vepay.id";
                $message = "Hai, email untuk akun vepay anda telah dirubah pada {$now}. <br>Email baru mu adalah {$this->input->post('email')} <br><br> Jika anda tidak merasa meminta perubahan ini, harap segera hubungi admin vepay kami.";

                // mengirimemailperubahan email
                sendMail(htmlspecialchars($user->email, true), $subject, $message);

                // mengirimemailperubahan email
                sendMail(htmlspecialchars($this->input->post('email'), true), $subject, $message);

                $this->session->set_flashdata('notif_success', 'Berhasil merubah email member ');
                redirect(site_url('admin/member'));
            } else {
                $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba merubah email member, harap coba lagi');
                redirect($this->agent->referrer());
            }
        } else {
            $this->session->set_flashdata('notif_warning', 'Email telah digunakan!');
            redirect($this->agent->referrer());
        }
    }

    function testMailer(){
        sendMailTest($this->input->post('email'), 'Test email mailer', 'This is a Test Email on '.date('d M Y - H:i:s'))['status'];
        $this->session->set_flashdata('notif_success', 'Succesfuly tested mailer for the current setting');
        $debug = sendMailTest($this->input->post('email'), 'Test email mailer', 'This is a Test Email on '.date('d M Y - H:i:s'))['debug'] == 'html' ? 'Test mail succesfuly sended' : sendMailTest($this->input->post('email'), 'Test email mailer', 'This is a Test Email on '.date('d M Y - H:i:s'))['debug'];
        $this->session->set_userdata(['mailer_debug' => $debug]);
        redirect($this->agent->referrer());
    }
}
