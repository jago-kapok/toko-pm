<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Purchase extends CI_Controller
{	
    public function __construct()
    {
        parent::__construct();
		authentication();
		
		$this->load->library('PDFPurchase');
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
			["db" => "purchase_date",	"dt" => "purchase_date",
				"formatter" => function($d, $row){
					return date("d-m-Y", strtotime($d));
				}
			],
			["db" => "purchase_number",	"dt" => "purchase_number"],
			["db" => "supplier_name",	"dt" => "supplier_name"],
			["db" => "purchase_total",	"dt" => "purchase_total",
				"formatter" =>  function($d, $row){
					return number_format($d);
				}
			],
			["db" => "purchase_id",		"dt" => "purchase_id"]
		];
		
		$_where	= "purchase_status = 0";
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
	
	public function create()
	{
		$purchase_number	= $this->input->post('purchase_number');
		$purchase_date		= $this->input->post('purchase_date');
		$supplier_id		= $this->input->post('supplier_id');
		$purchase_total		= $this->input->post('purchase_total');
		
		$data = array(
			'purchase_number'			=> $purchase_number,
			'purchase_date'				=> $purchase_date,
			'supplier_id'				=> $supplier_id,
			'purchase_total'			=> $purchase_total,
			'purchase_status'			=> 0,
			'purchase_modified_date'	=> date('Y-m-d H:i:s')
		);
	 
		if($this->input->post('purchase_id') == ''){
			$this->MasterModel->add('purchase', $data);
			$purchase_id = $this->db->insert_id();
		} else {
			$purchase_id = $this->input->post('purchase_id');
			
			$where = array('purchase_id' => $purchase_id);
			$this->MasterModel->edit('purchase', $where, $data);
			$this->MasterModel->delete('purchase_detail', $where);
			$this->updateStock($purchase_number, 1);
			$this->MasterModel->delete('stock_history', array('stock_history_number'=>$purchase_number));
		}
		
		$result = array();
		foreach($_POST['detail_item_price'] as $key => $value){
			$item_id	= $_POST['detail_item_id'][$key];
			$item_qty	= $_POST['detail_item_qty'][$key];

			$result[] = array(
				"purchase_id"		=> $purchase_id,
				"detail_item_id"	=> $item_id,
				"detail_item_code"	=> $_POST['detail_item_code'][$key],
				"detail_item_desc"	=> $_POST['detail_item_desc'][$key],
				"detail_item_qty"	=> $item_qty,
				"detail_item_unit"	=> $_POST['detail_item_unit'][$key],
				"detail_item_price"	=> $_POST['detail_item_price'][$key]
			);
			
			$this->createStockHistory($item_id, $item_qty, $purchase_number);
		}
		
		$this->updateStock($purchase_number, 0);
		$this->db->insert_batch('purchase_detail', $result);
		
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Transaksi berhasil disimpan !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		
		redirect('purchase');
	}
	
	public function update()
	{
		$purchase_id = $this->uri->segment(3);
		$this->session->set_userdata("purchase_id", $purchase_id);
		redirect('purchase/formUpdate');
	}

	public function formUpdate()
    {
        $data['title'] = 'Edit Data Pembelian';
		
		$purchase = $this->MasterModel->getBy('purchase', array('purchase_id'=>$_SESSION['purchase_id']))->row();
		$purchase_detail = $this->MasterModel->getBy('purchase_detail', array('purchase_id'=>$_SESSION['purchase_id']))->result();
		
		$data['purchase'] = $purchase;
		$data['purchase_detail'] = $purchase_detail;
		$data['supplier'] = $this->MasterModel->getBy('supplier', array('supplier_id'=>$purchase->supplier_id))->row();

        $this->load->view('templates/header', $data);
        $this->load->view('purchase/form-update', $data);
        $this->load->view('templates/footer');
		$this->load->view('templates/js/purchase');
    }

    public function delete()
    {
        $where = ['purchase_id' => $this->uri->segment(3)];
		$query = $this->MasterModel->getBy('purchase', $where);
		$row = $query->row();
		
        $this->MasterModel->edit('purchase', $where, array("purchase_status"=>1));
		$this->updateStock($row->purchase_number, 1);
        $this->MasterModel->delete('stock_history', array('stock_history_number'=>$row->purchase_number));
		
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Transaksi '.strtoupper($row->purchase_number).' berhasil dihapus !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('purchase');
    }
	
	public function updateStock($purchase_number, $status)
	{
		$query = $this->MasterModel->getBy('stock_history', array('stock_history_number'=>$purchase_number))->result_array();
		
		foreach($query as $row){
			$stock = $this->MasterModel->getBy('stock', array('item_id'=>$row['item_id']))->row();
			
			if($status == 0){
				$stock_exist = $stock->stock_exist + $row['stock_history_item_qty'];
			} else {
				$stock_exist = $stock->stock_exist - $row['stock_history_item_qty'];
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
			'stock_history_type'	=> 1
		);
		
		$this->MasterModel->add('stock_history', $data);
	}
	
	public function prints()
    {
		$where	= ['purchase_id' => $this->uri->segment(3)];
        $query	= $this->MasterModel->getBy('purchase', $where);
		$row	= $query->row();
		
		$supplier = $this->MasterModel->getBy('supplier', ['supplier_id'=>$row->supplier_id])->row();
		
		$detail	= $this->MasterModel->getBy('purchase_detail', $where)->result_array();
		
        // Generate PDF
        $pdf = new PDFPurchase();
        $pdf->AddPage('P', array(280, 216));
        $pdf->setMargins(5,0,0);

		$pdf->SetX(5);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(15, 5, 'Nomor ', 0, 0, 'L');
		$pdf->Cell(30, 5, ': '.$row->purchase_number, 0, 1, 'L');
		
		$pdf->Cell(15, 5, 'Tanggal ', 0, 0, 'L');
		$pdf->Cell(30, 5, ': '.date('d M Y', strtotime($row->purchase_date)), 0, 1, 'L');
		
		$pdf->Cell(15, 5, 'Supplier ', 0, 0, 'L');
		$pdf->Cell(30, 5, ': '.$supplier->supplier_name, 0, 1, 'L');
		$pdf->Ln();
		
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
		
		if(count($detail) <= 15)
		{
			$a = 17 - count($detail);
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
		
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(175, 5, 'Total Pembelian ', 'T', 0, 'R');
		$pdf->Cell(5, 5, 'Rp', 'LTB', 0);
		$pdf->Cell(25, 5, number_format($row->purchase_total), 'RTB', 1, 'R');	

        $pdf->Output('1.pdf', 'I');
		exit();
    }
}
