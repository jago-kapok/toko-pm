<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{	
    public function __construct()
    {
        parent::__construct();
		//~ authentication();
    }

    public function index()
    {
        $data['title'] = 'Manajemen Pengguna';
        $data['level'] = $this->db->get('level')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
		$this->load->view('templates/js/user');
    }
	
	public function getData()
	{
		$this->load->library("datatables_ssp");
		$_table = "user";
		$_conn 	= [
			"user" 	=> $this->db->username,
			"pass" 	=> $this->db->password,
			"db" 	=> $this->db->database,
			"host" 	=> $this->db->hostname,
			"port" 	=> $this->db->port
		];
		$_key	= "user_id";
		$_coll	= [
			["db" => "user_fullname",	"dt" => "user_fullname"],
			["db" => "user_name",		"dt" => "user_name"],
			["db" => "user_address",	"dt" => "user_address"],
			["db" => "user_phone",		"dt" => "user_phone"],
			["db" => "level_desc",		"dt" => "level_desc"],
			["db" => "user_id",			"dt" => "user_id"],
			
			["db" => "user_level",		"dt" => "user_level"]
		];
		
		$_where	= NULL;
		$_join	= "JOIN level ON user.user_level = level.level_id";

		echo json_encode(
			Datatables_ssp::complex($_GET, $_conn, $_table, $_key, $_coll, $_where, NULL, $_join)
		);
	}
	
	public function create()
	{
		$user_fullname	= $this->input->post('user_fullname');
		$user_name		= $this->input->post('user_name');
		$user_password	= $this->input->post('user_password');
		$user_address	= $this->input->post('user_address');
		$user_phone		= $this->input->post('user_phone');
		$user_level		= $this->input->post('user_level');
		
		$data = array(
			'user_fullname'	=> $user_fullname,
			'user_name'		=> $user_name,
			'user_password'	=> $user_password,
			'user_address'	=> $user_address,
			'user_phone'	=> $user_phone,
			'user_level'	=> $user_level,
		);
	 
		$exist = $this->MasterModel->getBy('user', array('user_name'=>$user_name));
		
		if($exist->num_rows() == 0){
			$this->MasterModel->add('user', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Pengguna baru berhasil ditambahkan !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Username '.strtoupper($user_name).' sudah digunakan !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		}
		redirect('user');
	}
	
	public function update()
	{
		$user_id		= $this->input->post('user_id');
		$user_fullname	= $this->input->post('user_fullname');
		$user_name		= $this->input->post('user_name');
		$user_address	= $this->input->post('user_address');
		$user_phone		= $this->input->post('user_phone');
		$user_level		= $this->input->post('user_level');
		
		$data = array(
			'user_fullname'	=> $user_fullname,
			'user_name'		=> $user_name,
			'user_address'	=> $user_address,
			'user_phone'	=> $user_phone,
			'user_level'	=> $user_level,
		);
		$where = array('user_id' => $user_id);
	 
		$exist = $this->MasterModel->getBy('user', array('user_name'=>$user_name));
		
		if($exist->num_rows() <= 1){
			$this->MasterModel->edit('user', $where, $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data pengguna '.strtoupper($user_name).' berhasil diperbarui !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data '.strtoupper($user_name).' sudah ada !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		}
		redirect('user');
	}

    public function delete()
    {
        $where = ['user_id' => $this->uri->segment(3)];
		$query = $this->MasterModel->getBy('user', $where);
		$row = $query->row();
		
        $this->MasterModel->delete('user', $where);
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data pengguna'.strtoupper($row->user_name).' berhasil dihapus !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('user');
    }
}
