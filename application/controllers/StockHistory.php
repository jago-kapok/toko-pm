<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class StockHistory extends CI_Controller
{	
    public function __construct()
    {
        parent::__construct();
		authentication();
    }

    public function index()
    {
        $data['title'] = 'Data Riwayat Stok';

        $this->load->view('templates/header', $data);
        $this->load->view('stock-history/index', $data);
        $this->load->view('templates/footer');
		$this->load->view('templates/js/stock-history');
    }
	
	public function getData()
	{
		$this->load->library("datatables_ssp");
		$_table = "stock_history";
		$_conn 	= [
			"user" 	=> $this->db->username,
			"pass" 	=> $this->db->password,
			"db" 	=> $this->db->database,
			"host" 	=> $this->db->hostname,
			"port" 	=> $this->db->port
		];
		$_key	= "stock_history_id";
		$_coll	= [
			["db" => "stock_history_date",			"dt" => "stock_history_date"],
			["db" => "stock_history_category_desc",	"dt" => "stock_history_category_desc"],
			["db" => "stock_history_number",		"dt" => "stock_history_number"],
			["db" => "item_desc",					"dt" => "item_desc"],
			["db" => "stock_history_item_qty",		"dt" => "stock_history_item_qty"]
			
			
		];
		
		$_where	= NULL;
		$_join	= "JOIN stock_history_category ON stock_history.stock_history_type = stock_history_category.stock_history_category_id JOIN item ON stock_history.item_id = item.item_id";

		echo json_encode(
			Datatables_ssp::complex($_GET, $_conn, $_table, $_key, $_coll, $_where, NULL, $_join)
		);
	}
}
