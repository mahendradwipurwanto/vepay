<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_master extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllKategori()
    {
        return $this->db->get_where('m_categories', ['is_deleted' => 0])->result();
    }

    public function saveKategori()
    {
        $id = htmlspecialchars($this->input->post('id'), true);
        $categories = htmlspecialchars($this->input->post('categories'), true);
        $description = htmlspecialchars($this->input->post('description'), true);

        $categories = [
            'categories' => $categories,
            'description' => $description,
            'created_at' => time(),
            'created_by' => $this->session->userdata('user_id')
        ];
        if (isset($id) && $id != '') {
            $this->db->where('id', $id);
            $this->db->update('m_categories', $categories);
            return ($this->db->affected_rows() != 1) ? false : true;
        } else {
            $this->db->insert('m_categories', $categories);
            return ($this->db->affected_rows() != 1) ? false : true;
        }
    }

    public function deleteKategori()
    {
        $id = htmlspecialchars($this->input->post('id'), true);

        $this->db->where('id', $id);
        $this->db->update('m_categories', ['is_deleted' => 1]);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function getAllProductSelect(){
        $this->db->select('a.*, b.categories')
        ->from('m_product a')
        ->join('m_categories b', 'a.m_categories_id = b.id', 'left')
        ->where(['a.is_deleted' => 0])
        ;

        $models = $this->db->get()->result();

        return $models;
    }

    public function getAllProduct()
    {
        $offset = $this->input->post('start');
        $limit  = $this->input->post('length'); // Rows display per page

        $filter = [];

        $filterName = $this->input->post('filterName');
        $filterCategories = $this->input->post('filterCategories');

        if ($filterName != null || $filterName != '') {
            $filter[] = "a.name like '%{$filterName}%'";
        }
        if ($filterCategories != null && $filterCategories > 0) {
            $filter[] = "a.m_categories_id = {$filterCategories}";
        }

        if ($filter != null) {
            $filter = implode(' AND ', $filter);
        }

        $this->db->select('a.*, b.categories')
        ->from('m_product a')
        ->join('m_categories b', 'a.m_categories_id = b.id', 'left')
        ->where(['a.is_deleted' => 0])
        ;

        $this->db->where($filter);
        $this->db->order_by('a.name ASC');

        // $this->db->limit($limit)->offset($offset);

        $models = $this->db->get()->result();

        foreach ($models as $key => $val) {
            $btnDetail                  = '<button onclick="showMdlProductDetail(\''.$val->id.'\')" class="btn btn-soft-info btn-icon btn-sm me-2"><i class="bi-pencil-square"></i></button>';
            $btnDelete                  = '<button onclick="showMdlProductDelete(\''.$val->id.'\')" class="btn btn-soft-danger btn-icon btn-sm me-2"><i class="bi-trash"></i></button>';
            $btnPrice                   = '<button onclick="showMdlProductPrice(\''.$val->id.'\')" class="btn btn-soft-success btn-icon btn-sm me-2"><i class="bi-cash-coin"></i></button>';

            $models[$key]->image        = base_url()."{$val->image}";
            $models[$key]->image        = "<a class='media-viewer' href='{$models[$key]->image}' data-fslightbox='gallery'><img src='{$models[$key]->image}' class='img-thumbnail' style='width: 80px' alt='{$models[$key]->image}'></a>";
            $models[$key]->categories   = !is_null($val->categories) || $val->m_categories_id > 0 ? $models[$key]->categories : '-';
            $models[$key]->categories   = "<span class='badge bg-soft-info'><i class='bi bi-tag'></i> {$models[$key]->categories}</span>";
            $models[$key]->description  = isset($val->description) && $val->description != "" ? substr($val->description, 0, 100).(strlen($val->description) > 100 ? '...' : '') : '-';

            $models[$key]->price        = "-";
            $price = $this->db->get_where('m_price', ['m_product_id' => $val->id, 'status' => 1, 'is_deleted' => 0])->result();
            
            $price_txt = "";
            if(!empty($price)){
                foreach ($price as $k => $v) {
                    $price_formatted    = number_format($v->price,0,",",".");
                    $price_txt          .= "<li>Rp. {$price_formatted} - <i class='text-muted'>{$v->type}</i></li>";
                }
                $models[$key]->price    = $price_txt; 
            }

            $models[$key]->action       = $btnDetail.$btnDelete.$btnPrice;
        }

        $totalRecords = count($models);

        $models = array_slice($models, $offset, $limit);
        
        return ['records' => array_values($models), 'totalDisplayRecords' => count($models), 'totalRecords' => $totalRecords];
    }

    public function getDetailProduct($product_id = null)
    {
        $this->db->select('a.*, b.categories')
        ->from('m_product a')
        ->join('m_categories b', 'a.m_categories_id = b.id', 'left')
        ->where(['a.is_deleted' => 0, 'a.id' => $product_id])
        ;

        $model = $this->db->get()->row();
        $model->image    = base_url()."{$model->image}";

        return $model;
    }

    public function getRateProduct($product_id = null)
    {
        $this->db->select('a.*, b.name')
        ->from('m_price a')
        ->join('m_product b', 'a.m_product_id = b.id', 'inner')
        ->where(['a.is_deleted' => 0, 'a.m_product_id' => $product_id])
        ->order_by('a.created_at DESC, a.status DESC')
        ;

        $models = $this->db->get()->result();

        return $models;
    }

    public function getRateAllProduct()
    {
        $this->db->select('a.*, b.name')
        ->from('m_price a')
        ->join('m_product b', 'a.m_product_id = b.id', 'inner')
        ->where(['a.is_deleted' => 0, 'a.status' => 1])
        ->order_by('a.created_at DESC, a.status DESC')
        ;

        $models = $this->db->get()->result();

        return $models;
    }

    public function getDetailRateProduct($rate_id = null)
    {
        $this->db->select('a.*')
        ->from('m_price a')
        ->where(['a.is_deleted' => 0, 'a.id' => $rate_id])
        ;

        $models = $this->db->get()->row();

        return $models;
    }

    public function addProduct($image = null)
    {
        $data = [
            'name'              => $this->input->post('name'),
            'image'             => $image,
            'm_categories_id'   => $this->input->post('categories'),
            'price'             => $this->input->post('price'),
            'description'       => $this->input->post('description'),
            'created_at'        => time(),
            'created_by'        => $this->session->userdata('user_id'),
        ];

        $this->db->insert('m_product', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function editProduct($image = null)
    {
        if (is_null($image)) {
            $data = [
                'name'              => $this->input->post('name'),
                'm_categories_id'   => $this->input->post('categories'),
                'price'             => $this->input->post('price'),
                'description'       => $this->input->post('description'),
                'modified_at'       => time(),
                'modified_by'       => $this->session->userdata('user_id'),
            ];
        } else {
            $data = [
                'name'              => $this->input->post('name'),
                'image'             => $image,
                'm_categories_id'   => $this->input->post('categories'),
                'price'             => $this->input->post('price'),
                'description'       => $this->input->post('description'),
                'modified_at'       => time(),
                'modified_by'       => $this->session->userdata('user_id'),
            ];
        }

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('m_product', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function deleteProduct()
    {
        $data = [
            'is_deleted'        => 1,
            'modified_at'       => time(),
            'modified_by'       => $this->session->userdata('user_id'),
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('m_product', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function getAllPromo(){
        $this->db->select('*')
        ->from('m_promo')
        ->where(['is_deleted' => 0])
        ;

        $models = $this->db->get()->result();

        return $models;
    }

    public function getDetailPromo($id = null){
        $this->db->select('*')
        ->from('m_promo')
        ->where(['id' => $id, 'is_deleted' => 0])
        ;

        $models = $this->db->get()->row();

        return $models;
    }

    public function savePromo($image)
    {
        if (is_null($image)) {
            $data = [
                'jenis'             => $this->input->post('jenis'),
                'kode'              => $this->input->post('kode'),
                'nama'              => $this->input->post('nama'),
                'value'             => $this->input->post('value'),
                'expired'           => strtotime($this->input->post('expired')),
                'quota'             => $this->input->post('quota'),
                'status'            => $this->input->post('status'),
                'created_at'        => time(),
                'created_by'        => $this->session->userdata('user_id'),
            ];
        } else {
            $data = [
                'jenis'             => $this->input->post('jenis'),
                'kode'              => $this->input->post('kode'),
                'nama'              => $this->input->post('nama'),
                'image'             => $image,
                'value'             => $this->input->post('value'),
                'expired'           => strtotime($this->input->post('expired')),
                'quota'             => $this->input->post('quota'),
                'status'            => $this->input->post('status'),
                'created_at'        => time(),
                'created_by'        => $this->session->userdata('user_id'),
            ];
        }

        $this->db->insert('m_promo', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function editPromo($image)
    {
        if (is_null($image)) {
            $data = [
                'jenis'             => $this->input->post('jenis'),
                'kode'              => $this->input->post('kode'),
                'nama'              => $this->input->post('nama'),
                'value'             => $this->input->post('value'),
                'expired'           => strtotime($this->input->post('expired')),
                'quota'             => $this->input->post('quota'),
                'status'            => $this->input->post('status'),
                'created_at'        => time(),
                'created_by'        => $this->session->userdata('user_id'),
            ];
        } else {
            $data = [
                'jenis'             => $this->input->post('jenis'),
                'kode'              => $this->input->post('kode'),
                'nama'              => $this->input->post('nama'),
                'image'             => $image,
                'value'             => $this->input->post('value'),
                'expired'           => strtotime($this->input->post('expired')),
                'quota'             => $this->input->post('quota'),
                'status'            => $this->input->post('status'),
                'created_at'        => time(),
                'created_by'        => $this->session->userdata('user_id'),
            ];
        }

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('m_promo', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function deletePromo()
    {
        $data = [
            'is_deleted'        => 1,
            'modified_at'       => time(),
            'modified_by'       => $this->session->userdata('user_id'),
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('m_promo', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function getAllMetode()
    {
        return $this->db->get_where('m_metode', ['is_deleted' => 0])->result();
    }

    public function getDetailMetode($id = null)
    {
        return $this->db->get_where('m_metode', ['id' => $id, 'is_deleted' => 0])->row();
    }

    public function saveMetode($image)
    {
        $id = htmlspecialchars($this->input->post('id'), true);
        $metode = htmlspecialchars($this->input->post('metode'), true);
        $description = htmlspecialchars($this->input->post('description'), true);

        if (is_null($image)) {
            $data = [
                'metode'        => $metode,
                'description'   => $description,
                'created_at'    => time(),
                'created_by'    => $this->session->userdata('user_id')
            ];
        } else {
            $data = [
                'metode'        => $metode,
                'image'         => $image,
                'description'   => $description,
                'created_at'    => time(),
                'created_by'    => $this->session->userdata('user_id')
            ];
        }
        
        if (isset($id) && $id != '') {
            $this->db->where('id', $id);
            $this->db->update('m_metode', $data);
            return ($this->db->affected_rows() != 1) ? false : true;
        } else {
            $this->db->insert('m_metode', $data);
            return ($this->db->affected_rows() != 1) ? false : true;
        }
    }

    public function deleteMetode()
    {
        $id = htmlspecialchars($this->input->post('id'), true);

        $this->db->where('id', $id);
        $this->db->update('m_metode', ['is_deleted' => 1]);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function setPriceProduct()
    {
        $this->db->where(['m_product_id' => $this->input->post('m_product_id'), 'type' => $this->input->post('type')]);
        $this->db->update('m_price', ['status' => 0]);

        $data = [
            'm_product_id'      => $this->input->post('m_product_id'),
            'type'              => $this->input->post('type'),
            'price'             => $this->input->post('price'),
            'status'            => 1,
            'created_at'        => time(),
            'created_by'        => $this->session->userdata('user_id')
        ];

        $this->db->insert('m_price', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
}
