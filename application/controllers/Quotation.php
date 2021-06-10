<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Quotation extends CI_Controller
{	
    public function __construct()
    {
        parent::__construct();
		authentication();
		
		$this->load->library('PDF');
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
    
    public function invoice()
	{
		$quotation_id = $this->uri->segment(3);
		$this->session->set_userdata("quotation_id", $quotation_id);
		redirect('quotation/formInvoice');
	}
	
	public function formInvoice()
    {
		$quotation = $this->MasterModel->getBy('quotation', array('quotation_id'=>$_SESSION['quotation_id']))->row();
		$quotation_detail = $this->MasterModel->getBy('quotation_detail', array('quotation_id'=>$_SESSION['quotation_id']))->result();
		
		$data['quotation'] = $quotation;
		$data['quotation_detail'] = $quotation_detail;
		$data['customer'] = $this->MasterModel->getBy('customer', array('customer_id'=>$quotation->customer_id))->row();
		
        $data['title'] = 'Data Penjualan ('.$quotation->quotation_number.')';
        
        /* invoice Number */
        $current = '/'.date("m").'-'.date("y").'/';
		$query = $this->db->select_max("invoice_number", "last")->like("invoice_number", $current, "both")->get("invoice")->row();
		
		$lastNo = substr($query->last, 10);
		$invoice_no = 'INV'.$current.sprintf('%05s', $lastNo + 1);
		
		$data['number'] = $invoice_no;
		/* invoice Number */

        $this->load->view('templates/header', $data);
        $this->load->view('invoice/form-quotation', $data);
        $this->load->view('templates/footer');
		$this->load->view('templates/js/invoice');
    }
	
    public function delete()
    {
        $where	= ['quotation_id' => $this->uri->segment(3)];
		$query	= $this->MasterModel->getBy('quotation', $where);
		$row	= $query->row();
		
        $this->MasterModel->edit('quotation', $where, array('quotation_status' => 2));
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Penawaran '.strtoupper($row->quotation_number).' berhasil dihapus !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('quotation');
    }
	
	public function prints($id)
    {
		$where	= ['quotation_id' => $this->uri->segment(3)];
        $query	= $this->MasterModel->getBy('quotation', $where);
		$row	= $query->row();
		
		$detail	= $this->MasterModel->getBy('quotation_detail', $where)->result_array();
		
        // Generate PDF
        $pdf = new PDF();
        $pdf->AddPage('L', array(140, 216));
        // $pdf->AddPage('L', 'A5');
        $pdf->setMargins(5,0,0);
        $pdf->SetFont('Arial', '',10);

		$pdf->SetXY(5,10);
		$pdf->SetFont('Arial','BU',15);
		$pdf->Cell(205, 6, 'PENAWARAN', 0, 1, 'R');
		
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(150, 5, '', 0, 0, 'R');
		$pdf->Cell(25, 5, 'Nomor ', 0, 0, 'R');
		$pdf->Cell(30, 5, ': '.$row->quotation_number, 0, 1, 'L');
		
		$pdf->Cell(150, 5, '', 0, 0, 'R');
		$pdf->Cell(25, 5, 'Tanggal ', 0, 0, 'R');
		$pdf->Cell(30, 5, ': '.date('d M Y', strtotime($row->quotation_date)), 0, 1, 'L');
		
		$pdf->Cell(150, 5, '', 0, 0, 'R');
		$pdf->Cell(25, 5, 'Customer ', 0, 0, 'R');
		$pdf->Cell(30, 5, ': '.$row->customer_desc, 0, 1, 'L');
		$pdf->Ln(6);
		
		
		//~ $pdf->SetFont('Arial','BU',12);
        //~ $pdf->Cell(205, 6, "DETAIL PENAWARAN", 0, 0, 'C');
		//~ $pdf->Ln(8);
		
		$pdf->SetFont('Arial','B',10);
		$pdf->SetFillColor(140);
		$pdf->SetTextColor(255);
		
		$header	= array('No.', 'Deskripsi', 'Qty', 'Unit', 'Harga Satuan', 'Total');
		$width	= array(10, 95, 15, 15, 35, 35);
		
		for($i = 0; $i < count($header); $i++)
			$pdf->Cell($width[$i], 7, $header[$i], 1, 0, 'C', true);
		$pdf->Ln();
		
		$pdf->SetFont('Arial','',10);
		$pdf->SetTextColor(0);
		
		foreach($detail as $key => $value)
		{
			$pdf->Cell($width[0], 5, $key + 1, 'LR', 0, 'C');
			$pdf->Cell($width[1], 5, ucfirst($value['detail_item_desc']), 'LR', 0);
			$pdf->Cell($width[2], 5, $value['detail_item_qty'], 'LR', 0, 'C');
			$pdf->Cell($width[3], 5, $value['detail_item_unit'], 'LR', 0, 'C');
			$pdf->Cell(5, 5, '', 'L', 0);
			$pdf->Cell(30, 5, number_format($value['detail_item_price']), 'R', 0, 'R');
			$pdf->Cell(5, 5, '', 'L', 0);
			$pdf->Cell(30, 5, number_format($value['detail_item_price'] * $value['detail_item_qty']), 'R', 0, 'R');
			$pdf->Ln();
		}
		
		if(count($detail) < 10)
		{
			$a = 10 - count($detail);
			for($i = 1; $i < $a; $i++)
			{
				$pdf->Cell($width[0], 5, '', 'LR', 0);
				$pdf->Cell($width[1], 5, '', 'LR', 0);
				$pdf->Cell($width[2], 5, '', 'LR', 0);
				$pdf->Cell($width[3], 5, '', 'LR', 0);
				$pdf->Cell($width[4], 5, '', 'LR', 0);
				$pdf->Cell($width[5], 5, '', 'LR', 0);
				$pdf->Ln();
			}
		}
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(170, 7, '', 'T', 0, 'R');
		$pdf->Cell(5, 7, 'Rp', 'LTB', 0);
		$pdf->Cell(30, 7, number_format($row->quotation_total), 'RTB', 1, 'R');

        $pdf->Output('1.pdf', 'I');
		exit();
    }
}
