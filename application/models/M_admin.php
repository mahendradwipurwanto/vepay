<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_admin extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_settingsValue($key){
        return $this->db->get_where('tb_settings', ['key' => $key])->row()->value;
    }

    function get_allAccount(){
        $this->db->select('a.email, a.role, a.status, a.online, a.is_deleted, a.log_time, a.device, b.*')
        ->from('tb_auth a')
        ->join('tb_user b', 'a.user_id = b.user_id', 'inner')
        ->order_by('a.log_time DESC')
        ;

        return $this->db->get()->result();
    }

    function get_superAccount(){
        $this->db->select('a.email, a.role, a.status, a.online, a.is_deleted, a.log_time, a.device, b.*')
        ->from('tb_auth a')
        ->join('tb_user b', 'a.user_id = b.user_id', 'inner')
        ->where(['a.role' => 0])
        ;

        return $this->db->get()->row();
    }

    function get_adminAccount(){
        $this->db->select('a.email, a.role, a.status, a.online, a.is_deleted, a.log_time, a.device, b.*')
        ->from('tb_auth a')
        ->join('tb_user b', 'a.user_id = b.user_id', 'inner')
        ->where(['a.role' => 1])
        ;

        return $this->db->get()->row();
    }

    function getCountOverview(){

        $produk = $this->db->get_where('m_product', ['is_deleted' => 0])->num_rows();
        $member = $this->db->get_where('tb_auth', ['role' => 2])->num_rows();
        $transaksi = $this->db->get_where('tb_transaksi', ['is_deleted' => 0])->num_rows();

        $this->db->select_sum('sub_total')
        ->from('tb_transaksi')
        ->where(['status' => 2, 'is_deleted' => 0])
        ;

        $pendapatan = $this->db->get()->row();
        
        return [
            'produk' => $produk,
            'member' => $member,
            'transaksi' => $transaksi,
            'pendapatan' => $pendapatan->sub_total
        ];
    }

    function getTopTransaksi(){

    }

	function getTopProduk(){
		$this->db->select('m_product.name, SUM(_transaksi_detail.quantity) as total_sales')
		->from('m_product')
		->join('m_price', 'm_price.m_product_id = m_product.id')
		->join('_transaksi_detail', '_transaksi_detail.m_price_id = m_price.id')
		->join('tb_transaksi', 'tb_transaksi.id = _transaksi_detail.transaksi_id')
		->where('tb_transaksi.is_deleted', 0)
		->group_by('m_product.id')
		->order_by('total_sales', 'DESC')
		->limit(10);

		return $this->db->get()->result();
	}

	function getTopmember(){
		$this->db->select('tb_user.name, SUM(_transaksi_detail.quantity) as total_sales')
		->from('tb_user')
		->join('tb_transaksi', 'tb_transaksi.user_id = tb_user.user_id')
		->join('_transaksi_detail', '_transaksi_detail.transaksi_id = tb_transaksi.id')
		->where('tb_transaksi.is_deleted', 0)
		->group_by('tb_user.user_id')
		->order_by('total_sales', 'DESC')
		->limit(10);


		return $this->db->get()->result();
	}
}
