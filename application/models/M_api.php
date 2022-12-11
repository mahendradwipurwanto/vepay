<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_api extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
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
    
    public function getAllProducts()
    {

        $this->db->select('a.*, b.categories')
        ->from('m_product a')
        ->join('m_categories b', 'a.m_categories_id = b.id', 'left')
        ->where(['a.is_deleted' => 0])
        ;

        $this->db->order_by('a.name ASC');

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
    
    public function getAllPromo()
    {

        $this->db->select('a.*')
        ->from('m_promo a')
        ->where(['a.is_deleted' => 0])
        ;

        $this->db->order_by('a.nama ASC');

        $models = $this->db->get()->result();

        return $models;
    }
    
    public function getDetailPromo($id = null)
    {

        $this->db->select('a.*')
        ->from('m_promo a')
        ->where(['a.is_deleted' => 0, 'a.id' => $id])
        ;

        $models = $this->db->get()->row();

        return $models;
    }
    
    public function getAllmetode()
    {

        $this->db->select('a.*')
        ->from('m_metode a')
        ->where(['a.is_deleted' => 0])
        ;

        $this->db->order_by('a.metode ASC');

        $models = $this->db->get()->result();

        return $models;
    }
}
