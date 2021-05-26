<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Stock extends CI_Controller
{	
    public function __construct()
    {
        parent::__construct();
		authentication();
    }

    public function index()
    {
        $data['title'] = 'Data Stok';

        $this->load->view('templates/header', $data);
        $this->load->view('stock/index', $data);
        $this->load->view('templates/footer');
		$this->load->view('templates/js/stock');
    }
	
	public function getData()
	{
		$this->load->library("datatables_ssp");
		$_table = "stock";
		$_conn 	= [
			"user" 	=> $this->db->username,
			"pass" 	=> $this->db->password,
			"db" 	=> $this->db->database,
			"host" 	=> $this->db->hostname,
			"port" 	=> $this->db->port
		];
		$_key	= "stock_id";
		$_coll	= [
			["db" => "item_desc",			"dt" => "item_desc"],
			["db" => "stock_exist",			"dt" => "stock_exist"],
			["db" => "stock_min",			"dt" => "stock_min"],
			["db" => "stock_updated_date",	"dt" => "stock_updated_date"],
			["db" => "stock_id",			"dt" => "stock_id"],
		];
		
		$_where	= NULL;
		$_join	= "JOIN item ON stock.item_id = item.item_id";

		echo json_encode(
			Datatables_ssp::complex($_GET, $_conn, $_table, $_key, $_coll, $_where, NULL, $_join)
		);
	}
	
	public function update()
	{
		$stock_id			= $this->input->post('stock_id');
		$item_desc			= $this->input->post('item_desc');
		$stock_min			= $this->input->post('stock_min');
		$stock_exist		= $this->input->post('stock_exist');
		$stock_updated_date	= date("Y-m-d H:i:s");
		
		$data = array(
			'stock_min'			=> $stock_min,
			'stock_max'			=> $stock_max,
			'stock_exist'		=> $stock_exist,
			'stock_updated_date'=> $stock_updated_date
		);
		$where = array('stock_id' => $stock_id);
	 
		$this->MasterModel->edit('stock', $where, $data);
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Stok '.strtoupper($item_desc).' berhasil diperbarui !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('stock');
	}
}
