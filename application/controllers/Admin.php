<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		// authentication();
    }

    public function index()
    {
		$data['title'] = 'Dashboard Monitoring';
		
		// $data['visited'] = $this->ModelMaster->getBy('target', array('id_status'=>1))->num_rows();
		// $data['paid'] = $this->ModelMaster->getBy('target', array('id_status'=>7))->num_rows();
		// $data['blocked'] = $this->ModelMaster->getBy('target', array('id_status'=>8))->num_rows();
		// $data['not_paid'] = $this->ModelMaster->getBy('target', array('id_status >'=>1, 'id_status <'=>7))->num_rows();
		
		// $year = !$this->session->flashdata('year') ? date('Y') : $this->session->flashdata('year');
		
		// $data['jan'] = $this->ModelMaster->getBy('target', array('MONTH(tgl_create)'=>1,'YEAR(tgl_create)'=>$year))->num_rows();
		// $data['feb'] = $this->ModelMaster->getBy('target', array('MONTH(tgl_create)'=>2,'YEAR(tgl_create)'=>$year))->num_rows();
		// $data['mar'] = $this->ModelMaster->getBy('target', array('MONTH(tgl_create)'=>3,'YEAR(tgl_create)'=>$year))->num_rows();
		// $data['apr'] = $this->ModelMaster->getBy('target', array('MONTH(tgl_create)'=>4,'YEAR(tgl_create)'=>$year))->num_rows();
		// $data['may'] = $this->ModelMaster->getBy('target', array('MONTH(tgl_create)'=>5,'YEAR(tgl_create)'=>$year))->num_rows();
		// $data['jun'] = $this->ModelMaster->getBy('target', array('MONTH(tgl_create)'=>6,'YEAR(tgl_create)'=>$year))->num_rows();
		// $data['jul'] = $this->ModelMaster->getBy('target', array('MONTH(tgl_create)'=>7,'YEAR(tgl_create)'=>$year))->num_rows();
		// $data['aug'] = $this->ModelMaster->getBy('target', array('MONTH(tgl_create)'=>8,'YEAR(tgl_create)'=>$year))->num_rows();
		// $data['sep'] = $this->ModelMaster->getBy('target', array('MONTH(tgl_create)'=>9,'YEAR(tgl_create)'=>$year))->num_rows();
		// $data['oct'] = $this->ModelMaster->getBy('target', array('MONTH(tgl_create)'=>10,'YEAR(tgl_create)'=>$year))->num_rows();
		// $data['nov'] = $this->ModelMaster->getBy('target', array('MONTH(tgl_create)'=>11,'YEAR(tgl_create)'=>$year))->num_rows();
		// $data['dec'] = $this->ModelMaster->getBy('target', array('MONTH(tgl_create)'=>12,'YEAR(tgl_create)'=>$year))->num_rows();
		
		// $data['target'] = $this->ModelMaster->getBy('target', array('YEAR(tgl_create)'=>$year))->num_rows();
		$data['user'] = $this->ModelMaster->getAll('user')->num_rows();
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
