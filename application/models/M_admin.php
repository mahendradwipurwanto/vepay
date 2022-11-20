<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_admin extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function getCountOverview(){

        $produk = 0;
        $member = $this->db->get_where('tb_auth', ['role' => 2])->num_rows();
        $transaksi = $this->db->get_where('tb_payments', ['is_deleted' => 0])->num_rows();

        $this->db->select_sum('amount')
        ->from('tb_payments')
        ->where(['status' => 2, 'is_deleted' => 0])
        ;

        $pendapatan = $this->db->get()->row();
        
        return [
            'produk' => $produk,
            'member' => $member,
            'transaksi' => $transaksi,
            'pendapatan' => $pendapatan->amount
        ];
    }
}
