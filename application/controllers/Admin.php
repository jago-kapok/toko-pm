<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		authentication();
    }

    public function index()
    {
		$data['title'] = 'Dashboard';
		
		$data['quotation']	= $this->db->select('SUM(quotation_total) AS quotation_total')
							  ->where(['quotation_status'=>1])
							  ->like(['YEAR(quotation_date)'=>date('Y')])->get('quotation')->row();
		$data['invoice']	= $this->db->select('SUM(invoice_total) AS invoice_total')
							  ->where(['invoice_status'=>1])
							  ->like(['YEAR(invoice_date)'=>date('Y')])->get('invoice')->row();
		$data['purchase']	= $this->db->select('SUM(purchase_total) AS purchase_total')
							  ->where(['purchase_status'=>0])
							  ->like(['YEAR(purchase_date)'=>date('Y')])->get('purchase')->row();
		$data['item']		= $this->MasterModel->getBy('item', NULL)->num_rows();
		
		$year = !$this->session->flashdata('year') ? date('Y') : $this->session->flashdata('year');
		
		$data['jan'] = $this->MasterModel->getBy('invoice', array('MONTH(invoice_date)'=>1,'YEAR(invoice_date)'=>$year))->num_rows();
		$data['feb'] = $this->MasterModel->getBy('invoice', array('MONTH(invoice_date)'=>2,'YEAR(invoice_date)'=>$year))->num_rows();
		$data['mar'] = $this->MasterModel->getBy('invoice', array('MONTH(invoice_date)'=>3,'YEAR(invoice_date)'=>$year))->num_rows();
		$data['apr'] = $this->MasterModel->getBy('invoice', array('MONTH(invoice_date)'=>4,'YEAR(invoice_date)'=>$year))->num_rows();
		$data['may'] = $this->MasterModel->getBy('invoice', array('MONTH(invoice_date)'=>5,'YEAR(invoice_date)'=>$year))->num_rows();
		$data['jun'] = $this->MasterModel->getBy('invoice', array('MONTH(invoice_date)'=>6,'YEAR(invoice_date)'=>$year))->num_rows();
		$data['jul'] = $this->MasterModel->getBy('invoice', array('MONTH(invoice_date)'=>7,'YEAR(invoice_date)'=>$year))->num_rows();
		$data['aug'] = $this->MasterModel->getBy('invoice', array('MONTH(invoice_date)'=>8,'YEAR(invoice_date)'=>$year))->num_rows();
		$data['sep'] = $this->MasterModel->getBy('invoice', array('MONTH(invoice_date)'=>9,'YEAR(invoice_date)'=>$year))->num_rows();
		$data['oct'] = $this->MasterModel->getBy('invoice', array('MONTH(invoice_date)'=>10,'YEAR(invoice_date)'=>$year))->num_rows();
		$data['nov'] = $this->MasterModel->getBy('invoice', array('MONTH(invoice_date)'=>11,'YEAR(invoice_date)'=>$year))->num_rows();
		$data['dec'] = $this->MasterModel->getBy('invoice', array('MONTH(invoice_date)'=>12,'YEAR(invoice_date)'=>$year))->num_rows();
		
		$data['recent_invoice'] = $this->db->query("SELECT invoice.invoice_id, invoice_number, invoice_date, customer_desc, invoice_total, SUM(detail_item_buy * detail_item_qty) AS invoice_profit	FROM invoice JOIN invoice_detail ON invoice.invoice_id = invoice_detail.invoice_id WHERE invoice.invoice_status = 1 GROUP BY invoice.invoice_id ORDER BY invoice.invoice_id DESC LIMIT 5")->result();
		
		$data['stock_exist'] = $this->db->where('stock_exist < stock_min')->join('item', 'stock.item_id = item.item_id')->get('stock')->result();
		
		$data['invoice_per_day']	= $this->db->select('SUM(invoice_total) AS invoice_total')
									  ->where(['invoice_status'=>1])
									  ->like(['invoice_date'=>date('Y-m-d')])->get('invoice')->row();
		$data['purchase_per_day']	= $this->db->select('SUM(purchase_total) AS purchase_total')
									  ->where(['purchase_status'=>0])
									  ->like(['purchase_date'=>date('Y-m-d')])->get('purchase')->row();
		$data['profit_per_day']		= $this->db->select('SUM(detail_item_buy * detail_item_qty) AS invoice_profit')
									  ->where(['invoice_status'=>1])
									  ->like(['invoice_date'=>date('Y-m-d')])
									  ->join('invoice_detail', 'invoice.invoice_id = invoice_detail.invoice_id')->get('invoice')->row();
		
		$data['invoice_yesterday']	= $this->db->select('SUM(invoice_total) AS invoice_total')
									  ->where(['invoice_status'=>1])
									  ->like(['invoice_date'=>date('Y-m-d', strtotime('-1 days'))])->get('invoice')->row();
		$data['profit_yesterday']	= $this->db->select('SUM(detail_item_buy * detail_item_qty) AS invoice_profit')
									  ->where(['invoice_status'=>1])
									  ->like(['invoice_date'=>date('Y-m-d', strtotime('-1 days'))])
									  ->join('invoice_detail', 'invoice.invoice_id = invoice_detail.invoice_id')->get('invoice')->row();
		
        $this->load->view('templates/header', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }
	
	public function dashboard()
	{
		if(!$this->uri->segment(3)){
			$year = $this->session->set_flashdata('year', date('Y'));
			redirect('/');
		} else {
			$year = $this->session->set_flashdata('year', $this->uri->segment(3));
			redirect('/');
		}
	}
}
