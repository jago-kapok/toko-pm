<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends CI_Controller
{	
    public function __construct()
    {
        parent::__construct();
		authentication();
		
		$this->load->library('PDF');
    }

    public function index()
    {
        $data['title'] = 'Data Penjualan';
        
        $this->load->view('templates/header', $data);
        $this->load->view('invoice/index', $data);
        $this->load->view('templates/footer');
		$this->load->view('templates/js/invoice');
    }
	
	public function getData()
	{
		$this->load->library("datatables_ssp");
		$_table = "invoice";
		$_conn 	= [
			"user" 	=> $this->db->username,
			"pass" 	=> $this->db->password,
			"db" 	=> $this->db->database,
			"host" 	=> $this->db->hostname,
			"port" 	=> $this->db->port
		];
		$_key	= "invoice_id";
		$_coll	= [
			["db" => "invoice_date",	"dt" => "invoice_date",
				"formatter" => function($d, $row){
					return date("d-m-Y", strtotime($d));
				}
			],
			["db" => "invoice_number",	"dt" => "invoice_number"],
			["db" => "customer_desc",	"dt" => "customer_desc"],
			["db" => "invoice_total",	"dt" => "invoice_total",
				"formatter" => function($d, $row){
					return number_format($d);
				}
			],
			["db" => "invoice_discount","dt" => "invoice_discount",
				"formatter" => function($d, $row){
					return number_format($d);
				}
			],
			["db" => "invoice_notes",	"dt" => "invoice_notes"],
			["db" => "invoice_id",		"dt" => "invoice_id"]
		];
		
		$_where	= "invoice_status != 2";
		$_join	= "LEFT JOIN customer ON invoice.customer_id = customer.customer_id
				  JOIN status ON invoice.invoice_status = status.status_id";

		echo json_encode(
			Datatables_ssp::complex($_GET, $_conn, $_table, $_key, $_coll, $_where, NULL, $_join)
		);
	}
	
	public function formCreate()
    {
        $data['title'] = 'Data Penjualan';
        
        /* invoice Number */
        $current = date("y").'/';
		$query = $this->db->select_max("invoice_number", "last")->like("invoice_number", $current, "both")->get("invoice")->row();
		
		$lastNo = substr($query->last, 10);
		$invoice_no = 'INV'.'/'.date("m").'-'.$current.sprintf('%05s', $lastNo + 1);
		
		$data['number'] = $invoice_no;
		/* invoice Number */

        $this->load->view('templates/header', $data);
        $this->load->view('invoice/form-create', $data);
        $this->load->view('templates/footer');
		$this->load->view('templates/js/invoice');
    }
	
	public function create()
	{
		$quotation_id		= $this->input->post('quotation_id');
		$invoice_number		= $this->input->post('invoice_number');
		$invoice_date		= $this->input->post('invoice_date');
		$customer_id		= $this->input->post('customer_id');
		$customer_desc		= $this->input->post('customer_desc') != '' ? $this->input->post('customer_desc') : $this->input->post('customer_code');
		$invoice_total		= $this->input->post('invoice_total');
		$invoice_discount	= $this->input->post('invoice_discount');
		$invoice_notes		= $this->input->post('invoice_notes');
		
		$data = array(
			'quotation_id'			=> $quotation_id,
			'invoice_number'		=> $invoice_number,
			'invoice_date'			=> $invoice_date,
			'customer_id'			=> $customer_id,
			'customer_desc'			=> $customer_desc,
			'invoice_total'			=> $invoice_total,
			'invoice_discount'		=> $invoice_discount,
			'invoice_notes'			=> $invoice_notes,
			'invoice_status'		=> 1,
			'invoice_created_by'	=> $this->session->userdata('user_id'),
			'invoice_modified_date'	=> date('Y-m-d H:i:s')
		);
	 
		if($this->input->post('invoice_id') == ''){
			$this->MasterModel->add('invoice', $data);
			$invoice_id = $this->db->insert_id();
		} else {
			$invoice_id = $this->input->post('invoice_id');
			
			$where = array('invoice_id' => $invoice_id);
			$this->MasterModel->edit('invoice', $where, $data);
			$this->MasterModel->delete('invoice_detail', $where);
			$this->updateStock($invoice_number, 1);
			$this->MasterModel->delete('stock_history', array('stock_history_number'=>$invoice_number));
		}
		
		$result = array();
		foreach($_POST['detail_item_price'] as $key => $value){
			$item_id	= $_POST['detail_item_id'][$key];
			$item_qty	= $_POST['detail_item_qty'][$key];
			
			$result[] = array(
				"invoice_id"		=> $invoice_id,
				"detail_item_id"	=> $item_id,
				"detail_item_code"	=> $_POST['detail_item_code'][$key],
				"detail_item_desc"	=> $_POST['detail_item_desc'][$key],
				"detail_item_qty"	=> $item_qty,
				"detail_item_unit"	=> $_POST['detail_item_unit'][$key],
				"detail_item_price"	=> $_POST['detail_item_price'][$key],
				"detail_item_buy"	=> $_POST['detail_item_buy'][$key]
			);
			
			$this->createStockHistory($item_id, $item_qty, $invoice_number);
		}
		
		$this->updateStock($invoice_number, 0);
		$this->db->insert_batch('invoice_detail', $result);
		
		if($quotation_id != "" || $quotation_id > 0){
			$this->MasterModel->edit('quotation', ['quotation_id'=>$quotation_id], ['quotation_status'=>4]);
		}
		
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data Penjualan berhasil disimpan !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		
		$this->session->set_userdata('message_invoice', 1);
		$this->session->set_userdata('invoice_id', $invoice_id);
		redirect('invoice');
	}

	public function update()
	{
		$invoice_id = $this->uri->segment(3);
		$this->session->set_userdata("invoice_id", $invoice_id);
		redirect('invoice/formUpdate');
	}

	public function formUpdate()
    {
        $data['title'] = 'Edit Data Penjualan';
		
		$invoice = $this->MasterModel->getBy('invoice', array('invoice_id'=>$_SESSION['invoice_id']))->row();
		$invoice_detail = $this->MasterModel->getBy('invoice_detail', array('invoice_id'=>$_SESSION['invoice_id']))->result();
		
		$data['invoice'] = $invoice;
		$data['invoice_detail'] = $invoice_detail;
		$data['customer'] = $this->MasterModel->getBy('customer', array('customer_id'=>$invoice->customer_id))->row();

        $this->load->view('templates/header', $data);
        $this->load->view('invoice/form-update', $data);
        $this->load->view('templates/footer');
		$this->load->view('templates/js/invoice');
    }
	
    public function delete()
    {
        $where = ['invoice_id' => $this->uri->segment(3)];
		$query = $this->MasterModel->getBy('invoice', $where);
		$row = $query->row();
		
        $this->MasterModel->edit('invoice', $where, array('invoice_status' => 2));
		$this->updateStock($row->invoice_number, 1);
        $this->MasterModel->delete('stock_history', array('stock_history_number'=>$row->invoice_number));
		
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Penawaran '.strtoupper($row->invoice_number).' berhasil dihapus !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('invoice');
    }
	
	public function updateStock($invoice_number, $status)
	{
		$query = $this->MasterModel->getBy('stock_history', array('stock_history_number'=>$invoice_number))->result_array();
		
		foreach($query as $row){
			$stock = $this->MasterModel->getBy('stock', array('item_id'=>$row['item_id']))->row();
			
			if($status == 0){
				$stock_exist = $stock->stock_exist - $row['stock_history_item_qty'];
			} else {
				$stock_exist = $stock->stock_exist + $row['stock_history_item_qty'];
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
			'stock_history_type'	=> 2
		);
		
		$this->MasterModel->add('stock_history', $data);
	}
	
	public function prints()
    {
		$where	= ['invoice_id' => $this->uri->segment(3)];
        $query	= $this->MasterModel->getBy('invoice', $where);
		$row	= $query->row();
		
		$detail	= $this->MasterModel->getBy('invoice_detail', $where)->result_array();
		
        // Generate PDF
        $pdf = new PDF();
        $pdf->AddPage('L', array(140, 216));
        // $pdf->AddPage('L', 'A5');
        $pdf->setMargins(5,0,0);

		$pdf->SetXY(5,10);
		$pdf->SetFont('Arial','BU',12);
		$pdf->Cell(205, 6, 'INVOICE', 0, 1, 'R');
		
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(160, 5, '', 0, 0, 'R');
		$pdf->Cell(15, 5, 'Nomor ', 0, 0, 'L');
		$pdf->Cell(30, 5, ': '.$row->invoice_number, 0, 1, 'L');
		
		$pdf->Cell(160, 5, '', 0, 0, 'R');
		$pdf->Cell(15, 5, 'Tanggal ', 0, 0, 'L');
		$pdf->Cell(30, 5, ': '.date('d M Y', strtotime($row->invoice_date)), 0, 1, 'L');
		
		$pdf->Cell(160, 5, '', 0, 0, 'R');
		$pdf->Cell(15, 5, 'Customer ', 0, 0, 'L');
		$pdf->Cell(30, 5, ': '.$row->customer_desc, 0, 1, 'L');
		$pdf->Ln(6);
		
		$pdf->SetFont('Arial','B',9);
		$pdf->SetFillColor(140);
		$pdf->SetTextColor(255);
		
		$header	= array('No.', 'Deskripsi', 'Qty', 'Unit', 'Harga Satuan', 'Total');
		$width	= array(10, 110, 12.5, 12.5, 30, 30);
		
		for($i = 0; $i < count($header); $i++)
			$pdf->Cell($width[$i], 6, $header[$i], 1, 0, 'C', true);
		$pdf->Ln();
		
		$pdf->SetFont('Arial','',9);
		$pdf->SetTextColor(0);
		
		$pdf->Cell(10, 0.25, '', 'LR', 0);
		$pdf->Cell(110, 0.25, '', 'LR', 0);
		$pdf->Cell(12.5, 0.25, '', 'LR', 0);
		$pdf->Cell(12.5, 0.25, '', 'LR', 0);
		$pdf->Cell(30, 0.25, '', 'LR', 0);
		$pdf->Cell(30, 0.25, '', 'LR', 1);
		
		foreach($detail as $key => $value)
		{
			$pdf->Cell($width[0], 4, $key + 1, 'LR', 0, 'C');
			$pdf->Cell($width[1], 4, ucfirst($value['detail_item_desc']), 'LR', 0);
			$pdf->Cell($width[2], 4, $value['detail_item_qty'], 'LR', 0, 'C');
			$pdf->Cell($width[3], 4, $value['detail_item_unit'], 'LR', 0, 'C');
			$pdf->Cell(5, 4, '', 'L', 0);
			$pdf->Cell(25, 4, number_format($value['detail_item_price']), 'R', 0, 'R');
			$pdf->Cell(5, 4, '', 'L', 0);
			$pdf->Cell(25, 4, number_format($value['detail_item_price'] * $value['detail_item_qty']), 'R', 0, 'R');
			$pdf->Ln();
		}
		
		if(count($detail) <= 12)
		{
			$a = 14 - count($detail);
			for($i = 1; $i < $a; $i++)
			{
				$pdf->Cell($width[0], 4, '', 'LR', 0);
				$pdf->Cell($width[1], 4, '', 'LR', 0);
				$pdf->Cell($width[2], 4, '', 'LR', 0);
				$pdf->Cell($width[3], 4, '', 'LR', 0);
				$pdf->Cell($width[4], 4, '', 'LR', 0);
				$pdf->Cell($width[5], 4, '', 'LR', 0);
				$pdf->Ln();
			}
		}
		
		$discount = round(($row->invoice_discount / ($row->invoice_total + $row->invoice_discount)) * 100, 2);
		
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(175, 5, 'Sub Total ', 'T', 0, 'R');
		$pdf->Cell(5, 5, 'Rp', 'LTB', 0);
		$pdf->Cell(25, 5, number_format($row->invoice_total + $row->invoice_discount), 'RTB', 1, 'R');
		$pdf->Cell(175, 5, 'Diskon ('.$discount.'%)', '', 0, 'R');
		$pdf->Cell(5, 5, 'Rp', 'LB', 0);
		$pdf->Cell(25, 5, number_format($row->invoice_discount), 'RB', 1, 'R');
		
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(175, 5, 'Total Invoice ', '', 0, 'R');
		$pdf->Cell(5, 5, 'Rp', 'LB', 0);
		$pdf->Cell(25, 5, number_format($row->invoice_total), 'RB', 1, 'R');	

        $pdf->Output('1.pdf', 'I');
		exit();
    }
}
