<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{	
    public function __construct()
    {
        parent::__construct();
		// authentication();
    }

    public function index()
    {
        $data['title'] = 'Data Pelanggan';

        $this->load->view('templates/header', $data);
        $this->load->view('customer/index', $data);
        $this->load->view('templates/footer');
		$this->load->view('templates/js/customer');
    }
	
	public function getData()
	{
		$this->load->library("datatables_ssp");
		$_table = "customer";
		$_conn 	= [
			"user" 	=> $this->db->username,
			"pass" 	=> $this->db->password,
			"db" 	=> $this->db->database,
			"host" 	=> $this->db->hostname,
			"port" 	=> $this->db->port
		];
		$_key	= "customer_id";
		$_coll	= [
			["db" => "customer_code",	"dt" => "customer_code"],
			["db" => "customer_name",	"dt" => "customer_name"],
			["db" => "customer_address","dt" => "customer_address"],
			["db" => "customer_phone",	"dt" => "customer_phone"],
			["db" => "customer_id",		"dt" => "customer_id"]
		];
		
		$_where	= NULL;
		$_join	= NULL;
		
		// if (!isset($_GET["order"][0]["column"]) || $_GET["order"][0]["column"] == "") {
			// $_GET["order"][0]["column"]	= 1;
			// $_GET["order"][0]["dir"]	= "asc";
		// }

		echo json_encode(
			Datatables_ssp::complex($_GET, $_conn, $_table, $_key, $_coll, $_where, NULL, $_join)
		);
	}
	
	public function create()
	{
		$customer_code		= $this->input->post('customer_code');
		$customer_name		= $this->input->post('customer_name');
		$customer_address	= $this->input->post('customer_address');
		$customer_phone		= $this->input->post('customer_phone');
		
		$data = array(
			'customer_code'		=> $customer_code,
			'customer_name'		=> $customer_name,
			'customer_address'	=> $customer_address,
			'customer_phone'	=> $customer_phone
		);
	 
		$exist = $this->MasterModel->getBy('customer', array('customer_code'=>$customer_code));
		
		if($exist->num_rows() == 0){
			$this->MasterModel->add('customer', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data berhasil ditambahkan !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Kode '.strtoupper($customer_code).' sudah digunakan !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		}
		redirect('customer');
	}
	
	public function update()
	{
		$customer_id		= $this->input->post('customer_id');
		$customer_code		= $this->input->post('customer_code');
		$customer_name		= $this->input->post('customer_name');
		$customer_address	= $this->input->post('customer_address');
		$customer_phone		= $this->input->post('customer_phone');
		
		$data = array(
			'customer_code'		=> $customer_code,
			'customer_name'		=> $customer_name,
			'customer_address'	=> $customer_address,
			'customer_phone'	=> $customer_phone
		);
		$where = array('customer_id' => $customer_id);
	 
		$exist = $this->MasterModel->getBy('customer', array('customer_code'=>$customer_code));
		
		if($exist->num_rows() <= 1){
			$this->MasterModel->edit('customer', $where, $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data '.strtoupper($customer_code).' berhasil diperbarui !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Kode '.strtoupper($customer_code).' sudah digunakan !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		}
		redirect('customer');
	}

    public function delete()
    {
        $where = ['customer_id' => $this->uri->segment(3)];
		$query = $this->MasterModel->getBy('customer', $where);
		$row = $query->row();
		
        $this->MasterModel->delete('customer', $where);
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data '.strtoupper($row->customer_code).' berhasil dihapus !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('customer');
    }
}