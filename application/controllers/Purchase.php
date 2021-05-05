<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Purchase extends CI_Controller
{	
    public function __construct()
    {
        parent::__construct();
		// authentication();
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
			["db" => "purchase_date",	"dt" => "purchase_date"],
			["db" => "purchase_number",	"dt" => "purchase_number"],
			["db" => "supplier_name",	"dt" => "supplier_name"],
			["db" => "purchase_total",	"dt" => "purchase_total"],
			["db" => "purchase_id",		"dt" => "purchase_id"]
		];
		
		$_where	= NULL;
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
	
	public function create1()
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
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data '.strtoupper($customer_code).' sudah ada !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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
