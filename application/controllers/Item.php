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
        $data['title'] = 'Data Barang';

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
			["db" => "item_code",	"dt" => "customer_code"],
			["db" => "customer_name",	"dt" => "customer_name"],
			["db" => "customer_address","dt" => "customer_address"],
			["db" => "customer_phone",	"dt" => "customer_phone"],
			["db" => "item_id",		"dt" => "item_id"]
		];
		
		$_where	= NULL;
		$_join	= NULL;
		
		echo json_encode(
			Datatables_ssp::complex($_GET, $_conn, $_table, $_key, $_coll, $_where, NULL, $_join)
		);
	}
	
	public function create()
	{
		$category_desc = $this->input->post('category_desc');
		
		$data = array(
			'category_desc' => $category_desc
		);
	 
		$exist = $this->MasterModel->getBy('category', array('category_desc'=>$category_desc));
		
		if($exist->num_rows() == 0){
			$this->MasterModel->add('category', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data berhasil ditambahkan !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data '.strtoupper($category_desc).' sudah ada !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		}
		redirect('category');
	}
	
	public function update()
	{
		$category_id	= $this->input->post('category_id');
		$category_desc	= $this->input->post('category_desc');
		
		$data = array(
			'category_desc' => $category_desc
		);
		$where = array('category_id' => $category_id);
	 
		$exist = $this->MasterModel->getBy('category', array('category_desc'=>$category_desc));
		
		if($exist->num_rows() == 0){
			$this->MasterModel->edit('category', $where, $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data berhasil diperbarui !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data '.strtoupper($category_desc).' sudah ada !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		}
		redirect('category');
	}

    public function delete()
    {
        $where = ['category_id' => $this->uri->segment(3)];
		$query = $this->MasterModel->getBy('category', $where);
		$row = $query->row();
		
        $this->MasterModel->delete('category', $where);
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data '.strtoupper($row->category_desc).' berhasil dihapus !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('category');
    }
}