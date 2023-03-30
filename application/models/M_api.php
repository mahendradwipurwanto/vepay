<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_api extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // pendaftaran

    public function cek_userId($user_id)
    {
        $user_id = $this->db->escape($user_id);
        $query = $this->db->query("SELECT * FROM tb_auth WHERE user_id = $user_id");
        return $query->num_rows();
    }

    public function register_user($params = [])
    {
        // CREATE UNIQ NAME KODE USER

        $string = preg_replace('/[^a-z]/i', '', $params['nama']);

        $vocal = ["a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " "];
        $scrap = str_replace($vocal, "", $string);
        $begin = substr($scrap, 0, 5);
        $uniqid = strtoupper($begin);

        // CREATE KODE USER
        do {
            $user_id = "USR-" . $uniqid . "-" . substr(md5(time()), 0, 6);
        } while ($this->cek_userId($user_id) > 0);

        // TB AUTH
        if($params['is_google'] == true){
            $auth = [
                'user_id' => $user_id,
                'email' => $params['email'],
                'password' => null,
                'status' => $params['is_google'] == true ? 1 : 0, #change to 1 -> auto verif
                'is_google' => true,
                'created_at' => time(),
            ];
        }else{
            $auth = [
                'user_id' => $user_id,
                'email' => $params['email'],
                'password' => password_hash($params['password'], PASSWORD_DEFAULT),
                'status' => $params['is_google'] == true ? 1 : 0, #change to 1 -> auto verif
                'is_google' => false,
                'created_at' => time(),
            ];
        }

        $this->db->insert('tb_auth', $auth);

        if ($this->db->affected_rows() == true) {

            $user = [
                'user_id' => $user_id,
                'name' => $params['nama'],
                'phone' => $params['is_google'] == true ? null : $params['phone']
            ];

            $this->db->insert('tb_user', $user);

            if ($this->db->affected_rows() == true) {

                $chiper = $this->create_aktivasi();

                $aktivasi = [
                    'user_id' => $user_id,
                    'key' => $chiper,
                    'type' => 1, #VERIFIKASI email / AKTIVASI AKUN 
                    'status' => $params['is_google'] == true ? 1 : 0, #change to 1 -> auto verif
                    'date_created' => time()
                ];

                $this->db->insert('tb_token', $aktivasi);
                return ($this->db->affected_rows() != 1) ? false : true;
            } else {
                $this->del_token($user_id, 1); #VERIFIKASI email / AKTIVASI AKUN 
                $this->del_user($user_id);
                return false;
            }
        } else {
            $this->del_user($user_id);
            return false;
        }
    }

    // AKTIVASI / VERIFIKASI

    public function cek_aktivasi($user_id)
    {
        $user_id = $this->db->escape($user_id);
        $query = $this->db->query("SELECT * FROM tb_token WHERE user_id = $user_id AND type = 1");
        return $query->num_rows();
    }

    public function create_aktivasi()
    {

        // CREATE KODE AKTIVASI
        $this->encryption->initialize(['driver' => 'openssl']);
        do {
            $activation_code = random_int(100000, 999999);
            // ENCRYPT KODE AKTIVASI
            $ciphercode = $this->encryption->encrypt($activation_code);
        } while ($this->cek_aktivasi($activation_code) > 0);

        return $ciphercode;
    }

    public function get_aktivasi($user_id)
    {
        $user_id = $this->db->escape($user_id);
        $query = $this->db->query("SELECT * FROM tb_token WHERE user_id = $user_id AND type = 1");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function aktivasi_kode($kode_aktivasi, $user_id)
    {

        $db_code = $this->encryption->decrypt($this->get_aktivasi($user_id)->key);

        if ($kode_aktivasi == $db_code) {
            return true;
        } else {
            return false;
        }
    }

    public function aktivasi_akun($user_id)
    {

        $this->db->where(['user_id' => $user_id, 'type' => 1]);
        $this->db->update('tb_token', ['status' => 1]);

        $this->db->where('user_id', $user_id);
        $this->db->update('tb_auth', ['active' => 1]);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function del_token($user_id, $type)
    {
        $this->db->where(['user_id' => $user_id, 'type' => $type]);
        $this->db->delete('tb_token');
    }

    public function del_user($user_id)
    {
        $user_id = $this->db->escape($user_id);
        $this->db->where('user_id', $user_id);
        $this->db->delete('tb_auth');
    }
    
    public function getAllMembers()
    {
        $this->db->select('a.status as auth_status, a.email, b.*')
        ->from('tb_auth a')
        ->join('tb_user b', 'a.user_id = b.user_id', 'inner')
        ->where(['a.role' => 2])
        ;

        $this->db->order_by('b.name ASC');

        $models = $this->db->get()->result();

        return $models;
    }
    
    public function getDetailMember($user_id = null)
    {
        $this->db->select('a.status as auth_status, a.email, b.*')
        ->from('tb_auth a')
        ->join('tb_user b', 'a.user_id = b.user_id', 'inner')
        ->where(['a.role' => 2, 'a.user_id' => $user_id])
        ;

        $models = $this->db->get()->row();

        return $models;
    }

    public function updateDetailMember($user_id = null, $data = []){
        $this->db->where('user_id', $user_id);
        $this->db->update('tb_user', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
    
    public function getAllProducts($params = [])
    {

        $this->db->select('a.*, b.categories')
        ->from('m_product a')
        ->join('m_categories b', 'a.m_categories_id = b.id', 'left')
        ->where(['a.is_active' => 1, 'a.is_deleted' => 0])
        ;

        $this->db->order_by('a.order ASC');

        if (!empty($params) && isset($params['limit']) && $params['limit'] > 0) {
            $this->db->limit($params['limit']);
        }

        $models = $this->db->get()->result();

        return $models;
    }
    
    public function getDetailProduct($id = null)
    {

        $this->db->select('a.*, b.categories')
        ->from('m_product a')
        ->join('m_categories b', 'a.m_categories_id = b.id', 'left')
        ->where(['a.is_deleted' => 0, 'a.id' => $id])
        ;

        $models = $this->db->get()->row();

        return $models;
    }
    
    public function getAllPromo($params = [])
    {

        $this->db->select('a.*')
        ->from('m_promo a')
        ->where(['a.is_deleted' => 0])
        ;

        $this->db->order_by('a.nama ASC');

        if (!empty($params) && isset($params['limit']) && $params['limit'] > 0) {
            $this->db->limit($params['limit']);
        }

        $models = $this->db->get()->result();

        return $models;
    }
    
    public function getDetailPromo($id = null, $kode = null)
    {

        $this->db->select('a.*')
        ->from('m_promo a')->where(['a.is_deleted' => 0]);

		if(!is_null($kode)){
			$this->db->like('a.kode', $kode);
		}else{			
			$this->db->where('a.id', $id);
		}

        $models = $this->db->get()->row();

        return $models;
    }
    
    public function getAllmetode($params = [])
    {

        $this->db->select('a.*')
        ->from('m_metode a')
        ->where(['a.is_deleted' => 0])
        ;

        $this->db->order_by('a.metode ASC');

        if (!empty($params) && isset($params['limit']) && $params['limit'] > 0) {
            $this->db->limit($params['limit']);
        }

        $models = $this->db->get()->result();

        return $models;
    }
    
    public function getAllblockchain($params = [])
    {

        $this->db->select('a.*')
        ->from('m_blockchain a')
        ->where(['a.is_deleted' => 0])
        ;

        $this->db->order_by('a.blockchain ASC');

        if (!empty($params) && isset($params['limit']) && $params['limit'] > 0) {
            $this->db->limit($params['limit']);
        }

        $models = $this->db->get()->result();

        return $models;
    }
    
    public function getAllRate($params = [])
    {

        $this->db->select('a.*, b.m_categories_id, b.name, b.image, b.description, b.is_active, b.order, c.categories')
        ->from('m_price a')
        ->join('m_product b', 'a.m_product_id = b.id')
        ->join('m_categories c', 'b.m_categories_id = c.id')
        ->where(['b.is_active' => 1, 'a.status' => 1, 'a.is_deleted' => 0])
        ;

        if(!empty($params) && isset($params['type'])){
            $this->db->where('type', ($params['type'] == 'top_up' ? 'Top Up' : 'Withdraw'));
        }

        $this->db->order_by('b.order ASC');

        if (!empty($params) && isset($params['limit']) && $params['limit'] > 0) {
            $this->db->limit($params['limit']);
        }

        $models = $this->db->get()->result();

        return $models;
    }
    
    public function getAllVcc($params = [])
    {

        $this->db->select('a.*, b.*, c.email')
        ->from('tb_vcc a')
        ->join('tb_user b', 'a.user_id = b.user_id')
        ->join('tb_auth c', 'a.user_id = c.user_id')
        ->where(['a.is_deleted' => 0])
        ;

        $this->db->where('a.user_id', $params['user_id']);

        $this->db->order_by('a.created_at DESC');

        if (!empty($params) && isset($params['limit']) && $params['limit'] > 0) {
            $this->db->limit($params['limit']);
        }

        $models = $this->db->get()->result();

        return $models;
    }
    
    public function getDetailVcc($id = null)
    {

        $this->db->select('a.*, b.*, c.email')
        ->from('tb_vcc a')
        ->join('tb_user b', 'a.user_id = b.user_id')
        ->join('tb_auth c', 'a.user_id = c.user_id')
        ->where(['a.is_deleted' => 0, 'a.id' => $id])
        ;

        $models = $this->db->get()->row();

        return $models;
    }
    
    public function getAllTransaksi($params = [])
    {

        $this->db->select('a.id, a.kode as kode_transaksi, a.account as akun_tujuan, a.jenis_transaksi_vcc, a.user_id, a.sub_total as total, e.total as sub_total, a.status, a.bukti, b.name, b.phone, c.email, d.metode, d.image as img_method, d.no_rekening, d.atas_nama, f.type, f.fee, g.name as product, g.image as img_product, a.m_blockchain_id, h.blockchain, a.created_at, a.modified_at')
        ->from('tb_transaksi a')
        ->join('tb_user b', 'a.user_id = b.user_id', 'left')
        ->join('tb_auth c', 'a.user_id = c.user_id', 'left')
        ->join('m_metode d', 'a.m_metode_id = d.id', 'left')
        ->join('_transaksi_detail e', 'a.id = e.transaksi_id')
        ->join('m_price f', 'e.m_price_id = f.id')
        ->join('m_product g', 'f.m_product_id = g.id')
        ->join('m_blockchain h', 'a.m_blockchain_id = h.id', 'left')
        ;

        $this->db->where(['a.user_id' => $params['user_id'], 'a.is_deleted' => 0]);

        if (!empty($params) && isset($params['type']) && !is_null($params['type'])) {
            $type = $params['type'] == 'top_up' ? 'Top Up' : "Withdraw";
            $this->db->where('f.type', $type);
        }

        if (!empty($params) && isset($params['product']) && !empty($params['product']) && is_array($params['product'])) {
            $this->db->where_in('g.name', $params['product']);

        }

        if (!empty($params) && isset($params['start_date']) && !is_null($params['start_date']) && isset($params['end_date']) && !is_null($params['end_date'])) {
            $this->db->where('a.created_at >=', strtotime("{$params['start_date']} 00:00:00"));
            $this->db->where('a.created_at <=', strtotime("{$params['end_date']} 23:59:59"));
        }
        
        $this->db->order_by('a.created_at DESC');

        if (!empty($params) && isset($params['limit']) && $params['limit'] > 0) {
            $this->db->limit($params['limit']);
        }

        $models = $this->db->get()->result();

        return $models;
    }
    
    public function getDetailTransaksi($id = null)
    {

        $this->db->select('a.id, a.kode as kode_transaksi, a.account as akun_tujuan, a.jenis_transaksi_vcc, a.user_id, a.sub_total as total, e.total as sub_total, a.status, a.bukti, b.name, b.phone, c.email, d.metode, d.image as img_method, d.no_rekening, d.atas_nama, f.type, f.fee, g.name as product, g.image as img_product, a.m_blockchain_id, h.blockchain, a.created_at, a.modified_at')
        ->from('tb_transaksi a')
        ->join('tb_user b', 'a.user_id = b.user_id', 'left')
        ->join('tb_auth c', 'a.user_id = c.user_id', 'left')
        ->join('m_metode d', 'a.m_metode_id = d.id', 'left')
        ->join('_transaksi_detail e', 'a.id = e.transaksi_id')
        ->join('m_price f', 'e.m_price_id = f.id')
        ->join('m_product g', 'f.m_product_id = g.id')
        ->join('m_blockchain h', 'a.m_blockchain_id = h.id', 'left')
        ->where(['a.is_deleted' => 0, 'a.id' => $id])
        ;

        $models = $this->db->get()->row();

        return $models;
    }

    public function create_transaction($transaksi = [], $detail = []){

        $this->db->insert('tb_transaksi', $transaksi);
        $transaksi_id = $this->db->insert_id();
        $status = ($this->db->affected_rows() != 1) ? false : true;

        if($status === false){
            return [
                'status' => false
            ];
        }

        $transaksi = [
            'transaksi_id'      => $transaksi_id
        ];

        $this->db->insert('_transaksi_detail', array_merge($transaksi, $detail));
        $status = ($this->db->affected_rows() != 1) ? false : true;
        if($status === false){
            
            $this->db->where('id', $transaksi_id);
            $this->db->delete('tb_transaksi');
            return [
                'status' => false
            ];
        }

        $this->db->select('a.id, a.kode as kode_transaksi, a.account as akun_tujuan, a.jenis_transaksi_vcc, a.user_id, a.sub_total as total, e.total as sub_total, a.status, a.bukti, b.name, b.phone, c.email, d.metode, d.image as img_method, d.no_rekening, d.atas_nama, f.type, f.fee, g.name as product, g.image as img_product, a.m_blockchain_id, h.blockchain, a.created_at, a.modified_at')
        ->from('tb_transaksi a')
        ->join('tb_user b', 'a.user_id = b.user_id', 'left')
        ->join('tb_auth c', 'a.user_id = c.user_id', 'left')
        ->join('m_metode d', 'a.m_metode_id = d.id', 'left')
        ->join('_transaksi_detail e', 'a.id = e.transaksi_id')
        ->join('m_price f', 'e.m_price_id = f.id')
        ->join('m_product g', 'f.m_product_id = g.id')
        ->join('m_blockchain h', 'a.m_blockchain_id = h.id', 'left')
        ;

        $this->db->where(['a.id' => $transaksi_id]);

        $model = $this->db->get()->row();

        return [
            'status' => true,
            'data' => $model
        ];
    }

    public function bayar_transaction($id = null, $transaksi = []){

        $this->db->where('id', $id);
        $this->db->update('tb_transaksi', $transaksi);
        $status = ($this->db->affected_rows() != 1) ? false : true;

        if($status === false){
            return [
                'status' => false
            ];
        }

        $this->db->select('a.id, a.kode as kode_transaksi, a.account as akun_tujuan, a.jenis_transaksi_vcc, a.user_id, a.sub_total as total, e.total as sub_total, a.status, a.bukti, b.name, b.phone, c.email, d.metode, d.image as img_method, d.no_rekening, d.atas_nama, f.type, f.fee, g.name as product, g.image as img_product, a.m_blockchain_id, h.blockchain, a.created_at, a.modified_at')
        ->from('tb_transaksi a')
        ->join('tb_user b', 'a.user_id = b.user_id', 'left')
        ->join('tb_auth c', 'a.user_id = c.user_id', 'left')
        ->join('m_metode d', 'a.m_metode_id = d.id', 'left')
        ->join('_transaksi_detail e', 'a.id = e.transaksi_id')
        ->join('m_price f', 'e.m_price_id = f.id')
        ->join('m_product g', 'f.m_product_id = g.id')
        ->join('m_blockchain h', 'a.m_blockchain_id = h.id', 'left')
        ;

        $this->db->where(['a.id' => $id]);

        $model = $this->db->get()->row();


        $model->bukti = base_url().$model->bukti;
        $model->img_method = base_url().$model->img_method;
        $model->wa_admin = "6285785111746";

        return [
            'status' => true,
            'data' => $model
        ];
    }

    public function delete_transaction($id){
        $this->db->where('id', $id);
        $this->db->update('tb_transaksi', ['is_deleted' => 1]);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
}
