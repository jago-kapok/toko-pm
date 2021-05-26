<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Purchase extends CI_Controller
{	
    public function __construct()
    {
        parent::__construct();
		authentication();
    }

    public function index()
    {
        $data['title'] = 'Data Pembelian';

        $this->load->view('templates/header', $data);
        $this->load->view('purchase/index', $data);
        $this->load->view('templates/footer');
		$this->load->view('templates/js/purchase');
    }
	
	public function getData()
	{
		$this->load->library("datatables_ssp");
		$_table = "purchase";
		$_conn 	= [
			"user" 	=> $this->db->username,
			"pass" 	=> $this->db->password,
			"db" 	=> $this->db->database,
			"host" 	=> $this->db->hostname,
			"port" 	=> $this->db->port
		];
		$_key	= "purchase_id";
		$_coll	= [
			["db" => "purchase_date",	"dt" => "purchase_date",
				"formatter" => function($d, $row){
					return date("d-m-Y", strtotime($d));
				}
			],
			["db" => "purchase_number",	"dt" => "purchase_number"],
			["db" => "supplier_name",	"dt" => "supplier_name"],
			["db" => "purchase_total",	"dt" => "purchase_total",
				"formatter" =>  function($d, $row){
					return number_format($d);
				}
			],
			["db" => "purchase_id",		"dt" => "purchase_id"]
		];
		
		$_where	= "purchase_status IS NULL";
		$_join	= "JOIN supplier ON purchase.supplier_id = supplier.supplier_id";

		echo json_encode(
			Datatables_ssp::complex($_GET, $_conn, $_table, $_key, $_coll, $_where, NULL, $_join)
		);
	}
	
	public function formCreate()
    {
        $data['title'] = 'Data Pembelian';

        $this->load->view('templates/header', $data);
        $this->load->view('purchase/form-create', $data);
        $this->load->view('templates/footer');
		$this->load->view('templates/js/purchase');
    }
	
	public function create()
	{
		$purchase_number	= $this->input->post('purchase_number');
		$purchase_date		= $this->input->post('purchase_date');
		$supplier_id		= $this->input->post('supplier_id');
		$purchase_total		= $this->input->post('purchase_total');
		
		$data = array(
			'purchase_number'			=> $purchase_number,
			'purchase_date'				=> $purchase_date,
			'supplier_id'				=> $supplier_id,
			'purchase_total'			=> $purchase_total,
			'purchase_modified_date'	=> date('Y-m-d H:i:s')
		);
	 
		if($this->input->post('purchase_id') == ''){
			$this->MasterModel->add('purchase', $data);
			$purchase_id = $this->db->insert_id();
		} else {
			$purchase_id = $this->input->post('purchase_id');
			
			$where = array('purchase_id' => $purchase_id);
			$this->MasterModel->edit('purchase', $where, $data);
			$this->MasterModel->delete('purchase_detail', $where);
			$this->updateStock($purchase_number, 1);
			$this->MasterModel->delete('stock_history', array('stock_history_number'=>$purchase_number));
		}
		
		$result = array();
		foreach($_POST['detail_item_price'] as $key => $value){
			$item_id	= $_POST['detail_item_id'][$key];
			$item_qty	= $_POST['detail_item_qty'][$key];

			$result[] = array(
				"purchase_id"		=> $purchase_id,
				"detail_item_id"	=> $item_id,
				"detail_item_code"	=> $_POST['detail_item_code'][$key],
				"detail_item_desc"	=> $_POST['detail_item_desc'][$key],
				"detail_item_qty"	=> $item_qty,
				"detail_item_unit"	=> $_POST['detail_item_unit'][$key],
				"detail_item_price"	=> $_POST['detail_item_price'][$key]
			);
			
			$this->createStockHistory($item_id, $item_qty, $purchase_number);
		}
		
		$this->updateStock($purchase_number, 0);
		$this->db->insert_batch('purchase_detail', $result);
		
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Transaksi berhasil disimpan !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		
		redirect('purchase');
	}
	
	public function update()
	{
		$purchase_id = $this->uri->segment(3);
		$this->session->set_userdata("purchase_id", $purchase_id);
		redirect('purchase/formUpdate');
	}

	public function formUpdate()
    {
        $data['title'] = 'Edit Data Pembelian';
		
		$purchase = $this->MasterModel->getBy('purchase', array('purchase_id'=>$_SESSION['purchase_id']))->row();
		$purchase_detail = $this->MasterModel->getBy('purchase_detail', array('purchase_id'=>$_SESSION['purchase_id']))->result();
		
		$data['purchase'] = $purchase;
		$data['purchase_detail'] = $purchase_detail;
		$data['supplier'] = $this->MasterModel->getBy('supplier', array('supplier_id'=>$purchase->supplier_id))->row();

        $this->load->view('templates/header', $data);
        $this->load->view('purchase/form-update', $data);
        $this->load->view('templates/footer');
		$this->load->view('templates/js/purchase');
    }

    public function delete()
    {
        $where = ['purchase_id' => $this->uri->segment(3)];
		$query = $this->MasterModel->getBy('purchase', $where);
		$row = $query->row();
		
        $this->MasterModel->edit('purchase', $where, array("purchase_status"=>1));
		$this->updateStock($row->purchase_number, 1);
        $this->MasterModel->delete('stock_history', array('stock_history_number'=>$row->purchase_number));
		
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Transaksi '.strtoupper($row->purchase_number).' berhasil dihapus !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('purchase');
    }
	
	public function updateStock($purchase_number, $status)
	{
		$query = $this->MasterModel->getBy('stock_history', array('stock_history_number'=>$purchase_number))->result_array();
		
		foreach($query as $row){
			$stock = $this->MasterModel->getBy('stock', array('item_id'=>$row['item_id']))->row();
			
			if($status == 0){
				$stock_exist = $stock->stock_exist + $row['stock_history_item_qty'];
			} else {
				$stock_exist = $stock->stock_exist - $row['stock_history_item_qty'];
			}
			
			$data = array(
				'stock_exist' => $stock_exist
			);
			$where = array('item_id'=>$row['item_id']);
		
			$this->MasterModel->edit('stock', $where, $data);
		}
	}
	
	public function createStockHistory($item_id, $item_qty, $item_number)
	{
		$data = array(
			'item_id'				=> $item_id,
			'stock_history_item_qty'=> $item_qty,
			'stock_history_number'	=> $item_number,
			'stock_history_type'	=> 1
		);
		
		$this->MasterModel->add('stock_history', $data);
	}
}
