<?php
date_default_timezone_set("Asia/Jakarta");
defined('BASEPATH') or exit('No direct script access allowed');

class Harmet extends CI_Controller
{	
    public function __construct()
    {
        parent::__construct();
		authentication();
    }

    public function index()
    {
        $data['title'] = 'Harmet Database';
		$data['harmet'] = $this->ModelMaster->getHarmet(array('1'=>1))->result_array();
		$data['customer'] = $this->ModelMaster->getAll('pelanggan')->result_array();
		$data['user'] = $this->ModelMaster->getBy('user', array('id_level'=>2))->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('harmet/index', $data);
        $this->load->view('templates/footer');
    }
	
	public function history()
    {
		$id_user = $this->input->post('id_user') ? $this->input->post('id_user') : '';
		$id_status = $this->input->post('id_status') ? $this->input->post('id_status') : '';
		
		if($id_status != 2){
			$where = "target.id_user LIKE '%".$id_user."%' AND target.id_status LIKE '%".$id_status."%'";
			if($id_status == 0){
				$status = 'Not Visited';
			} else if($id_status == 1){
				$status = 'Visited';
			} else if($id_status == 7){
				$status = 'Paid';
			} else if($id_status == 8){
				$status = 'Blocked';
			} else {
				$status = 'All';
			}
		} else {
			$where = "target.id_user LIKE '%".$id_user."%' AND (target.id_status > 1 AND target.id_status < 7)";
			$status = 'Not Paid';
		}
		
        $data['title'] = 'View History';
		$data['target'] = $this->ModelMaster->getByCondition($where)->result_array();
		
		if($this->input->post('id_user') != ''){
			if($id_user == '%'){
				$user_name = 'All';
			} else {
				$query_user = $this->ModelMaster->getBy('user', array('id_user'=>$id_user));
				$user = $query_user->row();
				$user_name = $user->nama_user;
			}
			
			$this->session->set_flashdata('message', '<div class="alert for-alert alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Showing data '.$status.' from '.$user_name.' user.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		}

        $this->load->view('templates/header', $data);
        $this->load->view('harmet/history', $data);
        $this->load->view('templates/footer');
    }
	
	public function detail()
    {
		$where = ['id_harmet' => $this->uri->segment(3)];
		
        $data['title'] = 'View Detailed History';
		$harmet = $this->ModelMaster->getHarmet($where);
		$row = $harmet->row();
		$data['harmet'] = $harmet->row();
		$data['history'] = $this->ModelMaster->getHarmetDetail(array('harmet.id_pelanggan'=>$row->id_pelanggan))->result_array();
		
        $this->load->view('templates/header', $data);
        $this->load->view('harmet/detail', $data);
        $this->load->view('templates/footer');
    }
	
	public function create()
	{		
		if($this->input->post('nama_pelanggan')){
			$nama_pelanggan = $this->input->post('nama_pelanggan');
			$alamat_pelanggan = $this->input->post('alamat_pelanggan');
			
			$data_customer = array(
				'nama_pelanggan' => $nama_pelanggan,
				'alamat_pelanggan' => $alamat_pelanggan,
			);
		
			$this->ModelMaster->add('pelanggan', $data_customer);
		}
		
		$id_pelanggan = $this->input->post('id_pelanggan') === NULL ? $this->db->insert_id() : $this->input->post('id_pelanggan');
		
		$data = array(
			'id_pelanggan' => $id_pelanggan,
			'ket_harmet' => $this->input->post('ket_harmet'),
			'id_user' => $this->input->post('id_user'),
			'status_harmet' => 'REPLACED',
		);
		
		$this->ModelMaster->add('harmet', $data);
		$this->session->set_flashdata('message', '<div class="alert for-alert alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;New data was added successfully !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('harmet');
	}
	
	public function update()
	{
		$id_harmet = $this->input->post('id_harmet');
		$id_pelanggan = $this->input->post('id_pelanggan');
		$merk_harmet = $this->input->post('merk_harmet');
		$no_meter_harmet = $this->input->post('no_meter_harmet');
		$tahun_harmet = $this->input->post('tahun_harmet');
		$stan_harmet = $this->input->post('stan_harmet');
		$no_ba_harmet = $this->input->post('no_ba_harmet');
		$tanggal_ba_harmet = $this->input->post('tanggal_ba_harmet');
		
		$data = array(
			'id_pelanggan' => $id_pelanggan,
			'merk_harmet' => $merk_harmet,
			'no_meter_harmet' => $no_meter_harmet,
			'tahun_harmet' => $tahun_harmet,
			'stan_harmet' => $stan_harmet,
			'status_harmet' => 'REPLACED',
			'no_ba_harmet' => $no_ba_harmet,
			'tanggal_ba_harmet' => $tanggal_ba_harmet,
		);
		$where = array('id_harmet' => $id_harmet);
		
		if($this->input->post('update') == 'Update'){
			$this->ModelMaster->edit('harmet', $where, array('no_ba_harmet'=>$no_ba_harmet, 'tanggal_ba_harmet'=>$tanggal_ba_harmet));
			redirect('harmet/detail/'.$id_harmet);
		} else {
			$this->ModelMaster->edit('harmet', $where, array('status_harmet'=>0));
			$this->ModelMaster->add('harmet', $data);
			redirect('harmet/detail/'.$this->db->insert_id());
		}
	}
	
	public function setting()
    {
        $data['title'] = 'Harmet Target Setting';
		$data['harmet_target'] = $this->ModelMaster->getBy('harmet_target', array('status_harmet_target'=>1))->result_array();
	
		if($this->input->post('save') == 'Save'){
			$this->ModelMaster->edit('harmet_target', array('id_harmet_target'=>$this->input->post('id_harmet_target')), array('hari_harmet_target'=>$this->input->post('hari_harmet_target'), 'bulan_harmet_target'=>$this->input->post('bulan_harmet_target'), 'tahun_harmet_target'=>$this->input->post('tahun_harmet_target')));
			redirect('harmet/setting');
		} else {
			$this->load->view('templates/header', $data);
			$this->load->view('harmet/setting', $data);
			$this->load->view('templates/footer');
		}
    }
	
	public function export()
    {
		$where = "target.id_status != 1";
		
        $data['title'] = 'Target Database';
		$data['target'] = $this->ModelMaster->getByCondition($where)->result_array();

        $this->load->view('target/export', $data);
    }
}