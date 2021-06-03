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
		
		$data['quotation']	= $this->db->select('SUM(quotation_total) AS quotation_total')->where(['quotation_status'=>1])->get('quotation')->row();
		$data['invoice']	= $this->db->select('SUM(invoice_total) AS invoice_total')->where(['invoice_status'=>1])->get('invoice')->row();
		$data['purchase']	= $this->db->select('SUM(purchase_total) AS purchase_total')->where(['purchase_status'=>0])->get('purchase')->row();
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
		
		// $data['target'] = $this->ModelMaster->getBy('target', array('YEAR(tgl_create)'=>$year))->num_rows();
		//~ $data['user'] = $this->ModelMaster->getAll('user')->num_rows();
		// $data['pelanggan'] = $this->ModelMaster->getAll('pelanggan')->num_rows();
		// $data['harmet'] = $this->ModelMaster->getBy('harmet', array('status_harmet'=>1))->num_rows();
		
		// $data['harmet_target'] = $this->ModelMaster->getBy('harmet_target', array('status_harmet_target'=>1))->row();
		// $harmet_target = $this->ModelMaster->getBy('harmet_target', array('status_harmet_target'=>1))->row();
		
		// $harmet_tahun = $this->ModelMaster->getBy('harmet', array('YEAR(tanggal_penggantian_harmet)'=>$year))->num_rows();
		// $data['harmet_tahun'] = ($harmet_tahun / $harmet_target->tahun_harmet_target) * 100;
		// $data['harmet_tahun_terealisasi'] = $harmet_tahun;
		
		// $data['harmet_bulan'] = round((($harmet_tahun / 12) / $harmet_target->bulan_harmet_target) * 100, 3);
		// $data['harmet_bulan_terealisasi'] = round($harmet_tahun / 12, 3);
		
		// $data['harmet_hari'] = round((($harmet_tahun / 365) / $harmet_target->hari_harmet_target) * 100, 3);
		// $data['harmet_hari_terealisasi'] = round($harmet_tahun / 365, 3);
		
		$data['recent_invoice'] = $this->db->query("SELECT invoice_number, invoice_date, customer_name, invoice_total, SUM(detail_item_buy * detail_item_qty) AS invoice_profit	FROM invoice JOIN invoice_detail ON invoice.invoice_id = invoice_detail.invoice_id JOIN customer ON invoice.customer_id = customer.customer_id WHERE invoice.invoice_status = 1 GROUP BY invoice.invoice_id ORDER BY invoice.invoice_id DESC LIMIT 5")->result();
		
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
