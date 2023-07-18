<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_transaksi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_master');
    }

    public function getAllTransaksi()
    {

        $offset = $this->input->post('start');
        $limit  = $this->input->post('length'); // Rows display per page
        $order  = $this->input->post('order')[0];

        $filter = [];

        $filterEmail = $this->input->post('filterEmail');
        $filterName = $this->input->post('filterName');
        $filterNumber = $this->input->post('filterNumber');

        $filterKode = $this->input->post('filterKode');
        $filterProduct = $this->input->post('filterProduct');
        $filterMetode = $this->input->post('filterMetode');
        $filterStatus = $this->input->post('filterStatus');

        if ($filterEmail != null || $filterEmail != '') $filter[] = "b.email like '%{$filterEmail}%'";
        if ($filterName != null || $filterName != '') $filter[] = "c.name like '%{$filterName}%'";
        if ($filterNumber != null || $filterNumber != '') $filter[] = "c.phone like '%{$filterNumber}%'";

        if ($filterKode != null || $filterKode != '') $filter[] = "a.kode like '%{$filterKode}%'";
        if ($filterMetode != null && $filterMetode > 0) $filter[] = "a.m_metode_id = {$filterMetode}";
        if ($filterStatus != null && $filterStatus > 0) $filter[] = "a.status = {$filterStatus}";

        if ($filter != null) {
            $filter = implode(' AND ', $filter);
        }

        $this->db->select('a.*, b.email, c.*, d.metode')
            ->from('tb_transaksi a')
            ->join('tb_auth b', 'a.user_id = b.user_id', 'inner')
            ->join('tb_user c', 'a.user_id = c.user_id', 'inner')
            ->join('m_metode d', 'a.m_metode_id = d.id', 'left')
            ->where(['a.is_deleted' => 0]);

        $this->db->where($filter);

        if (!is_null($order)) {

            switch ($order['column']) {
                case 0:
                    $columnName = 'a.created_at';
                    break;

                case 2:
                    $columnName = 'a.kode';
                    break;

                case 3:
                    $columnName = 'a.status';
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

            $btnDetail          = '<button onclick="showMdlTransDetail(\'' . $val->id . '\')" class="btn btn-soft-info btn-icon btn-sm me-2"><i class="bi-eye"></i></button>';
            $btnVerif           = '<button onclick="showMdlTransVerif(\'' . $val->user_id . '\', \'' . $val->id . '\', \'' . base_url() . $val->bukti . '\')" class="btn btn-soft-primary btn-icon btn-sm me-2"><i class="bi-check"></i></button>';
            $btnHapus          = '<button onclick="showMdlTransDelete(\'' . $val->id . '\', \'' . $val->kode . '\')" class="btn btn-soft-danger btn-icon btn-sm me-2"><i class="bi-trash"></i></button>';

            $models[$key]->action = $btnDetail . ($val->status == 2 ? '' : $btnVerif) . $btnHapus;

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

            $jenis_vcc = "";
            if (isset($val->jenis_transaksi_vcc)) {
                if ($val->jenis_transaksi_vcc == 0) {
                    $jenis_vcc = " - <i>(Top Up VCC)</i>";
                } else {
                    $jenis_vcc = " - <i>(Withdraw VCC)</i>";
                }
            }

            if (!is_null($product)) {
                $models[$key]->produk   = "<b>{$product['product']}</b> x{$product['jumlah']} {$jenis_vcc} - <i>{$product['type']}</i>";
            } else {
                $models[$key]->produk   = "-";
            }
            $models[$key]->total    = $val->sub_total;
            $models[$key]->status   = $status;
        }

        $totalRecords = count($models);

        $models = array_slice($models, $offset, $limit);
        return ['records' => array_values($models), 'totalDisplayRecords' => count($models), 'totalRecords' => $totalRecords];
    }

    public function getAllTransaksiReferral()
    {

        $offset = $this->input->post('start');
        $limit  = $this->input->post('length'); // Rows display per page
        $order  = $this->input->post('order')[0];

        $filter = [];

        $filterName = $this->input->post('filterName');
        $filterNumber = $this->input->post('filterNumber');

        $filterKode = $this->input->post('filterKode');
        $filterStatus = $this->input->post('filterStatus');

        if ($filterName != null || $filterName != '') $filter[] = "c.name like '%{$filterName}%'";
        if ($filterNumber != null || $filterNumber != '') $filter[] = "c.phone like '%{$filterNumber}%'";

        if ($filterKode != null || $filterKode != '') $filter[] = "a.kode like '%{$filterKode}%'";
        if ($filterStatus != null && $filterStatus >= 0) $filter[] = "a.status = {$filterStatus}";

        if ($filter != null) {
            $filter = implode(' AND ', $filter);
        }

        $this->db->select('a.*, b.email, c.*, d.metode, e.status as status_withdraw')
            ->from('tb_transaksi_referral a')
            ->join('tb_auth b', 'a.user_id = b.user_id', 'inner')
            ->join('tb_user c', 'a.user_id = c.user_id', 'inner')
            ->join('m_metode d', 'a.m_metode_id = d.id', 'left')
            ->join('tb_transaksi e', 'a.transaksi_id = e.id', 'left')
            ->where(['a.is_deleted' => 0]);

        $this->db->where($filter);

        if (!is_null($order)) {

            switch ($order['column']) {
                case 0:
                    $columnName = 'a.created_at';
                    break;

                case 2:
                    $columnName = 'a.kode';
                    break;

                case 3:
                    $columnName = 'a.status';
                    break;

                case 4:
                    $columnName = 'a.created_at';
                    break;

                case 5:
                    $columnName = 'a.nominal';
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

            $btnDetail          = '<button onclick="showMdlTransDetail(\'' . $val->id . '\')" class="btn btn-soft-info btn-icon btn-sm me-2"><i class="bi-eye"></i></button>';
            $btnVerif           = '<button onclick="showMdlTransVerif(\'' . $val->user_id . '\', \'' . $val->id . '\', \'' . base_url() . $val->bukti . '\')" class="btn btn-soft-primary btn-icon btn-sm me-2"><i class="bi-check"></i></button>';
            $btnHapus          = '<button onclick="showMdlTransDelete(\'' . $val->id . '\', \'' . $val->kode . '\')" class="btn btn-soft-danger btn-icon btn-sm me-2"><i class="bi-trash"></i></button>';

            $status             = '<span class="badge bg-secondary">Pending</span>';
            if ($val->type == 1) {
                $models[$key]->action = $btnDetail;
                switch ($val->status_withdraw) {
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
            } else {
                $models[$key]->action = $btnDetail . ($val->status == 2 ? '' : $btnVerif) . $btnHapus;
                switch ($val->status) {
                    case 0:
                        $status = '<span class="badge bg-secondary">Pending</span>';
                        break;
    
                    case 1:
                        $status = '<span class="badge bg-success">Success</span>';
                        break;
    
                    case 2:
                        $status = '<span class="badge bg-danger">Rejected</span>';
                        break;
    
                    case 3:
                        $status = '<span class="badge bg-warning">Expired</span>';
                        break;
    
                    default:
                        $status = '<span class="badge bg-secondary">Pending</span>';
                        break;
                }
            }

            switch ($val->type) {
                case 1:
                    $type = '<span class="badge bg-success">Cashback</span>';
                    break;

                case 2:
                    $type = '<span class="badge bg-warning">Withdraw</span>';
                    break;

                default:
                    $type = '<span class="badge bg-secondary">-</span>';
                    break;
            }

            $models[$key]->kode     = $val->kode;
            $models[$key]->type     = $type;
            $models[$key]->tanggal  = date("d F Y, H:i", $val->created_at);
            $models[$key]->name     = $val->name;
            $models[$key]->metode   = $val->metode;
            $models[$key]->nominal    = "Rp. " . number_format($val->nominal, 0, ",", ".");;
            $models[$key]->status   = $status;
        }

        $totalRecords = count($models);

        $models = array_slice($models, $offset, $limit);
        return ['records' => array_values($models), 'totalDisplayRecords' => count($models), 'totalRecords' => $totalRecords];
    }

    function getProductTransaksi($id_transaksi = null)
    {
        $this->db->select('a.*, b.type, c.name, c.image')
            ->from('_transaksi_detail a')
            ->join('m_price b', 'a.m_price_id = b.id')
            ->join('m_product c', 'b.m_product_id = c.id')
            ->where(['a.transaksi_id' => $id_transaksi, 'a.is_deleted' => 0]);

        $models = $this->db->get()->result();

        $arrModels = [];

        if (!empty($models)) {
            foreach ($models as $key => $val) {
                $arrModels[$key]['price_id'] = $val->m_price_id;
                $arrModels[$key]['product'] = $val->name;
                $arrModels[$key]['product_img'] = $val->image;
                $arrModels[$key]['type'] = $val->type;
                $arrModels[$key]['jumlah'] = $val->quantity;
                $arrModels[$key]['harga'] = $val->price;
                $arrModels[$key]['total'] = $val->total;
            }
        }

        return [
            'list_product' => $arrModels,
            'product' => !empty($models) ? $arrModels[0] : null
        ];
    }

    public function getAllTransaksiUser($params = [])
    {
        $this->db->select('a.*, b.email, c.*, d.metode')
            ->from('tb_transaksi a')
            ->join('tb_auth b', 'a.user_id = b.user_id', 'inner')
            ->join('tb_user c', 'a.user_id = c.user_id', 'inner')
            ->join('m_metode d', 'a.m_metode_id = d.id', 'left')
            ->where(['a.is_deleted' => 0]);

        $this->db->where(['a.user_id' => $params['user_id']]);
        $this->db->order_by('a.created_at DESC');

        // $this->db->limit($limit)->offset($offset);

        $models = $this->db->get()->result();

        foreach ($models as $key => $val) {
            $models[$key]       = $val;
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

            $jenis_vcc = "";
            if (isset($val->jenis_transaksi_vcc)) {
                if ($val->jenis_transaksi_vcc == 0) {
                    $jenis_vcc = " - <i>(Top Up VCC)</i>";
                } else {
                    $jenis_vcc = " - <i>(Withdraw VCC)</i>";
                }
            }

            if (!is_null($product)) {
                $models[$key]->produk   = "Melakukan <i>{$product['type']}</i> - <b>{$product['product']}</b> x{$product['jumlah']} {$jenis_vcc}";
            } else {
                $models[$key]->produk   = "-";
            }
            $models[$key]->total    = $val->sub_total;
            $models[$key]->status   = $status;
        }

        return $models;
    }

    public function getDetailTransaksi($id_transaksi = null)
    {
        $this->db->select('a.*, b.quantity as jumlah, d.name as product, d.is_vcc, e.email, f.name, f.phone, g.metode, g.image as img_metode, h.blockchain, i.number as vcc_number, i.holder as vcc_holder, i.jenis_vcc')
            ->from('tb_transaksi a')
            ->join('_transaksi_detail b', 'a.id = b.transaksi_id', 'inner')
            ->join('m_price c', 'b.m_price_id = c.id', 'inner')
            ->join('m_product d', 'c.m_product_id = d.id', 'inner')
            ->join('tb_auth e', 'a.user_id = e.user_id', 'inner')
            ->join('tb_user f', 'a.user_id = f.user_id', 'inner')
            ->join('m_metode g', 'a.m_metode_id = g.id', 'left')
            ->join('m_blockchain h', 'a.m_blockchain_id = h.id', 'left')
            ->join('tb_vcc i', 'a.m_vcc_id = i.id', 'left')
            ->where(['a.id' => $id_transaksi, 'a.is_deleted' => 0]);

        $model = $this->db->get()->row();

        if (!is_null($model)) {
            $model->diskon = round($this->getTotalDetail($id_transaksi) - $model->sub_total);
        }

        return $model;
    }

    public function getDetailTransaksiReferral($id_transaksi = null)
    {
        $this->db->select('
                tb_transaksi_referral.id,
                tb_transaksi_referral.kode,
                tb_transaksi_referral.type,
                tb_transaksi_referral.rekening_tujuan,
                tb_transaksi_referral.atas_nama,
                m_metode.metode,
                m_metode.image as img_metode,
                tb_transaksi_referral.nominal,
                tb_transaksi_referral.status,
                tb_transaksi_referral.created_at,
                tb_user.name,
                tb_user.phone,
                tb_transaksi.status as status_withdraw,
            ')
            ->from('tb_transaksi_referral')
            ->join('m_metode', 'tb_transaksi_referral.m_metode_id = m_metode.id', 'left')
            ->join('tb_user', 'tb_transaksi_referral.user_id = tb_user.user_id')
            ->join('tb_transaksi', 'tb_transaksi_referral.transaksi_id = tb_transaksi.id', 'left')
            ->where(['tb_transaksi_referral.id' => $id_transaksi]);

        $model = $this->db->get()->row();

        return $model;
    }

    function getTotalDetail($id_transaksi = null)
    {
        return $this->db->select_sum('total')->from('_transaksi_detail')->where(['transaksi_id' => $id_transaksi])->get()->row()->total;
    }

    function addTransaksi($image = null)
    {

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

    public function verificationPayment($filename = null)
    {
        $user_id = $this->input->post('user_id');
        $id = $this->input->post('id');

        $data = [
            'bukti_verif' => $filename,
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


    public function deletePayment()
    {
        $id = $this->input->post('id');

        $data = [
            'is_deleted' => 1,
            'modified_at' => time(),
            'modified_by' => $this->session->userdata('user_id')
        ];

        $this->db->where('id', $id);
        $this->db->update('tb_transaksi', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function verificationPaymentReferral($filename = null)
    {
        $user_id = $this->input->post('user_id');
        $id = $this->input->post('id');

        $data = [
            'bukti' => $filename,
            'status' => 1,
            'modified_at' => time(),
            'modified_by' => $this->session->userdata('user_id')
        ];

        $this->db->where('id', $id);
        $this->db->update('tb_transaksi_referral', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function rejectedPaymentReferral()
    {
        $id = $this->input->post('id');

        $data = [
            'status' => 2,
            'modified_at' => time(),
            'modified_by' => $this->session->userdata('user_id')
        ];

        $this->db->where('id', $id);
        $this->db->update('tb_transaksi_referral', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function pendingPaymentReferral()
    {
        $id = $this->input->post('id');

        $data = [
            'status' => 0,
            'modified_at' => time(),
            'modified_by' => $this->session->userdata('user_id')
        ];

        $this->db->where('id', $id);
        $this->db->update('tb_transaksi_referral', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }


    public function cancelPaymentReferral()
    {
        $id = $this->input->post('id');

        $data = [
            'status' => 3,
            'modified_at' => time(),
            'modified_by' => $this->session->userdata('user_id')
        ];

        $this->db->where('id', $id);
        $this->db->update('tb_transaksi_referral', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }


    public function deletePaymentReferral()
    {
        $id = $this->input->post('id');

        $data = [
            'is_deleted' => 1,
            'modified_at' => time(),
            'modified_by' => $this->session->userdata('user_id')
        ];

        $this->db->where('id', $id);
        $this->db->update('tb_transaksi_referral', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
}
