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
		->order_by("a.order ASC")
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
        ->where(['a.is_deleted' => 0, 'a.name !=' => "More"])
        ;

        $this->db->where($filter);
        $this->db->order_by('a.order ASC, a.name ASC');

        // $this->db->limit($limit)->offset($offset);

        $models = $this->db->get()->result();

        foreach ($models as $key => $val) {
			$btnDetail                  = '<button onclick="showMdlProductDetail(\''.$val->id.'\')" class="btn btn-soft-info btn-icon btn-sm me-2"><i class="bi-pencil-square"></i></button>';
			$btnActive                  = '<button onclick="showMdlProductActive(\''.$val->id.'\')" class="btn btn-soft-success btn-icon btn-sm me-2"><i class="bi-check-square"></i></button>';
			$btnNonActive               = '<button onclick="showMdlProductNonActive(\''.$val->id.'\')" class="btn btn-soft-secondary btn-icon btn-sm me-2"><i class="bi-dash-square"></i></button>';
			$btnDelete                  = '<button onclick="showMdlProductDelete(\''.$val->id.'\')" class="btn btn-soft-danger btn-icon btn-sm me-2"><i class="bi-trash"></i></button>';
			$btnPrice                   = '<button onclick="showMdlProductPrice(\''.$val->id.'\')" class="btn btn-soft-success btn-icon btn-sm me-2"><i class="bi-cash-coin"></i></button>';

			$models[$key]->image        = base_url()."{$val->image}";
			$models[$key]->image        = "<a class='media-viewer' href='{$models[$key]->image}' data-fslightbox='gallery'><img src='{$models[$key]->image}' class='img-thumbnail' style='width: 80px' alt='{$models[$key]->image}'></a>";
			$models[$key]->categories   = !is_null($val->categories) || $val->m_categories_id > 0 ? $models[$key]->categories : '-';
			$models[$key]->categories   = "<span class='badge bg-soft-info'><i class='bi bi-tag'></i> {$models[$key]->categories}</span>";
			$models[$key]->status       = ($val->is_active == 1 ? "<span class='badge bg-soft-success'>aktif</span>" : "<span class='badge bg-soft-secondary'>nonaktif</span>");
			$models[$key]->description  = isset($val->description) && $val->description != "" ? substr($val->description, 0, 100).(strlen($val->description) > 100 ? '...' : '') : '-';

			$models[$key]->price        = "-";
			$models[$key]->fee        = "-";
			$price = $this->db->get_where('m_price', ['m_product_id' => $val->id, 'status' => 1, 'is_deleted' => 0])->result();
			
			$price_txt  = "";
			$fee_txt    = "";
			if(!empty($price)){
				foreach ($price as $k => $v) {
					$price_formatted    = number_format($v->price,0,",",".");
					$price_txt          .= "<li>Rp. {$price_formatted} - <i class='text-muted'>{$v->type}</i></li>";
					$fee_txt            = "{$v->fee}%";
				}
				$models[$key]->fee      = $fee_txt;
				$models[$key]->price    = $price_txt; 
			}
			$models[$key]->name 		= ((stripos($val->name, 'VCC') === false) ? $val->name : "{$val->name} - <small class='text-secondary'><i>default</i></small>");
			$models[$key]->action       = $btnDetail.((stripos($val->name, 'VCC') === false) ? $btnDelete : '').$btnPrice. ($val->is_active == 1 ? $btnNonActive : $btnActive);
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
        ->order_by('a.status DESC, a.price DESC, a.created_at DESC')
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
		$all = $this->getAllProductSelect();

		$order = count($all);

        $data = [
            'name'              => $this->input->post('name'),
            'image'             => $image,
            'm_categories_id'   => $this->input->post('categories'),
            'description'       => $this->input->post('description'),
            'order'       		=> $order,
            'created_at'        => time(),
            'created_by'        => $this->session->userdata('user_id'),
        ];

        $this->db->insert('m_product', $data);
        $cek = ($this->db->affected_rows() != 1);
		
		if($cek){
			$this->db->where('id', 8);
			$this->db->update('m_products', ['order' => ($order+1)]);
		}

		return $cek;
    }

    public function editProduct($image = null)
    {
        if (is_null($image)) {
            $data = [
                'name'              => $this->input->post('name'),
                'm_categories_id'   => $this->input->post('categories'),
                'description'       => $this->input->post('description'),
                'order'       		=> $this->input->post('order'),
                'modified_at'       => time(),
                'modified_by'       => $this->session->userdata('user_id'),
            ];
        } else {
            $data = [
                'name'              => $this->input->post('name'),
                'image'             => $image,
                'm_categories_id'   => $this->input->post('categories'),
                'description'       => $this->input->post('description'),
                'order'       		=> $this->input->post('order'),
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

    public function aktifProduct()
    {
        $data = [
            'is_active'         => 1,
            'modified_at'       => time(),
            'modified_by'       => $this->session->userdata('user_id'),
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('m_product', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function nonaktifProduct()
    {
        $data = [
            'is_active'         => 0,
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

    public function savePromo($image = null)
    {
        if (is_null($image)) {
            $data = [
                'jenis'             => $this->input->post('jenis'),
                'kode'              => $this->input->post('kode'),
                'nama'              => $this->input->post('nama'),
                'value'             => $this->input->post('value'),
                'expired'           => strtotime($this->input->post('expired')),
                'quota'             => $this->input->post('quota') == "" ? null : $this->input->post('quota'),
                'status'            => $this->input->post('status'),
                'jenis_pengguna'    => $this->input->post('jenis_pengguna'),
                'desc'           	=> $this->input->post('desc'),
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
                'quota'             => $this->input->post('quota') == "" ? null : $this->input->post('quota'),
                'status'            => $this->input->post('status'),
                'jenis_pengguna'    => $this->input->post('jenis_pengguna'),
                'desc'           	=> $this->input->post('desc'),
                'created_at'        => time(),
                'created_by'        => $this->session->userdata('user_id'),
            ];
        }

        $this->db->insert('m_promo', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function editPromo($image = null)
    {
        if (is_null($image)) {
            $data = [
                'jenis'             => $this->input->post('jenis'),
                'kode'              => $this->input->post('kode'),
                'nama'              => $this->input->post('nama'),
                'value'             => $this->input->post('value'),
                'maksimal_promo'    => $this->input->post('jenis') == 2 ? $this->input->post('maksimal_promo') : 0,
                'expired'           => strtotime($this->input->post('expired')),
                'quota'             => $this->input->post('quota') == "" ? null : $this->input->post('quota'),
                'jenis_pengguna'    => $this->input->post('jenis_pengguna'),
                'desc'           	=> $this->input->post('desc'),
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
                'maksimal_promo'    => $this->input->post('jenis') == 2 ? $this->input->post('maksimal_promo') : 0,
                'expired'           => strtotime($this->input->post('expired')),
                'quota'             => $this->input->post('quota') == "" ? null : $this->input->post('quota'),
                'jenis_pengguna'    => $this->input->post('jenis_pengguna'),
                'desc'           	=> $this->input->post('desc'),
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

    public function saveMetode($image = null)
    {
        $id = htmlspecialchars($this->input->post('id'), true);
        $metode = htmlspecialchars($this->input->post('metode'), true);
        $description = htmlspecialchars($this->input->post('description'), true);
        $atas_nama = htmlspecialchars($this->input->post('atas_nama'), true);
        $no_rekening = htmlspecialchars($this->input->post('no_rekening'), true);
        
        if (isset($id) && $id != '') {
            if (is_null($image)) {
                $data = [
                    'metode'        => $metode,
                    'description'   => $description,
                    'atas_nama'     => $atas_nama,
                    'no_rekening'   => $no_rekening,
                    'modified_at'    => time(),
                    'modified_by'    => $this->session->userdata('user_id')
                ];
            } else {
                $data = [
                    'metode'        => $metode,
                    'image'         => $image,
                    'description'   => $description,
                    'atas_nama'     => $atas_nama,
                    'no_rekening'   => $no_rekening,
                    'modified_at'    => time(),
                    'modified_by'    => $this->session->userdata('user_id')
                ];
            }
        } else {
            if (is_null($image)) {
                $data = [
                    'metode'        => $metode,
                    'description'   => $description,
                    'atas_nama'     => $atas_nama,
                    'no_rekening'   => $no_rekening,
                    'created_at'    => time(),
                    'created_by'    => $this->session->userdata('user_id')
                ];
            } else {
                $data = [
                    'metode'        => $metode,
                    'image'         => $image,
                    'description'   => $description,
                    'atas_nama'     => $atas_nama,
                    'no_rekening'   => $no_rekening,
                    'created_at'    => time(),
                    'created_by'    => $this->session->userdata('user_id')
                ];
            }
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

    public function getAllWithdraw()
    {
        return $this->db->get_where('m_withdraw', ['is_deleted' => 0])->result();
    }

    public function getDetailWithdraw($id = null)
    {
        return $this->db->get_where('m_withdraw', ['id' => $id, 'is_deleted' => 0])->row();
    }

    public function saveWithdraw($image = null)
    {
        $id = htmlspecialchars($this->input->post('id'), true);
        $withdraw = htmlspecialchars($this->input->post('withdraw'), true);
        $description = htmlspecialchars($this->input->post('description'), true);
        $atas_nama = htmlspecialchars($this->input->post('atas_nama'), true);
        $no_rekening = htmlspecialchars($this->input->post('no_rekening'), true);
        
        if (isset($id) && $id != '') {
            if (is_null($image)) {
                $data = [
                    'withdraw'        => $withdraw,
                    'description'   => $description,
                    'atas_nama'     => $atas_nama,
                    'no_rekening'   => $no_rekening,
                    'modified_at'    => time(),
                    'modified_by'    => $this->session->userdata('user_id')
                ];
            } else {
                $data = [
                    'withdraw'        => $withdraw,
                    'image'         => $image,
                    'description'   => $description,
                    'atas_nama'     => $atas_nama,
                    'no_rekening'   => $no_rekening,
                    'modified_at'    => time(),
                    'modified_by'    => $this->session->userdata('user_id')
                ];
            }
        } else {
            if (is_null($image)) {
                $data = [
                    'withdraw'        => $withdraw,
                    'description'   => $description,
                    'atas_nama'     => $atas_nama,
                    'no_rekening'   => $no_rekening,
                    'created_at'    => time(),
                    'created_by'    => $this->session->userdata('user_id')
                ];
            } else {
                $data = [
                    'withdraw'        => $withdraw,
                    'image'         => $image,
                    'description'   => $description,
                    'atas_nama'     => $atas_nama,
                    'no_rekening'   => $no_rekening,
                    'created_at'    => time(),
                    'created_by'    => $this->session->userdata('user_id')
                ];
            }
        }
        
        if (isset($id) && $id != '') {
            $this->db->where('id', $id);
            $this->db->update('m_withdraw', $data);
            return ($this->db->affected_rows() != 1) ? false : true;
        } else {
            $this->db->insert('m_withdraw', $data);
            return ($this->db->affected_rows() != 1) ? false : true;
        }
    }

    public function deleteWithdraw()
    {
        $id = htmlspecialchars($this->input->post('id'), true);

        $this->db->where('id', $id);
        $this->db->update('m_withdraw', ['is_deleted' => 1]);
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
            'fee'               => $this->input->post('fee'),
            'status'            => 1,
            'created_at'        => time(),
            'created_by'        => $this->session->userdata('user_id')
        ];

        $this->db->insert('m_price', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function activePriceProduct()
    {
        $this->db->where(['m_product_id' => $this->input->post('m_product_id'), 'type' => $this->input->post('type')]);
        $this->db->update('m_price', ['status' => 0]);

        $data = [
            'status'            => 1,
            'modified_at'        => time(),
            'modified_by'        => $this->session->userdata('user_id')
        ];

        $this->db->where('id', $this->input->post('m_price_id'));
        $this->db->update('m_price', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function deletePriceProduct()
    {

        if($this->input->post('status') == 1){
            $this->db->where(['m_product_id' => $this->input->post('m_product_id'), 'type' => $this->input->post('type')]);
            $this->db->update('m_price', ['status' => 0]);
        }

        // get latest data
        $latest = $this->getLatestPrice($this->input->post('m_product_id'),
        $this->input->post('type'),$this->input->post('m_price_id'));

        if(!is_null($latest)){
            $change = [
                'status'            => 1,
                'modified_at'        => time(),
                'modified_by'        => $this->session->userdata('user_id')
            ];
    
            $this->db->where('id', $latest->id);
            $this->db->update('m_price', $change);
        }

        $data = [
            'is_deleted'            => 1,
            'modified_at'        => time(),
            'modified_by'        => $this->session->userdata('user_id')
        ];

        $this->db->where('id', $this->input->post('m_price_id'));
        $this->db->update('m_price', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
    
    function getLatestPrice($m_product_id = null, $type = null, $price_id = null){
        $this->db->select('a.*, b.name')
        ->from('m_price a')
        ->join('m_product b', 'a.m_product_id = b.id', 'inner')
        ->where(['a.is_deleted' => 0, 'a.m_product_id' => $m_product_id, 'a.type' => $type, 'a.id !=' => $price_id])
        ->order_by('a.created_at DESC')
        ->limit(1)
        ;

        $models = $this->db->get()->row();

        return $models;
    }

    public function getAllVcc(){
        $this->db->select('a.*, b.name')
        ->from('tb_vcc a')
        ->join('tb_user b', 'a.user_id = b.user_id')
        ->where(['a.is_deleted' => 0])
        ;

        $models = $this->db->get()->result();

        return $models;
    }

    public function getDetailVcc($id = null)
    {
        $this->db->select('a.*, b.name')
        ->from('tb_vcc a')
        ->join('tb_user b', 'a.user_id = b.user_id')
        ->where(['a.id' => $id])
        ;

        $models = $this->db->get()->row();
        return $models;

    }

    public function saveVcc()
    {
        $id = htmlspecialchars($this->input->post('id'), true);
        $vcc_name = htmlspecialchars($this->input->post('vcc_name'), true);
        $member = htmlspecialchars($this->input->post('member'), true);
        $jenis_vcc = htmlspecialchars($this->input->post('jenis_vcc'), true);
        $number = htmlspecialchars($this->input->post('number'), true);
        $holder = htmlspecialchars($this->input->post('holder'), true);
        $valid_date = htmlspecialchars($this->input->post('valid_date'), true);
        $security_code = htmlspecialchars($this->input->post('security_code'), true);
        $saldo = htmlspecialchars($this->input->post('saldo'), true);
        
        if (isset($id) && $id != '') {
            $data = [
                'vcc_name'      => $vcc_name,
                'number'        => $number,
                'jenis_vcc'     => $jenis_vcc,
                'holder'        => $holder,
                'valid_date'    => $valid_date,
                'security_code' => $security_code,
                'saldo'         => $saldo,
                'modified_at'   => time(),
                'modified_by'   => $this->session->userdata('user_id')
            ];
        } else {
            $data = [
                'user_id'       => $member,
                'vcc_name'      => $vcc_name,
                'jenis_vcc'     => $jenis_vcc,
                'number'        => $number,
                'holder'        => $holder,
                'valid_date'    => $valid_date,
                'security_code' => $security_code,
                'saldo' =>      $saldo,
                'created_at'    => time(),
                'created_by'    => $this->session->userdata('user_id')
            ];
        }
        
        if (isset($id) && $id != '') {
            $this->db->where('id', $id);
            $this->db->update('tb_vcc', $data);
            return ($this->db->affected_rows() != 1) ? false : true;
        } else {
            $this->db->insert('tb_vcc', $data);
            return ($this->db->affected_rows() != 1) ? false : true;
        }
    }

    public function deleteVcc()
    {
        $id = htmlspecialchars($this->input->post('id'), true);

        $this->db->where('id', $id);
        $this->db->update('tb_vcc', ['is_deleted' => 1]);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function getAllBlockchain()
    {
        return $this->db->get_where('m_blockchain', ['is_deleted' => 0])->result();
    }

    public function getDetailBlockchain($id = null)
    {
        return $this->db->get_where('m_blockchain', ['id' => $id, 'is_deleted' => 0])->row();
    }

    public function saveBlockchain()
    {
        $id = htmlspecialchars($this->input->post('id'), true);
        $blockchain = htmlspecialchars($this->input->post('blockchain'), true);
        $description = htmlspecialchars($this->input->post('description'), true);
        $fee = htmlspecialchars($this->input->post('fee'), true);
        
        if (isset($id) && $id != '') {
            $data = [
                'blockchain'        => $blockchain,
                'description'   => $description,
                'fee'   => $fee,
                'modified_at'    => time(),
                'modified_by'    => $this->session->userdata('user_id')
            ];
        } else {
            $data = [
                'blockchain'        => $blockchain,
                'description'   => $description,
                'fee'   => $fee,
                'created_at'    => time(),
                'created_by'    => $this->session->userdata('user_id')
            ];
        }
        
        if (isset($id) && $id != '') {
            $this->db->where('id', $id);
            $this->db->update('m_blockchain', $data);
            return ($this->db->affected_rows() != 1) ? false : true;
        } else {
            $this->db->insert('m_blockchain', $data);
            return ($this->db->affected_rows() != 1) ? false : true;
        }
    }

    public function deleteBlockchain()
    {
        $id = htmlspecialchars($this->input->post('id'), true);

        $this->db->where('id', $id);
        $this->db->update('m_blockchain', ['is_deleted' => 1]);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function getAllFaq()
    {
        return $this->db->get_where('m_faq', ['is_deleted' => 0])->result();
    }

    public function saveFaq()
    {
        $id = htmlspecialchars($this->input->post('id'), true);
        $judul = htmlspecialchars($this->input->post('judul'), true);
        $deskripsi = $this->input->post('deskripsi');
        $order = htmlspecialchars($this->input->post('order'), true);
        
        if (isset($id) && $id != '') {
            $faq = [
                'judul' => $judul,
                'deskripsi' => $deskripsi,
                'order' => $order,
                'modified_at' => time(),
                'modified_by' => $this->session->userdata('user_id')
            ];
        } else {
            $faq = [
                'judul' => $judul,
                'deskripsi' => $deskripsi,
                'order' => $order,
                'created_at' => time(),
                'created_by' => $this->session->userdata('user_id')
            ];
        }
        if (isset($id) && $id != '') {
            $this->db->where('id', $id);
            $this->db->update('m_faq', $faq);
            return ($this->db->affected_rows() != 1) ? false : true;
        } else {
            $this->db->insert('m_faq', $faq);
            return ($this->db->affected_rows() != 1) ? false : true;
        }
    }

    public function deleteFaq()
    {
        $id = htmlspecialchars($this->input->post('id'), true);

        $this->db->where('id', $id);
        $this->db->update('m_faq', ['is_deleted' => 1]);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
}
