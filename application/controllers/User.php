<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{	
    public function __construct()
    {
        parent::__construct();
		authentication();
    }

    public function index()
    {
        $data['title'] = 'User Database';
		$data['user'] = $this->ModelMaster->getAll('user')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }
	
	public function create()
	{
		$nama_user = $this->input->post('nama_user');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$id_level = $this->input->post('id_level');
		$email_user = $this->input->post('email_user');
		$telp_user = $this->input->post('telp_user');
		
		$data = array(
			'nama_user' => $nama_user,
			'username' => $username,
			'password' => $password,
			'id_level' => $id_level,
			'email_user' => $email_user,
			'telp_user' => $telp_user,
		);
	 
		$this->ModelMaster->add('user', $data);
		$this->session->set_flashdata('message', '<div class="alert for-alert alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;New data was added successfully !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('user');
	}
	
	public function update()
	{
		$id_user = $this->input->post('id_user');
		$nama_user = $this->input->post('nama_user');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$id_level = $this->input->post('id_level');
		$email_user = $this->input->post('email_user');
		$telp_user = $this->input->post('telp_user');
		
		$data = array(
			'nama_user' => $nama_user,
			'username' => $username,
			'password' => $password,
			'id_level' => $id_level,
			'email_user' => $email_user,
			'telp_user' => $telp_user,
		);
		$where = array('id_user' => $id_user);
	 
		$this->ModelMaster->edit('user', $where, $data);
		$this->session->set_flashdata('message', '<div class="alert for-alert alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data for : '.$nama_user.' was updated !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('user');
	}

    public function delete()
    {
        $where = ['id_user' => $this->uri->segment(3)];
		$query = $this->ModelMaster->getBy('user', $where);
		$row = $query->row();
		
        $this->ModelMaster->delete('user', $where);
		$this->session->set_flashdata('message', '<div class="alert for-alert alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data for : '.$row->nama_user.' was deleted !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('user');
    }
	
	public function import(){
		require './application/libraries/excel_reader2.php';
		// require './application/libraries/SpreadsheetReader.php';
		
		$config['upload_path']		= './assets/tmp_file/';
		$config['allowed_types']	= 'xls|xlsx';
		$config['max_size']			= 2048;
		$config['file_name']		= date("Y-m-d");
		
		$this->load->library('upload', $config);
		
		if(!$this->upload->do_upload('excel_file')){
			$this->session->set_flashdata('message', '<div class="alert for-alert alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Error while uploading file !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('user');
		} else {
			$data = new Spreadsheet_Excel_Reader($_FILES["excel_file"]["tmp_name"]);
			$baris = $data->rowcount($sheet_index = 0);
			
			for($i=2; $i<=$baris; $i++){
				$nama_user	= $data->val($i, 1);
				$username	= $data->val($i, 2);
				$password	= $data->val($i, 3);
				$id_level	= $data->val($i, 4);
				$email_user	= $data->val($i, 5);
				$telp_user	= $data->val($i, 6);

				if($nama_user != ''){
					$row = $this->db->query("INSERT INTO user (
							nama_user,
							username,
							password,
							id_level,
							email_user,
							telp_user
						) VALUES (
							'$nama_user',
							'$username',
							'$password',
							'$id_level',
							'$email_user',
							'$telp_user'
						)"
					);
				}
			}
			
			array_map('unlink', glob('./assets/tmp_file/*.xls'));
			array_map('unlink', glob('./assets/tmp_file/*.xlsx'));
			
			$this->session->set_flashdata('message', '<div class="alert for-alert alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Import data successfully !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('user');
		}
	}
	
	public function export()
    {
        $data['title'] = 'User Database';
		$data['user'] = $this->ModelMaster->getAll('user')->result_array();

        $this->load->view('user/export', $data);
    }
}