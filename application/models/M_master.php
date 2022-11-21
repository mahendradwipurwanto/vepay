<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_master extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllProduct(){

        $offset = $this->input->post('start');
        $limit  = $this->input->post('length'); // Rows display per page
        
        $filter = [];

        $filterName = $this->input->post('filterName');  
        $filterPrice = $this->input->post('filterPrice');  
        $filterCategories = $this->input->post('filterCategories');   

        if($filterName != null || $filterName != '') $filter[] = "a.name like '%{$filterName}%'";
        if($filterPrice != null || $filterPrice != '') $filter[] = "a.price like '%{$filterPrice}%'";
        if($filterCategories != null || $filterCategories != '') $filter[] = "a.m_categories_id = {$filterCategories}";

        if($filter != null){
            $filter = implode(' AND ', $filter);
        }  

        $this->db->select('a.*, b.categories')
        ->from('tb_product a')
        ->join('m_categories b', 'a.m_categories_id = b.id', 'left')
        ->where(['a.is_deleted' => 0])
        ;

        $this->db->where($filter);
        $this->db->order_by('a.name ASC');

        // $this->db->limit($limit)->offset($offset);

        $models = $this->db->get()->result();
        
        foreach($models as $key => $val){
            
            $btnDetail                  = '<button onclick="showMdlProductDetail(\''.$val->id.'\')" class="btn btn-soft-info btn-icon btn-sm me-2"><i class="bi-pencil-square"></i></button>';
            $btnDelete                  = '<button onclick="showMdlProductDelete(\''.$val->id.'\')" class="btn btn-soft-danger btn-icon btn-sm me-2"><i class="bi-trash"></i></button>';
            
            $models[$key]->price_txt    = number_format($val->price,0,",",".");
            $models[$key]->price_txt    = "Rp. {$models[$key]->price_txt}";
            $models[$key]->image        = base_url()."{$val->image}";
            $models[$key]->image        = "<a class='media-viewer' href='{$models[$key]->image}' data-fslightbox='gallery'><img src='{$models[$key]->image}' class='img-thumbnail' style='width: 80px' alt='{$models[$key]->image}'></a>";
            $models[$key]->categories   = !is_null($val->categories) || $val->m_categories_id > 0 ? $models[$key]->categories : '-';
            $models[$key]->categories   = "<span class='badge bg-soft-info'>{$models[$key]->categories}</span>";
            
            $models[$key]->action       = $btnDetail.$btnDelete;
        }

        $totalRecords = count($models);

        $models = array_slice($models, $offset, $limit);
        
        return ['records' => array_values($models), 'totalDisplayRecords' => count($models), 'totalRecords' => $totalRecords];
    }

    function getDetailProduct($product_id = null){
        $this->db->select('a.*, b.categories')
        ->from('tb_product a')
        ->join('m_categories b', 'a.m_categories_id = b.id', 'left')
        ->where(['a.is_deleted' => 0, 'a.id' => $product_id])
        ;

        $model = $this->db->get()->row();
        $model->price_txt    = number_format($model->price);
        $model->price_txt    = "Rp. {$model->price_txt}";
        $model->image    = base_url()."{$model->image}";

        return $model;
    }

    function addProduct($image = null){
        $data = [
            'name'              => $this->input->post('name'),
            'image'             => $image,
            'm_categories_id'   => $this->input->post('categories'),
            'price'             => $this->input->post('price'),
            'description'       => $this->input->post('description'),
            'created_at'        => time(),
            'created_by'        => $this->session->userdata('user_id'),
        ];

        $this->db->insert('tb_product', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    function editProduct($image = null){
        if(is_null($image)){
            $data = [
                'name'              => $this->input->post('name'),
                'm_categories_id'   => $this->input->post('categories'),
                'price'             => $this->input->post('price'),
                'description'       => $this->input->post('description'),
                'modified_at'       => time(),
                'modified_by'       => $this->session->userdata('user_id'),
            ];
        }else{
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
        $this->db->update('tb_product', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    function deleteProduct(){
        $data = [
            'is_deleted'        => 1,
            'modified_at'       => time(),
            'modified_by'       => $this->session->userdata('user_id'),
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('tb_product', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
}
