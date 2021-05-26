<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{	
    public function __construct()
    {
        parent::__construct();
		authentication();
    }

    public function index()
    {
        $data['title'] = 'Data Supplier';

        $this->load->view('templates/header', $data);
        $this->load->view('supplier/index', $data);
        $this->load->view('templates/footer');
		$this->load->view('templates/js/supplier');
    }
	
	public function getData()
	{
		$this->load->library("datatables_ssp");
		$_table = "supplier";
		$_conn 	= [
			"user" 	=> $this->db->username,
			"pass" 	=> $this->db->password,
			"db" 	=> $this->db->database,
			"host" 	=> $this->db->hostname,
			"port" 	=> $this->db->port
		];
		$_key	= "supplier_id";
		$_coll	= [
			["db" => "supplier_code",	"dt" => "supplier_code"],
			["db" => "supplier_name",	"dt" => "supplier_name"],
			["db" => "supplier_address","dt" => "supplier_address"],
			["db" => "supplier_phone",	"dt" => "supplier_phone"],
			["db" => "supplier_id",		"dt" => "supplier_id"]
		];
		
		$_where	= NULL;
		$_join	= NULL;

		echo json_encode(
			Datatables_ssp::complex($_GET, $_conn, $_table, $_key, $_coll, $_where, NULL, $_join)
		);
	}
	
	public function create()
	{
		$supplier_code		= $this->input->post('supplier_code');
		$supplier_name		= $this->input->post('supplier_name');
		$supplier_address	= $this->input->post('supplier_address');
		$supplier_phone		= $this->input->post('supplier_phone');
		
		$data = array(
			'supplier_code'		=> $supplier_code,
			'supplier_name'		=> $supplier_name,
			'supplier_address'	=> $supplier_address,
			'supplier_phone'	=> $supplier_phone
		);
	 
		$exist = $this->MasterModel->getBy('supplier', array('supplier_code'=>$supplier_code));
		
		if($exist->num_rows() == 0){
			$this->MasterModel->add('supplier', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data berhasil ditambahkan !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Kode '.strtoupper($supplier_code).' sudah digunakan !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		}
		redirect('supplier');
	}
	
	public function update()
	{
		$supplier_id		= $this->input->post('supplier_id');
		$supplier_code		= $this->input->post('supplier_code');
		$supplier_name		= $this->input->post('supplier_name');
		$supplier_address	= $this->input->post('supplier_address');
		$supplier_phone		= $this->input->post('supplier_phone');
		
		$data = array(
			'supplier_code'		=> $supplier_code,
			'supplier_name'		=> $supplier_name,
			'supplier_address'	=> $supplier_address,
			'supplier_phone'	=> $supplier_phone
		);
		$where = array('supplier_id' => $supplier_id);
	 
		$exist = $this->MasterModel->getBy('supplier', array('supplier_code'=>$supplier_code));
		
		if($exist->num_rows() <= 1){
			$this->MasterModel->edit('supplier', $where, $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data '.strtoupper($supplier_code).' berhasil diperbarui !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Kode '.strtoupper($supplier_code).' sudah digunakan !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		}
		redirect('supplier');
	}

    public function delete()
    {
        $where = ['supplier_id' => $this->uri->segment(3)];
		$query = $this->MasterModel->getBy('supplier', $where);
		$row = $query->row();
		
        $this->MasterModel->delete('supplier', $where);
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data '.strtoupper($row->supplier_code).' berhasil dihapus !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('supplier');
    }
	
	public function findData()
    {
		$term = $_GET['term'];
  
		if(isset($term)){
			$result = $this->db->like('supplier_code', $term, 'both')->or_like('supplier_name', $term, 'both')->get('supplier')->result_array();
			
			$output = [];
			if(count($result) > 0){
				foreach($result as $data){
					$output[] = array(
						"supplier_id"		=> $data['supplier_id'],
						"supplier_code"		=> $data['supplier_code'],
						"supplier_name"		=> $data['supplier_name'],
						"supplier_address"	=> $data['supplier_address'],
						"supplier_phone"	=> $data['supplier_phone']
					);
				}
			} else {
				$output[] = array("supplier_name" => "Data tidak ditemukan");
			}
			
			echo json_encode($output);
		}
	}
}
