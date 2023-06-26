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

	public function get_allAccount(){

        $offset = $this->input->post('start');
        $limit  = $this->input->post('length'); // Rows display per page
        $order = !empty($this->input->post('order')) ? $this->input->post('order')[0] : $this->input->post('order');
        
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


        $this->db->select('a.email, a.role, a.status, a.online, a.is_deleted, a.log_time, a.device, b.*')
        ->from('tb_auth a')
        ->join('tb_user b', 'a.user_id = b.user_id', 'inner')
        ;

        $this->db->where($filter);

        if(!is_null($order)){

            switch ($order['column']) {
                case 0:
                    $columnName = 'b.name';
                    break;
                    
                case 2:
                    $columnName = 'b.name';
                    break;
                    
                case 3:
                    $columnName = 'a.status';
                    break;
                    
                case 4:
                    $columnName = 'a.log_time';
                    break;
                
                default:
                    $columnName = 'a.log_time';
                    break;
            }
            $this->db->order_by("{$columnName} {$order['dir']}");
        }

        // $this->db->limit($limit)->offset($offset);

        $models = $this->db->get()->result();

        foreach($models as $key => $val){

            $strip_email                    = explode("@", $val->email);
            $name = $val->name;

            if(is_null($val->name) || $val->name == ''){
                $name = $strip_email[0].' <span class="badge bg-soft-warning">belum mengatur nama</span>';
            }
    
            if($val->role == 0){
                $models[$key]->role  = '<span data-bs-toggle="tooltip" data-bs-html="true" title="Super Admin" class="badge bg-soft-danger small ms-2">Super Admin</span>';
            }elseif($val->role == 1){
                $models[$key]->role = '<span data-bs-toggle="tooltip" data-bs-html="true" title="Admin" class="badge bg-soft-info small ms-2">Admin</span>';
            }elseif($val->role == 2){
                $models[$key]->role = '<span data-bs-toggle="tooltip" data-bs-html="true" title="Member" class="badge bg-soft-warning small ms-2">Member</span>';
            }

            $models[$key]->name             = $name." ".$models[$key]->role;
            $models[$key]->phone            = isset($val->phone) && !is_null($val->phone) ? "+62{$val->phone}" : "<span class='badge bg-warning'>belum diatur</span>";
    
            if($val->status == 1){
                $models[$key]->status  = '<span class="badge bg-soft-success">Aktif</span>';
            }elseif($val->status == 2){
                $models[$key]->status  = '<span class="badge bg-soft-warning">Suspended</span>';
            }else{
                $models[$key]->status  = '<span class="badge bg-soft-secondary">Belum verifikasi email</span>';
            }
            $models[$key]->log_time = date("d F Y H:i:s", $val->log_time);
            
        }

        $totalRecords = count($models);

        $models = array_slice($models, $offset, $limit);

        return ['records' => array_values($models), 'totalDisplayRecords' => count($models), 'totalRecords' => $totalRecords];
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

        $produk = $this->db->get_where('m_product', ['is_deleted' => 0, 'id !=' => 8])->num_rows();
        $member = $this->db->get_where('tb_auth', ['role' => 2, 'is_deleted' => 0])->num_rows();
        $transaksi = $this->db->get_where('tb_transaksi', ['is_deleted' => 0])->num_rows();
		
		$transaksi_qty = $this->db->select_sum('_transaksi_detail.quantity')->from('_transaksi_detail')->join('tb_transaksi', '_transaksi_detail.transaksi_id = tb_transaksi.id')->where(['tb_transaksi.is_deleted' => 0])->get()->row();

        $this->db->select_sum('sub_total')
        ->from('tb_transaksi')
        ->where(['status' => 2, 'is_deleted' => 0])
        ;

        $pendapatan = $this->db->get()->row();
        
        return [
            'produk' => $produk,
            'member' => $member,
            'transaksi' => $transaksi,
			'transaksi_qty' => $transaksi_qty->quantity,
            'pendapatan' => $pendapatan->sub_total
        ];
    }

	function getDailyTransaksi(){
		// Calculate date 30 days ago
		$date30DaysAgo = date('Y-m-d', strtotime('-30 days'));

		$this->db->select('DATE_FORMAT(FROM_UNIXTIME(tb_transaksi.created_at), "%Y-%m-%d") as tanggal, sum(_transaksi_detail.quantity) as jumlah')
		->from('tb_transaksi')
		->join('_transaksi_detail', 'tb_transaksi.id = _transaksi_detail.transaksi_id', 'left')
		->where('FROM_UNIXTIME(tb_transaksi.created_at) >=', strtotime($date30DaysAgo))
		->where('tb_transaksi.is_deleted', 0)
		->group_by('DATE_FORMAT(FROM_UNIXTIME(tb_transaksi.created_at), "%Y-%m-%d")');
		
		$models = $this->db->get()->result();

		$arr["created_at"] = [];
		$arr["jumlah"] = [];

		// Initialize array with zeros for the last 30 days
		for ($i = 0; $i < 30; $i++) {
			$date = date('Y-m-d', strtotime("-$i days"));
			$arr["created_at"][] = "'$date'";
			$arr["jumlah"][] = 0;
		}

		if(!empty($models)){
			foreach ($models as $key => $val) {
				// Find the index of the date in the array
				$index = array_search("'".$val->tanggal."'", $arr["created_at"]);
				if ($index !== false) {
					// If the date is found, insert the jumlah into the array
					$arr["jumlah"][$index] = $val->jumlah;
				}
			}
		}

		return $arr;
	}

	function getTopProduk(){
		$this->db->select('m_product.name, SUM(_transaksi_detail.quantity) as total_sales')
		->from('m_product')
		->join('m_price', 'm_price.m_product_id = m_product.id')
		->join('_transaksi_detail', '_transaksi_detail.m_price_id = m_price.id')
		->join('tb_transaksi', 'tb_transaksi.id = _transaksi_detail.transaksi_id')
		->where('m_product.is_deleted', 0)
		->where('tb_transaksi.is_deleted', 0)
		->group_by('m_product.id')
		->order_by('total_sales', 'DESC')
		->limit(10);

		return $this->db->get()->result();
	}

	function getTopmember(){
		$this->db->select('tb_user.name, COUNT(tb_transaksi.id) as total_sales')
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
