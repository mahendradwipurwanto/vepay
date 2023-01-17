<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_transaksi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_master');
    }

    public function getAllTransaksi(){

        $offset = $this->input->post('start');
        $limit  = $this->input->post('length'); // Rows display per page
        
        $filter = [];

        $filterEmail = $this->input->post('filterEmail');  
        $filterName = $this->input->post('filterName');  
        $filterNumber = $this->input->post('filterNumber');

        $filterKode = $this->input->post('filterKode');   
        $filterProduct = $this->input->post('filterProduct');   
        $filterMetode = $this->input->post('filterMetode');   

        if($filterEmail != null || $filterEmail != '') $filter[] = "b.email like '%{$filterEmail}%'";
        if($filterName != null || $filterName != '') $filter[] = "c.name like '%{$filterName}%'";
        if($filterNumber != null || $filterNumber != '') $filter[] = "c.phone like '%{$filterNumber}%'";

        if($filterKode != null || $filterKode != '') $filter[] = "a.kode like '%{$filterKode}%'";
        if($filterMetode != null && $filterMetode > 0) $filter[] = "a.m_metode_id = {$filterMetode}";

        if($filter != null){
            $filter = implode(' AND ', $filter);
        }  

        $this->db->select('a.*, b.email, c.*, d.metode')
        ->from('tb_transaksi a')
        ->join('tb_auth b', 'a.user_id = b.user_id', 'inner')
        ->join('tb_user c', 'a.user_id = c.user_id', 'inner')
        ->join('m_metode d', 'a.m_metode_id = d.id', 'inner')
        ->where(['a.is_deleted' => 0])
        ;

        $this->db->where($filter);
        $this->db->order_by('a.created_at DESC');

        // $this->db->limit($limit)->offset($offset);

        $models = $this->db->get()->result();

        foreach($models as $key => $val){
            
            $btnDetail          = '<button onclick="showMdlTransDetail(\''.$val->id.'\')" class="btn btn-soft-info btn-icon btn-sm me-2"><i class="bi-eye"></i></button>';
            $btnVerif           = '<button onclick="showMdlTransVerif(\''.$val->user_id.'\', \''.$val->id.'\', \''.base_url().$val->bukti.'\')" class="btn btn-soft-primary btn-icon btn-sm me-2"><i class="bi-check"></i></button>';
            
            $status             = '<span class="badge bg-secondary">Pending</span>';

            switch ($val->status) {
                case 1:
                        $status = '<span class="badge bg-secondary">Pending</span>';
                    break;

                case 2:
                        $status = '<span class="badge bg-success">Success</span>';
                    break;

                case 3:
                        $status = '<span class="badge bg-danger">Rejected</span>';
                    break;

                case 4:
                        $status = '<span class="badge bg-warning">Expired</span>';
                    break;
                
                default:
                        $status = '<span class="badge bg-secondary">Pending</span>';
                    break;
            }

            $models[$key]->kode     = $val->kode;
            $models[$key]->tanggal  = date("d F Y, H:i", $val->created_at);
            $models[$key]->name     = $val->name;
            $models[$key]->metode   = $val->metode;
            $product = $this->getProductTransaksi($val->id)['product'];
            $models[$key]->produk   = "<b>{$product['product']}</b> x{$product['jumlah']}";
            $models[$key]->total    = $val->sub_total;
            $models[$key]->status   = $status;

            $models[$key]->action = $btnDetail.$btnVerif;
        }

        $totalRecords = count($models);

        $models = array_slice($models, $offset, $limit);
        return ['records' => array_values($models), 'totalDisplayRecords' => count($models), 'totalRecords' => $totalRecords];
    }

    function getProductTransaksi($id_transaksi = null){
        $this->db->select('a.*, c.name, c.image')
        ->from('_transaksi_detail a')
        ->join('m_price b', 'a.m_price_id = b.id')
        ->join('m_product c', 'b.m_product_id = c.id')
        ->where(['a.transaksi_id' => $id_transaksi, 'a.is_deleted' => 0])
        ;

        $models = $this->db->get()->result();

        $arrModels = [];

        foreach($models as $key => $val){
            $arrModels[$key]['price_id'] = $val->m_price_id;
            $arrModels[$key]['product'] = $val->name;
            $arrModels[$key]['product_img'] = $val->image;
            $arrModels[$key]['jumlah'] = $val->quantity;
            $arrModels[$key]['harga'] = $val->price;
            $arrModels[$key]['total'] = $val->total;
        }

        return [
            'list_product' => $arrModels,
            'product' => $arrModels[0]
        ];
    }

    public function getDetailTransaksi($id_transaksi = null){
        $this->db->select('a.*, b.quantity as jumlah, d.name as product, e.email, f.name, f.phone, g.metode')
        ->from('tb_transaksi a')
        ->join('_transaksi_detail b', 'a.id = b.transaksi_id', 'inner')
        ->join('m_price c', 'b.m_price_id = c.id', 'inner')
        ->join('m_product d', 'c.m_product_id = d.id', 'inner')
        ->join('tb_auth e', 'a.user_id = e.user_id', 'inner')
        ->join('tb_user f', 'a.user_id = f.user_id', 'inner')
        ->join('m_metode g', 'a.m_metode_id = g.id', 'inner')
        ->where(['a.id' => $id_transaksi, 'a.is_deleted' => 0])
        ;

        $model = $this->db->get()->row();
        
        return $model;

    }

    function addTransaksi($image = null){

        // get detail product
        $rate_product   = $this->M_master->getDetailRateProduct($this->input->post('produk'));
        $product        = $this->M_master->getDetailProduct($rate_product->m_product_id);
        $sub_total      = $rate_product->price * $this->input->post('jumlah');
        
        if (is_null($image)) {
            $data = [
                'id'                => rand(000000000, 999999999),
                'kode'              => generateRandomString(),
                'user_id'           => $this->input->post('member'),
                'm_metode_id'       => $this->input->post('metode'),
                'account'           => $this->input->post('account'),
                'notes'             => $this->input->post('notes'),
                'sub_total'         => $sub_total,
                'created_at'        => time(),
                'created_by'        => $this->session->userdata('user_id'),
            ];
        } else {
            $data = [
                'id'                => rand(000000000, 999999999),
                'kode'              => generateRandomString(),
                'user_id'           => $this->input->post('member'),
                'm_metode_id'       => $this->input->post('metode'),
                'account'           => $this->input->post('account'),
                'notes'             => $this->input->post('notes'),
                'sub_total'         => $sub_total,
                'bukti'             => $image,
                'created_at'        => time(),
                'created_by'        => $this->session->userdata('user_id'),
            ];
        }

        $this->db->insert('tb_transaksi', $data);
        $transaksi_id = $this->db->insert_id();

        $data = [
            'transaksi_id'      => $transaksi_id,
            'm_price_id'        => $this->input->post('produk'),
            'quantity'          => $this->input->post('jumlah'),
            'price'             => $rate_product->price,
            'total'             => $sub_total,
            'created_at'        => time(),
            'created_by'        => $this->session->userdata('user_id'),
        ];

        $this->db->insert('_transaksi_detail', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function verificationPayment()
    {
        $user_id = $this->input->post('user_id');
        $id = $this->input->post('id');
    
        $data = [
            'status' => 2,
            'modified_at' => time(),
            'modified_by' => $this->session->userdata('user_id')
        ];

        $this->db->where('id', $id);
        $this->db->update('tb_transaksi', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function rejectedPayment()
    {
        $id = $this->input->post('id');

        $data = [
            'status' => 3,
            'modified_at' => time(),
            'modified_by' => $this->session->userdata('user_id')
        ];

        $this->db->where('id', $id);
        $this->db->update('tb_transaksi', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function pendingPayment()
    {
        $id = $this->input->post('id');

        $data = [
            'status' => 1,
            'modified_at' => time(),
            'modified_by' => $this->session->userdata('user_id')
        ];

        $this->db->where('id', $id);
        $this->db->update('tb_transaksi', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }


    public function cancelPayment()
    {
        $id = $this->input->post('id');

        $data = [
            'status' => 4,
            'modified_at' => time(),
            'modified_by' => $this->session->userdata('user_id')
        ];

        $this->db->where('id', $id);
        $this->db->update('tb_transaksi', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
}
