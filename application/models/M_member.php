<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_member extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('M_auth');
    }

    public function getAllMemberSelect()
    {
        $this->db->select('*')
            ->from('tb_auth a')
            ->join('tb_user b', 'a.user_id = b.user_id')
            ->where(['a.is_deleted' => 0, 'a.role' => 2]);

        $models = $this->db->get()->result();

        return $models;
    }

    public function getAllMember()
    {

        $offset = $this->input->post('start');
        $limit  = $this->input->post('length'); // Rows display per page
        $order  = $this->input->post('order')[0];

        $filter = [];

        $filterEmail = $this->input->post('filterEmail');
        $filterName = $this->input->post('filterName');
        $filterNumber = $this->input->post('filterNumber');

        if ($filterEmail != null || $filterEmail != '') $filter[] = "a.email like '%{$filterEmail}%'";
        if ($filterName != null || $filterName != '') $filter[] = "b.name like '%{$filterName}%'";
        if ($filterNumber != null || $filterNumber != '') $filter[] = "b.phone like '%{$filterNumber}%'";

        if ($filter != null) {
            $filter = implode(' AND ', $filter);
        }

        $this->db->select('a.status as auth_status, a.email, a.created_at, b.*')
            ->from('tb_auth a')
            ->join('tb_user b', 'a.user_id = b.user_id', 'inner')
            ->where(['a.role' => 2, 'a.is_deleted' => 0]);

        $this->db->where($filter);

        if (!is_null($order)) {

            switch ($order['column']) {
                case 0:
                    $columnName = 'b.name';
                    break;

                case 2:
                    $columnName = 'b.name';
                    break;

                case 3:
                    $columnName = 'b.phone';
                    break;

                case 4:
                    $columnName = 'a.created_at';
                    break;

                default:
                    $columnName = 'a.created_at';
                    break;
            }
            $this->db->order_by("{$columnName} {$order['dir']}");
        }

        // $this->db->limit($limit)->offset($offset);

        $models = $this->db->get()->result();

        foreach ($models as $key => $val) {

            $btnDetail      = '<button onclick="showMdlMemberDetail(\'' . $val->user_id . '\')" class="btn btn-soft-info btn-icon btn-sm me-2 mb-1"><i class="bi-eye"></i></button>';
            $btnPass        = '<button onclick="showMdlChangePassword(\'' . $val->user_id . '\')" class="btn btn-soft-primary btn-icon btn-sm me-2 mb-1"><i class="bi-key"></i></button>';
            $btnEmail       = '<button onclick="showMdlChangeEmail(\'' . $val->user_id . '\')" class="btn btn-soft-warning btn-icon btn-sm me-2 mb-1"><i class="bi-envelope"></i></button>';
            $btnVerif       = '<button onclick="showMdlVerifEmail(\'' . $val->user_id . '\', \'' . $val->name . '\')" class="btn btn-soft-warning btn-icon btn-sm me-2 mb-1"><i class="bi-check"></i></button>';
            $btnDelete      = '<button onclick="showMdlDelete(\'' . $val->user_id . '\', \'' . $val->name . '\')" class="btn btn-soft-danger btn-icon btn-sm me-2 mb-1"><i class="bi-trash"></i></button>';

            $strip_email                    = explode("@", $val->email);

            $name = $val->name;

            $saldo_referral = number_format($this->getSaldoReferral($val->user_id));
            $models[$key]->saldo_referral = "Rp. {$saldo_referral}";

            if (is_null($val->name) || $val->name == '') {
                $name = $strip_email[0] . ' <span class="badge bg-soft-warning">belum mengatur nama</span>';
            }

            $models[$key]->name             = $name;
            $models[$key]->phone            = isset($val->phone) && !is_null($val->phone) ? "+62{$val->phone}" : "<span class='badge bg-warning'>belum diatur</span>";

            if ($val->auth_status == 1) {
                $models[$key]->status  = '<span class="badge bg-soft-success">Aktif</span>';
            } elseif ($val->auth_status == 2) {
                $models[$key]->status  = '<span class="badge bg-soft-warning">Suspended</span>';
            } else {
                $models[$key]->status  = '<span class="badge bg-soft-secondary">Belum verifikasi email</span>';
            }
            $models[$key]->joined_at = date("d F Y", $val->created_at);

            $models[$key]->action = $btnDetail . $btnPass . ($val->auth_status > 0 ? $btnEmail : $btnVerif) . $btnDelete;
        }

        $totalRecords = count($models);

        $models = array_slice($models, $offset, $limit);

        return ['records' => array_values($models), 'totalDisplayRecords' => count($models), 'totalRecords' => $totalRecords];
    }

    public function getAllMemberReferral()
    {
        $offset = $this->input->post('start');
        $limit  = $this->input->post('length'); // Rows display per page
        $order  = $this->input->post('order')[0] ?? null;

        $filter = [];

        $filterEmail = $this->input->post('filterEmail');
        $filterName = $this->input->post('filterName');
        $filterNumber = $this->input->post('filterNumber');

        if ($filterEmail != null || $filterEmail != '') $filter[] = "a.email like '%{$filterEmail}%'";
        if ($filterName != null || $filterName != '') $filter[] = "b.name like '%{$filterName}%'";
        if ($filterNumber != null || $filterNumber != '') $filter[] = "b.phone like '%{$filterNumber}%'";

        if ($filter != null) {
            $filter = implode(' AND ', $filter);
        }

        $this->db->select('a.status as auth_status, a.email, a.created_at, b.*, c.referral')
            ->from('tb_auth a')
            ->join('tb_user b', 'a.user_id = b.user_id', 'inner')
            ->join('tb_referral c', 'a.user_id = c.user_id', 'inner')
            ->where(['a.role' => 2, 'a.is_deleted' => 0]);

        $this->db->where($filter);

        if (!is_null($order)) {

            switch ($order['column']) {
                case 0:
                    $columnName = 'b.name';
                    break;

                case 1:
                    $columnName = 'b.name';
                    break;

                case 2:
                    $columnName = 'b.phone';
                    break;

                case 4:
                    $columnName = 'a.created_at';
                    break;

                case 5:
                    $columnName = 'a.created_at';
                    break;

                default:
                    $columnName = 'a.created_at';
                    break;
            }
            $this->db->order_by("{$columnName} {$order['dir']}");
        }

        // $this->db->limit($limit)->offset($offset);

        $models = $this->db->get()->result();

        foreach ($models as $key => $val) {

            $strip_email                    = explode("@", $val->email);

            $name = $val->name;

            $referral_nama = $this->getDetailMember($val->referral);
            $models[$key]->referral = $referral_nama->name;

            $saldo_referral = number_format($this->getSaldoReferral($val->user_id));
            $models[$key]->saldo_referral = "Rp. {$saldo_referral}";

            if (is_null($val->name) || $val->name == '') {
                $name = $strip_email[0] . ' <span class="badge bg-soft-warning">belum mengatur nama</span>';
            }

            $models[$key]->name             = $name;
            $models[$key]->phone            = isset($val->phone) && !is_null($val->phone) ? "+62{$val->phone}" : "<span class='badge bg-warning'>belum diatur</span>";

            if ($val->auth_status == 1) {
                $models[$key]->status  = '<span class="badge bg-soft-success">Aktif</span>';
            } elseif ($val->auth_status == 2) {
                $models[$key]->status  = '<span class="badge bg-soft-warning">Suspended</span>';
            } else {
                $models[$key]->status  = '<span class="badge bg-soft-secondary">Belum verifikasi email</span>';
            }
            $models[$key]->joined_at = date("d F Y", $val->created_at);

            // $models[$key]->action = $btnDetail . $btnPass . ($val->auth_status > 0 ? $btnEmail : $btnVerif) . $btnDelete;
        }

        $totalRecords = count($models);

        $models = array_slice($models, $offset, $limit);

        return ['records' => array_values($models), 'totalDisplayRecords' => count($models), 'totalRecords' => $totalRecords];
    }

    public function checkUserReferralStatus($user_id = null)
    {
        $model = $this->db->get_where('tb_referral', ['user_id' => $user_id])->row();

        return $model;
    }

    public function getSaldoReferral($user_id)
    {
        $this->db->select_sum('tb_transaksi_referral.nominal')
            ->from('tb_transaksi_referral')
            ->join('tb_transaksi', 'tb_transaksi_referral.transaksi_id = tb_transaksi.id', 'inner')
            ->where(['tb_transaksi.status' => 2, 'tb_transaksi.is_deleted' => 0, 'tb_transaksi_referral.referral' => $user_id]);

        $cashback = $this->db->get()->row();

        $this->db->select_sum('tb_transaksi_referral.nominal')
            ->from('tb_transaksi_referral')
            ->join('tb_transaksi', 'tb_transaksi_referral.transaksi_id = tb_transaksi.id', 'inner')
            ->where(['tb_transaksi.status' => 1, 'tb_transaksi.is_deleted' => 0, 'tb_transaksi_referral.referral' => $user_id]);

        $withdraw = $this->db->get()->row();

        $cashback = is_null($cashback->nominal) ? 0 : $cashback->nominal;
        $withdraw = is_null($withdraw->nominal) ? 0 : $withdraw->nominal;

        return ($cashback - $withdraw >= 0 ? $cashback - $withdraw : 0);
    }

    function getDetailMember($user_id = null)
    {
        $this->db->select('a.user_id, a.email, a.online, a.device, a.log_time, a.created_at, a.status as auth_status, b.name, b.gender, b.phone, b.address')
            ->from('tb_auth a')
            ->join('tb_user b', 'a.user_id = b.user_id')
            ->where(['a.user_id' => $user_id]);

        $model = $this->db->get()->row();
        $strip_email        = explode("@", $model->email);
        $model->name        = is_null($model->name) || $model->name == "" ? $strip_email[0] : $model->name;
        $model->whatsapp    = isset($model->phone) && !is_null($model->phone) ? "+62{$model->phone}" : "<span class='badge bg-warning'>belum diatur</span>";
        $model->gender      = isset($model->gender) && !is_null($model->gender) ? $model->gender : "<span class='badge bg-warning'>belum diatur</span>";
        $model->address     = isset($model->address) && !is_null($model->address) ? $model->address : "<span class='badge bg-warning'>belum diatur</span>";
        if ($model->auth_status == 1) {
            $model->status  = '<span class="badge bg-soft-success">Aktif</span>';
        } elseif ($model->auth_status == 2) {
            $model->status  = '<span class="badge bg-soft-warning">Suspended</span>';
        } else {
            $model->status  = '<span class="badge bg-soft-secondary">Belum verifikasi email</span>';
        }
        $model->joined_at = date("d F Y - H:i", $model->created_at);
        return $model;
    }

    function addMember()
    {

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

    function changeMemberPassword()
    {
        $user_id = $this->input->post('id');
        $password = $this->input->post('pass');

        $this->db->where(['user_id' => $user_id]);
        $this->db->update('tb_auth', ['password' => password_hash($password, PASSWORD_DEFAULT)]);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    function changeMemberEmail()
    {
        $user_id = $this->input->post('id');
        $email = $this->input->post('email');

        $this->db->where(['user_id' => $user_id]);
        $this->db->update('tb_auth', ['email' => $email]);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    function verifMember()
    {
        $user_id = $this->input->post('id');

        $this->db->where(['user_id' => $user_id, 'type' => 1]);
        $this->db->update('tb_token', ['status' => 1]);

        $this->db->where(['user_id' => $user_id]);
        $this->db->update('tb_auth', ['status' => 1]);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    function deleteMember()
    {
        $user_id = $this->input->post('id');

        $this->db->where(['user_id' => $user_id]);
        $this->db->update('tb_auth', ['is_deleted' => 1]);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
}
