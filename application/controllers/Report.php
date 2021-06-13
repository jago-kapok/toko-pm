<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{	
    public function __construct()
    {
        parent::__construct();
		authentication();
		
		$this->load->library('PDFReport');
    }
	
	public function printPurchase()
    {
		$start_date		= $this->uri->segment(3);
		$to_date		= $this->uri->segment(4);
		$supplier_id	= $this->uri->segment(5);
		
		$this->session->set_userdata('start_date', $start_date);
		$this->session->set_userdata('to_date', $to_date);
		$this->session->set_userdata('report_title', 'PEMBELIAN');
		
        $query	= $this->db->where('purchase_date >= ', date('Y-m-d', strtotime($start_date)))
						   ->where('purchase_date <= ', date('Y-m-d', strtotime($to_date)))
						   ->like('supplier.supplier_id', $supplier_id)->join('supplier', 'purchase.supplier_id = supplier.supplier_id')
						   ->order_by('purchase_date', 'ASC')->get('purchase');
		$row	= $query->result_array();
		
		$total	= $this->db->select('SUM(purchase_total) AS total')
						   ->where('purchase_date >= ', date('Y-m-d', strtotime($start_date)))
						   ->where('purchase_date <= ', date('Y-m-d', strtotime($to_date)))
						   ->like('supplier_id', $supplier_id)->get('purchase')->row();
		
        // Generate PDF
        $pdf = new PDFReport();
        $pdf->AddPage('P', 'A4');
        $pdf->setMargins(5,0,0);

		$pdf->setX(5);
		
		$pdf->Ln();
		
		$pdf->SetFont('Arial','B',9);
		$pdf->SetFillColor(140);
		$pdf->SetTextColor(255);
		
		$header	= array('No.', 'Tanggal', 'Penawaran', 'Supplier', 'Total');
		$width	= array(10, 25, 30, 105, 30);
		
		for($i = 0; $i < count($header); $i++)
			$pdf->Cell($width[$i], 6, $header[$i], 1, 0, 'C', true);
		$pdf->Ln();
		
		$pdf->SetFont('Arial','',9);
		$pdf->SetTextColor(0);
		
		foreach($row as $key => $value)
		{
			$pdf->Cell($width[0], 4, $key + 1, 'LR', 0, 'C');
			$pdf->Cell($width[1], 4, date('d-m-Y', strtotime($value['purchase_date'])), 'LR', 0, 'C');
			$pdf->Cell($width[2], 4, $value['purchase_number'], 'LR', 0, 'C');
			$pdf->Cell($width[3], 4, ucfirst($value['supplier_name']), 'LR', 0, 'L');
			$pdf->Cell(5, 4, '', 'L', 0);
			$pdf->Cell(25, 4, number_format($value['purchase_total']), 'R', 0, 'R');
			$pdf->Ln();
		}
		
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(170, 5, 'Total Pembelian ', 1, 0, 'C');
		$pdf->Cell(5, 5, 'Rp', 'LTB', 0);
		$pdf->Cell(25, 5, number_format($total->total), 'RTB', 1, 'R');	

        $pdf->Output('1.pdf', 'I');
		exit();
    }
    
    public function printInvoice()
    {
		$start_date		= $this->uri->segment(3);
		$to_date		= $this->uri->segment(4);
		$customer_id	= $this->uri->segment(5);
		
		$this->session->set_userdata('start_date', $start_date);
		$this->session->set_userdata('to_date', $to_date);
		$this->session->set_userdata('report_title', 'PENJUALAN');
		
        $query	= $this->db->where('invoice_date >= ', date('Y-m-d', strtotime($start_date)))
						   ->where('invoice_date <= ', date('Y-m-d', strtotime($to_date)))
						   ->where('invoice_status', 1)
						   ->like('customer_id', $customer_id)->order_by('invoice_date', 'ASC')->get('invoice');
		$row	= $query->result_array();
		
		$total	= $this->db->select('SUM(invoice_total) AS total, SUM(invoice_discount) AS discount')
						   ->where('invoice_date >= ', date('Y-m-d', strtotime($start_date)))
						   ->where('invoice_date <= ', date('Y-m-d', strtotime($to_date)))
						   ->like('customer_id', $customer_id)->get('invoice')->row();
		
        // Generate PDF
        $pdf = new PDFReport();
        $pdf->AddPage('P', 'A4');
        $pdf->setMargins(5,0,0);

		$pdf->setX(5);
		
		$pdf->Ln();
		
		$pdf->SetFont('Arial','B',9);
		$pdf->SetFillColor(140);
		$pdf->SetTextColor(255);
		
		$header	= array('No.', 'Tanggal', 'Invoice', 'Customer', 'Diskon', 'Total - Diskon');
		$width	= array(10, 25, 30, 80, 25, 30);
		
		for($i = 0; $i < count($header); $i++)
			$pdf->Cell($width[$i], 6, $header[$i], 1, 0, 'C', true);
		$pdf->Ln();
		
		$pdf->SetFont('Arial','',9);
		$pdf->SetTextColor(0);
		
		foreach($row as $key => $value)
		{
			$pdf->Cell($width[0], 4, $key + 1, 'LR', 0, 'C');
			$pdf->Cell($width[1], 4, date('d-m-Y', strtotime($value['invoice_date'])), 'LR', 0, 'C');
			$pdf->Cell($width[2], 4, $value['invoice_number'], 'LR', 0, 'C');
			$pdf->Cell($width[3], 4, ucfirst($value['customer_desc']), 'LR', 0, 'L');
			$pdf->Cell(5, 4, '', 'L', 0);
			$pdf->Cell(20, 4, number_format($value['invoice_discount']), 'R', 0, 'R');
			$pdf->Cell(5, 4, '', 'L', 0);
			$pdf->Cell(25, 4, number_format($value['invoice_total']), 'R', 0, 'R');
			$pdf->Ln();
		}
		
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(145, 5, 'Total Penjualan ', 1, 0, 'C');
		$pdf->Cell(5, 5, 'Rp', 'LTB', 0);
		$pdf->Cell(20, 5, number_format($total->discount), 'RTB', 0, 'R');
		$pdf->Cell(5, 5, 'Rp', 'LTB', 0);
		$pdf->Cell(25, 5, number_format($total->total), 'RTB', 1, 'R');

        $pdf->Output('1.pdf', 'I');
		exit();
    }
    
    public function printInvoiceService()
    {
		$start_date		= $this->uri->segment(3);
		$to_date		= $this->uri->segment(4);
		
		$this->session->set_userdata('start_date', $start_date);
		$this->session->set_userdata('to_date', $to_date);
		$this->session->set_userdata('report_title', 'PENJUALAN (JASA)');
		
        $query	= $this->db->query("SELECT invoice.invoice_id, invoice_number, invoice_date, customer_desc, invoice_notes, SUM(detail_item_price * detail_item_qty) AS invoice_total, SUM(detail_item_buy * detail_item_qty) AS invoice_profit FROM invoice JOIN invoice_detail ON invoice.invoice_id = invoice_detail.invoice_id JOIN item ON invoice_detail.detail_item_id = item.item_id WHERE invoice.invoice_status = 1 AND item.category_id != 1 AND invoice_date >= '$start_date' AND invoice_date <= '$to_date' GROUP BY invoice.invoice_id ORDER BY invoice.invoice_date");
		$row	= $query->result_array();
		
		$detail	= $this->db->where('category_id !=', 1)->join('item', 'invoice_detail.detail_item_id = item.item_id')->get('invoice_detail')->result_array();
		
		$total	= $this->db->query("SELECT SUM(detail_item_price * detail_item_qty) AS total FROM invoice JOIN invoice_detail ON invoice.invoice_id = invoice_detail.invoice_id JOIN item ON invoice_detail.detail_item_id = item.item_id WHERE invoice.invoice_status = 1 AND item.category_id != 1 AND invoice_date >= '$start_date' AND invoice_date <= '$to_date'")->row();
		
		$profit	= $this->db->query("SELECT SUM(detail_item_buy * detail_item_qty) AS profit FROM invoice JOIN invoice_detail ON invoice.invoice_id = invoice_detail.invoice_id JOIN item ON invoice_detail.detail_item_id = item.item_id WHERE invoice.invoice_status = 1 AND item.category_id != 1 AND invoice_date >= '$start_date' AND invoice_date <= '$to_date'")->row();
		
        // Generate PDF
        $pdf = new PDFReport();
        $pdf->AddPage('P', 'A4');
        $pdf->setMargins(5,0,0);

		$pdf->setX(5);
		
		$pdf->Ln();
		
		$pdf->SetFont('Arial','B',9);
		$pdf->SetFillColor(140);
		$pdf->SetTextColor(255);
		
		$header	= array('Tanggal', 'Invoice', 'Mekanik', 'Total', 'Profit Mekanik', 'Profit');
		$width	= array(25, 30, 70, 25, 25, 25);
		
		for($i = 0; $i < count($header); $i++)
			$pdf->Cell($width[$i], 6, $header[$i], 1, 0, 'C', true);
		$pdf->Ln();
		
		$pdf->SetFont('Arial','',9);
		$pdf->SetTextColor(0);
		
		foreach($row as $key => $value)
		{
			$pdf->Cell($width[0], 4, date('d-m-Y', strtotime($value['invoice_date'])), 'LR', 0, 'C');
			$pdf->Cell($width[1], 4, $value['invoice_number'], 'LR', 0, 'C');
			$pdf->Cell($width[2], 4, ucfirst($value['invoice_notes']), 'LR', 0, 'L');
			$pdf->Cell(5, 4, '', 'L', 0);
			$pdf->Cell(20, 4, number_format($value['invoice_total']), 'R', 0, 'R');
			$pdf->Cell(5, 4, '', 'L', 0);
			$pdf->Cell(20, 4, number_format($value['invoice_profit']), 'R', 0, 'R');
			$pdf->Cell(5, 4, '', 'L', 0);
			$pdf->Cell(20, 4, number_format($value['invoice_total'] - $value['invoice_profit']), 'R', 0, 'R');
			$pdf->Ln();
			
			foreach($detail as $data){
				if($data['invoice_id'] == $value['invoice_id']){
					$pdf->Cell($width[0], 4, '', 'LR', 0, 'C');
					$pdf->Cell($width[1], 4, '', 'LR', 0, 'C');
					$pdf->Cell($width[2], 4, '- '.ucfirst($data['detail_item_desc']). ' = '.number_format($data['detail_item_buy']), 'LR', 0, 'L');
					$pdf->Cell(25, 4, '', 'LR', 0);
					$pdf->Cell(25, 4, '', 'LR', 0);
					$pdf->Cell(25, 4, '', 'LR', 0);
					$pdf->Ln();
				}
			}
		}
		
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(150, 5, 'Total Pendapatan', 1, 0, 'C');
		$pdf->Cell(5, 5, 'Rp', 'LTB', 0);
		$pdf->Cell(20, 5, number_format($profit->profit), 'RTB', 0, 'R');
		$pdf->Cell(5, 5, 'Rp', 'LTB', 0);
		$pdf->Cell(20, 5, number_format($total->total - $profit->profit), 'RTB', 1, 'R');

        $pdf->Output('1.pdf', 'I');
		exit();
    }
    
    public function printProfit()
    {
		$start_date		= $this->uri->segment(3);
		$to_date		= $this->uri->segment(4);
		
		$this->session->set_userdata('start_date', $start_date);
		$this->session->set_userdata('to_date', $to_date);
		$this->session->set_userdata('report_title', 'KEUNTUNGAN (PROFIT)');
		
        $query	= $this->db->query("SELECT invoice.invoice_id, invoice_number, invoice_date, customer_desc, invoice_total, SUM(detail_item_buy * detail_item_qty) AS invoice_profit	FROM invoice JOIN invoice_detail ON invoice.invoice_id = invoice_detail.invoice_id WHERE invoice.invoice_status = 1 AND invoice_date >= '$start_date' AND invoice_date <= '$to_date' GROUP BY invoice.invoice_id ORDER BY invoice.invoice_date");
		$row	= $query->result_array();
		
		$total	= $this->db->select('SUM(invoice_total) AS total')
						   ->where('invoice_date >= ', date('Y-m-d', strtotime($start_date)))
						   ->where('invoice_date <= ', date('Y-m-d', strtotime($to_date)))->get('invoice')->row();
		
		$profit	= $this->db->query("SELECT SUM(detail_item_buy * detail_item_qty) AS profit FROM invoice JOIN invoice_detail ON invoice.invoice_id = invoice_detail.invoice_id WHERE invoice.invoice_status = 1 AND invoice_date >= '$start_date' AND invoice_date <= '$to_date'")->row();
		
        // Generate PDF
        $pdf = new PDFReport();
        $pdf->AddPage('P', 'A4');
        $pdf->setMargins(5,0,0);

		$pdf->setX(5);
		
		$pdf->Ln();
		
		$pdf->SetFont('Arial','B',9);
		$pdf->SetFillColor(140);
		$pdf->SetTextColor(255);
		
		$header	= array('No.', 'Tanggal', 'Invoice', 'Customer', 'Total - Diskon', 'Profit');
		$width	= array(10, 25, 30, 80, 30, 25);
		
		for($i = 0; $i < count($header); $i++)
			$pdf->Cell($width[$i], 6, $header[$i], 1, 0, 'C', true);
		$pdf->Ln();
		
		//~ $pdf->Cell(10, 4, '', 'LRB', 0, 'C', true);
		//~ $pdf->Cell(25, 4, '', 'LRB', 0, 'C', true);
		//~ $pdf->Cell(30, 4, '', 'LRB', 0, 'C', true);
		//~ $pdf->Cell(80, 4, '', 'LRB', 0, 'C', true);
		//~ $pdf->Cell(25, 4, '', 'LRB', 0, 'C', true);
		//~ $pdf->Cell(30, 4, 'Setelah Diskon', 'LRB', 1, 'C', true);
		
		$pdf->SetFont('Arial','',9);
		$pdf->SetTextColor(0);
		
		foreach($row as $key => $value)
		{
			$pdf->Cell($width[0], 4, $key + 1, 'LR', 0, 'C');
			$pdf->Cell($width[1], 4, date('d-m-Y', strtotime($value['invoice_date'])), 'LR', 0, 'C');
			$pdf->Cell($width[2], 4, $value['invoice_number'], 'LR', 0, 'C');
			$pdf->Cell($width[3], 4, ucfirst($value['customer_desc']), 'LR', 0, 'L');
			$pdf->Cell(5, 4, '', 'L', 0);
			$pdf->Cell(25, 4, number_format($value['invoice_total']), 'R', 0, 'R');
			$pdf->Cell(5, 4, '', 'L', 0);
			$pdf->Cell(20, 4, number_format($value['invoice_total'] - $value['invoice_profit']), 'R', 0, 'R');
			$pdf->Ln();
		}
		
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(145, 5, 'Total Penjualan ', 1, 0, 'C');
		$pdf->Cell(5, 5, 'Rp', 'LTB', 0);
		$pdf->Cell(25, 5, number_format($total->total), 'RTB', 0, 'R');
		$pdf->Cell(5, 5, 'Rp', 'LTB', 0);
		$pdf->Cell(20, 5, number_format($total->total - $profit->profit), 'RTB', 1, 'R');

        $pdf->Output('1.pdf', 'I');
		exit();
    }
    
    public function printOther()
    {
		$start_date		= $this->uri->segment(3);
		$to_date		= $this->uri->segment(4);
		
		$this->session->set_userdata('start_date', $start_date);
		$this->session->set_userdata('to_date', $to_date);
		$this->session->set_userdata('report_title', 'DEBIT / KREDIT');
		
        $purchase	= $this->db->select('purchase_date AS date, purchase_number AS number, purchase_total AS total')
						   ->where('purchase_date >= ', date('Y-m-d', strtotime($start_date)))
						   ->where('purchase_date <= ', date('Y-m-d', strtotime($to_date)))
						   ->get_compiled_select('purchase');
		
		$invoice	= $this->db->select('invoice_date AS date, invoice_number AS number, invoice_total AS total')
						   ->where('invoice_date >= ', date('Y-m-d', strtotime($start_date)))
						   ->where('invoice_date <= ', date('Y-m-d', strtotime($to_date)))
						   ->where('invoice_status', 1)
						   ->get_compiled_select('invoice');
		
		$row = $this->db->query($purchase .' UNION ALL '. $invoice.' ORDER BY date')->result_array();
		
		$total_purchase	= $this->db->select('SUM(purchase_total) AS total')
						   ->where('purchase_date >= ', date('Y-m-d', strtotime($start_date)))
						   ->where('purchase_date <= ', date('Y-m-d', strtotime($to_date)))
						   ->get('purchase')->row();
		
		$total_invoice	= $this->db->select('SUM(invoice_total) AS total, SUM(invoice_discount) AS discount')
						   ->where('invoice_date >= ', date('Y-m-d', strtotime($start_date)))
						   ->where('invoice_date <= ', date('Y-m-d', strtotime($to_date)))
						   ->get('invoice')->row();
		
        // Generate PDF
        $pdf = new PDFReport();
        $pdf->AddPage('P', 'A4');
        $pdf->setMargins(5,0,0);

		$pdf->setX(5);
		
		$pdf->Ln();
		
		$pdf->SetFont('Arial','B',9);
		$pdf->SetFillColor(140);
		$pdf->SetTextColor(255);
		
		$header	= array('No.', 'Tanggal', 'No. Transaksi', 'Penjualan', 'Pembelian');
		$width	= array(10, 30, 100, 30, 30);
		
		for($i = 0; $i < count($header); $i++)
			$pdf->Cell($width[$i], 6, $header[$i], 1, 0, 'C', true);
		$pdf->Ln();
		
		$pdf->SetFont('Arial','',9);
		$pdf->SetTextColor(0);
		
		foreach($row as $key => $value)
		{
			$pdf->Cell($width[0], 4, $key + 1, 'LR', 0, 'C');
			$pdf->Cell($width[1], 4, date('d-m-Y', strtotime($value['date'])), 'LR', 0, 'C');
			$pdf->Cell($width[2], 4, $value['number'], 'LR', 0, 'L');
			$pdf->Cell(5, 4, '', 'L', 0);
			if(substr($value['number'], 0, 2) == 'IN'){
				$pdf->Cell(25, 4, number_format($value['total']), 'R', 0, 'R');
			} else {
				$pdf->Cell(25, 4, NULL, 'R', 0, 'R');
			}
			$pdf->Cell(5, 4, '', 'L', 0);
			if(substr($value['number'], 0, 2) == 'PO'){
				$pdf->Cell(25, 4, number_format($value['total']), 'R', 0, 'R');
			} else {
				$pdf->Cell(25, 4, NULL, 'R', 0, 'R');
			}
			$pdf->Ln();
		}
		
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(140, 5, 'Total Debit / Kredit ', 1, 0, 'C');
		$pdf->Cell(5, 5, 'Rp', 'LTB', 0);
		$pdf->Cell(25, 5, number_format($total_invoice->total), 'RTB', 0, 'R');	
		$pdf->Cell(5, 5, 'Rp', 'LTB', 0);
		$pdf->Cell(25, 5, number_format($total_purchase->total), 'RTB', 1, 'R');	

        $pdf->Output('1.pdf', 'I');
		exit();
    }
}
