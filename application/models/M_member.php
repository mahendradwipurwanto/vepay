<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_member extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('M_auth');
    }

    public function getAllMemberSelect(){
        $this->db->select('*')
        ->from('tb_auth a')
        ->join('tb_user b', 'a.user_id = b.user_id')
        ->where(['a.is_deleted' => 0, 'a.role' => 2])
        ;

        $models = $this->db->get()->result();

        return $models;
    }

    public function getAllMember(){

        $offset = $this->input->post('start');
        $limit  = $this->input->post('length'); // Rows display per page
        
        $filter = [];

        $filterEmail = $this->input->post('filterEmail');  
        $filterName = $this->input->post('filterName');  
        $filterNumber = $this->input->post('filterNumber');   

        if($filterEmail != null || $filterEmail != '') $filter[] = "a.email like '%{$filterEmail}%'";
        if($filterName != null || $filterName != '') $filter[] = "b.name like '%{$filterName}%'";
        if($filterNumber != null || $filterNumber != '') $filter[] = "b.phone like '%{$filterNumber}%'";

        if($filter != null){
            $filter = implode(' AND ', $filter);
        }  

        $this->db->select('a.status as auth_status, a.email, b.*')
        ->from('tb_auth a')
        ->join('tb_user b', 'a.user_id = b.user_id', 'inner')
        ->where(['a.role' => 2, 'a.is_deleted' => 0])
        ;

        $this->db->where($filter);
        $this->db->order_by('b.name ASC');

        // $this->db->limit($limit)->offset($offset);

        $models = $this->db->get()->result();

        foreach($models as $key => $val){
            
            $btnDetail      = '<button onclick="showMdlMemberDetail(\''.$val->user_id.'\')" class="btn btn-soft-info btn-icon btn-sm me-2"><i class="bi-eye"></i></button>';
            $btnPass        = '<button onclick="showMdlChangePassword(\''.$val->user_id.'\')" class="btn btn-soft-primary btn-icon btn-sm me-2"><i class="bi-key"></i></button>';
            $btnEmail       = '<button onclick="showMdlChangeEmail(\''.$val->user_id.'\')" class="btn btn-soft-warning btn-icon btn-sm me-2"><i class="bi-envelope"></i></button>';
            $btnVerif       = '<button onclick="showMdlVerifEmail(\''.$val->user_id.'\', \''.$val->name.'\')" class="btn btn-soft-warning btn-icon btn-sm me-2"><i class="bi-check"></i></button>';
            $btnDelete      = '<button onclick="showMdlDelete(\''.$val->user_id.'\', \''.$val->name.'\')" class="btn btn-soft-danger btn-icon btn-sm me-2"><i class="bi-trash"></i></button>';

            $strip_email                    = explode("@", $val->email);
            $models[$key]->name             = is_null($val->name) || $val->name == "" ? $strip_email[0] : $val->name;
            $models[$key]->phone            = isset($val->phone) && !is_null($val->phone) ? "+62{$val->phone}" : "<span class='badge bg-warning'>belum diatur</span>";
    
            if($val->auth_status == 1){
                $models[$key]->status  = '<span class="badge bg-soft-success">Aktif</span>';
            }elseif($val->auth_status == 2){
                $models[$key]->status  = '<span class="badge bg-soft-warning">Suspended</span>';
            }else{
                $models[$key]->status  = '<span class="badge bg-soft-secondary">Belum verifikasi email</span>';
            }
            
            $models[$key]->action = $btnDetail.$btnPass.($val->auth_status > 0 ? $btnEmail : $btnVerif).$btnDelete;
        }

        $totalRecords = count($models);

        $models = array_slice($models, $offset, $limit);

        return ['records' => array_values($models), 'totalDisplayRecords' => count($models), 'totalRecords' => $totalRecords];
    }

    function getDetailMember($user_id = null){
        $this->db->select('a.user_id, a.email, a.online, a.device, a.log_time, a.created_at, b.name, b.gender, b.phone, b.address')
        ->from('tb_auth a')
        ->join('tb_user b', 'a.user_id = b.user_id')
        ->where(['a.user_id' => $user_id])
        ;

        $model = $this->db->get()->row();
        $strip_email        = explode("@", $model->email);
        $model->name        = is_null($model->name) || $model->name == "" ? $strip_email[0] : $model->name;
        $model->whatsapp    = isset($model->phone) && !is_null($model->phone) ? "+62{$model->phone}" : "<span class='badge bg-warning'>belum diatur</span>";
        $model->gender      = isset($model->gender) && !is_null($model->gender) ? $model->gender : "<span class='badge bg-warning'>belum diatur</span>";
        $model->address     = isset($model->address) && !is_null($model->address) ? $model->address : "<span class='badge bg-warning'>belum diatur</span>";

        return $model;
    }

    function addMember(){

        // TB AUTH

        $email = htmlspecialchars($this->input->post('email'), true);
        $password = htmlspecialchars($this->input->post('password'), true);

        // TB USER
        $name = htmlspecialchars($this->input->post('name'), true);
        $gender = htmlspecialchars($this->input->post('gender'), true);
        $phone = htmlspecialchars($this->input->post('whatsapp'), true);
        $address = htmlspecialchars($this->input->post('address'), true);

        // CREATE UNIQ NAME KODE USER

        $string = preg_replace('/[^a-z]/i', '', $name);

        $vocal = ["a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " "];
        $scrap = str_replace($vocal, "", $string);
        $begin = substr($scrap, 0, 5);
        $uniqid = strtoupper($begin);

        // CREATE KODE USER
        do {
            $user_id = "USR-" . $uniqid . "-" . substr(md5(time()), 0, 6);
        } while ($this->M_auth->cek_userId($user_id) > 0);

        // TB AUTH
        $auth = [
            'user_id' => $user_id,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'status' => 1, #change to 1 -> auto verif
            'created_at' => time(),
        ];

        $this->db->insert('tb_auth', $auth);

        if ($this->db->affected_rows() == true) {

            $user = [
                'user_id' => $user_id,
                'name' => $name,
                'gender' => $gender,
                'phone' => (int) $phone,
                'address' => $address
            ];

            $this->db->insert('tb_user', $user);

            if ($this->db->affected_rows() == true) {

                $chiper = $this->M_auth->create_aktivasi();

                $aktivasi = [
                    'user_id' => $user_id,
                    'key' => $chiper,
                    'type' => 1, #VERIFIKASI email / AKTIVASI AKUN 
                    'status' => 1, #change to 1 -> auto verif
                    'date_created' => time()
                ];

                $this->db->insert('tb_token', $aktivasi);
                return ($this->db->affected_rows() != 1) ? false : true;
            } else {
                $this->M_auth->del_token($user_id, 1); #VERIFIKASI email / AKTIVASI AKUN 
                $this->M_auth->del_user($user_id);
                return false;
            }
        } else {
            $this->M_auth->del_user($user_id);
            return false;
        }
    }

    function changeMemberPassword(){
        $user_id = $this->input->post('id');
        $password = $this->input->post('pass');

        $this->db->where(['user_id' => $user_id]);
        $this->db->update('tb_auth', ['password' => password_hash($password, PASSWORD_DEFAULT)]);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    function changeMemberEmail(){
        $user_id = $this->input->post('id');
        $email = $this->input->post('email');

        $this->db->where(['user_id' => $user_id]);
        $this->db->update('tb_auth', ['email' => $email]);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    function verifMember(){
        $user_id = $this->input->post('id');

        $this->db->where(['user_id' => $user_id, 'type' => 1]);
        $this->db->update('tb_token', ['status' => 1]);

        $this->db->where(['user_id' => $user_id]);
        $this->db->update('tb_auth', ['status' => 1]);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    function deleteMember(){
        $user_id = $this->input->post('id');

        $this->db->where(['user_id' => $user_id]);
        $this->db->update('tb_auth', ['is_deleted' => 1]);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
}
