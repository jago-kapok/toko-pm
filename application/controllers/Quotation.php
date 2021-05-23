<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Quotation extends CI_Controller
{	
    public function __construct()
    {
        parent::__construct();
		// authentication();
    }

    public function index()
    {
        $data['title'] = 'Data Penawaran';

        $this->load->view('templates/header', $data);
        $this->load->view('quotation/index', $data);
        $this->load->view('templates/footer');
		$this->load->view('templates/js/quotation');
    }
	
	public function getData()
	{
		$this->load->library("datatables_ssp");
		$_table = "quotation";
		$_conn 	= [
			"user" 	=> $this->db->username,
			"pass" 	=> $this->db->password,
			"db" 	=> $this->db->database,
			"host" 	=> $this->db->hostname,
			"port" 	=> $this->db->port
		];
		$_key	= "quotation_id";
		$_coll	= [
			["db" => "quotation_date",	"dt" => "quotation_date",
				"formatter" => function($d, $row){
					return date("d-m-Y", strtotime($d));
				}
			],
			["db" => "quotation_number","dt" => "quotation_number"],
			["db" => "customer_desc",	"dt" => "customer_desc"],
			["db" => "quotation_total",	"dt" => "quotation_total",
				"formatter" => function($d, $row){
					return number_format($d);
				}
			],
			["db" => "status_desc",		"dt" => "status_desc"],
			["db" => "quotation_id",	"dt" => "quotation_id"]
		];
		
		$_where	= "quotation_status != 2";
		$_join	= "LEFT JOIN customer ON quotation.customer_id = customer.customer_id
				  JOIN status ON quotation.quotation_status = status.status_id";

		echo json_encode(
			Datatables_ssp::complex($_GET, $_conn, $_table, $_key, $_coll, $_where, NULL, $_join)
		);
	}
	
	public function formCreate()
    {
        $data['title'] = 'Data Penawaran';
        
        /* Quotation Number */
        $current = '/'.date("m").'-'.date("y").'/';
		$query = $this->db->select_max("quotation_number", "last")->like("quotation_number", $current, "both")->get("quotation")->row();
		
		$lastNo = substr($query->last, 9);
		$quotation_no = 'SQ'.$current.sprintf('%05s', $lastNo + 1);
		
		$data['number'] = $quotation_no;
		/* Quotation Number */

        $this->load->view('templates/header', $data);
        $this->load->view('quotation/form-create', $data);
        $this->load->view('templates/footer');
		$this->load->view('templates/js/quotation');
    }
	
	public function create()
	{
		$quotation_number	= $this->input->post('quotation_number');
		$quotation_date		= $this->input->post('quotation_date');
		$customer_id		= $this->input->post('customer_id');
		$customer_desc		= $this->input->post('customer_desc') != '' ? $this->input->post('customer_desc') : $this->input->post('customer_code');
		$quotation_total	= $this->input->post('quotation_total');
		$quotation_notes	= $this->input->post('quotation_notes');
		
		$data = array(
			'quotation_number'			=> $quotation_number,
			'quotation_date'			=> $quotation_date,
			'customer_id'				=> $customer_id,
			'customer_desc'				=> $customer_desc,
			'quotation_total'			=> $quotation_total,
			'quotation_notes'			=> $quotation_notes,
			'quotation_status'			=> 1,
			'quotation_modified_date'	=> date('Y-m-d H:i:s')
		);
	 
		if($this->input->post('quotation_id') == ''){
			$this->MasterModel->add('quotation', $data);
			$quotation_id = $this->db->insert_id();
		} else {
			$quotation_id = $this->input->post('quotation_id');
			
			$where = array('quotation_id' => $quotation_id);
			$this->MasterModel->edit('quotation', $where, $data);
			$this->MasterModel->delete('quotation_detail', $where);
		}
		
		$result = array();
		foreach($_POST['detail_item_price'] AS $key => $value){
			$result[] = array(
				"quotation_id"		=> $quotation_id,
				"detail_item_id"	=> $_POST['detail_item_id'][$key],
				"detail_item_code"	=> $_POST['detail_item_code'][$key],
				"detail_item_desc"	=> $_POST['detail_item_desc'][$key],
				"detail_item_qty"	=> $_POST['detail_item_qty'][$key],
				"detail_item_unit"	=> $_POST['detail_item_unit'][$key],
				"detail_item_price"	=> $_POST['detail_item_price'][$key],
				"detail_item_buy"	=> $_POST['detail_item_buy'][$key]
			);
		}
		
		$this->db->insert_batch('quotation_detail', $result);
		
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Penawaran berhasil disimpan !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		
		redirect('quotation');
	}

	public function update()
	{
		$quotation_id = $this->uri->segment(3);
		$this->session->set_userdata("quotation_id", $quotation_id);
		redirect('quotation/formUpdate');
	}

	public function formUpdate()
    {
        $data['title'] = 'Edit Data Penawaran';
		
		$quotation = $this->MasterModel->getBy('quotation', array('quotation_id'=>$_SESSION['quotation_id']))->row();
		$quotation_detail = $this->MasterModel->getBy('quotation_detail', array('quotation_id'=>$_SESSION['quotation_id']))->result();
		
		$data['quotation'] = $quotation;
		$data['quotation_detail'] = $quotation_detail;
		$data['customer'] = $this->MasterModel->getBy('customer', array('customer_id'=>$quotation->customer_id))->row();

        $this->load->view('templates/header', $data);
        $this->load->view('quotation/form-update', $data);
        $this->load->view('templates/footer');
		$this->load->view('templates/js/quotation');
    }
	
    public function delete()
    {
        $where = ['quotation_id' => $this->uri->segment(3)];
		$query = $this->MasterModel->getBy('quotation', $where);
		$row = $query->row();
		
        $this->MasterModel->edit('quotation', $where, array('quotation_status' => 2));
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Penawaran '.strtoupper($row->quotation_number).' berhasil dihapus !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('quotation');
    }
}
