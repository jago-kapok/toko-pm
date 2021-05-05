<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Item extends CI_Controller
{	
    public function __construct()
    {
        parent::__construct();
		// authentication();
    }

    public function index()
    {
        $data['title'] = 'Data Produk';
		
		$data['category']	= $this->db->get('category')->result_array();
		$data['supplier']	= $this->db->get('supplier')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('item/index', $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/js/item');
    }
	
	public function getData()
	{
		$this->load->library("datatables_ssp");
		$_table = "item";
		$_conn 	= [
			"user" 	=> $this->db->username,
			"pass" 	=> $this->db->password,
			"db" 	=> $this->db->database,
			"host" 	=> $this->db->hostname,
			"port" 	=> $this->db->port
		];
		$_key	= "item_id";
		$_coll	= [
			["db" => "item_code",	"dt" => "item_code"],
			["db" => "category_id",	"dt" => "category_id"],
			["db" => "item_desc",	"dt" => "item_desc"],
			["db" => "item_unit",	"dt" => "item_unit"],
			["db" => "item_price",	"dt" => "item_price"],
			["db" => "supplier_id",	"dt" => "supplier_id"],
			["db" => "item_id",		"dt" => "item_id"],
			
			["db" => "item_buy",	"dt" => "item_buy"],
		];
		
		$_where	= NULL;
		$_join	= NULL;
		
		echo json_encode(
			Datatables_ssp::complex($_GET, $_conn, $_table, $_key, $_coll, $_where, NULL, $_join)
		);
	}
	
	public function create()
	{
		$item_code		= $this->input->post('item_code');
		$category_id	= $this->input->post('category_id');
		$item_desc		= $this->input->post('item_desc');
		$item_unit		= $this->input->post('item_unit');
		$item_buy		= $this->input->post('item_buy');
		$item_price		= $this->input->post('item_price');
		$supplier_id	= $this->input->post('supplier_id');
		
		$data = array(
			'item_code' 	=> $item_code,
			'category_id' 	=> $category_id,
			'item_desc' 	=> $item_desc,
			'item_unit' 	=> $item_unit,
			'item_buy' 		=> $item_buy,
			'item_price' 	=> $item_price,
			'supplier_id' 	=> $supplier_id,
		);
	 
		$exist = $this->MasterModel->getBy('item', array('item_code'=>$item_code));
		
		if($exist->num_rows() == 0){
			$this->MasterModel->add('item', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data berhasil ditambahkan !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Kode '.strtoupper($item_code).' sudah digunakan !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		}
		redirect('item');
	}
	
	public function update()
	{
		$item_id		= $this->input->post('item_id');
		$$item_code		= $this->input->post('item_code');
		$category_id	= $this->input->post('category_id');
		$item_desc		= $this->input->post('item_desc');
		$item_unit		= $this->input->post('item_unit');
		$item_buy		= $this->input->post('item_buy');
		$item_price		= $this->input->post('item_price');
		$supplier_id	= $this->input->post('supplier_id');
		
		$data = array(
			'item_code' 	=> $item_code,
			'category_id' 	=> $category_id,
			'item_desc' 	=> $item_desc,
			'item_unit' 	=> $item_unit,
			'item_buy' 		=> $item_buy,
			'item_price' 	=> $item_price,
			'supplier_id' 	=> $supplier_id,
		);
		$where = array('item_id' => $item_id);
	 
		$exist = $this->MasterModel->getBy('item', array('item_code'=>$item_code));
		
		if($exist->num_rows() == 0){
			$this->MasterModel->edit('item', $where, $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data berhasil diperbarui !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Kode '.strtoupper($item_desc).' sudah digunakan !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		}
		redirect('item');
	}

    public function delete()
    {
        $where = ['item_id' => $this->uri->segment(3)];
		$query = $this->MasterModel->getBy('item', $where);
		$row = $query->row();
		
        $this->MasterModel->delete('item', $where);
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data '.strtoupper($row->item_code).' berhasil dihapus !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('item');
    }
	
	public function findData()
    {
		$term = $_GET['term'];
  
		if(isset($term)){
			$result = $this->db->like('item_code', $term, 'both')->or_like('item_desc', $term, 'both')->get('item')->result_array();
			
			$output = [];
			if(count($result) > 0){
				foreach($result as $data){
					$output[] = array(
						"item_id"	=> $data['item_id'],
						"item_code"	=> $data['item_code'],
						"item_desc"	=> $data['item_desc'],
						"item_unit"	=> $data['item_unit']
					);
				}
			} else {
				$output[] = array("item_desc" => "Data tidak ditemukan");
			}
			
			echo json_encode($output);
		}
	}
}