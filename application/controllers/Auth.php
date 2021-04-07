<?php

class Auth extends CI_Controller
{
	function __construct(){
		parent::__construct();
	}
 
	public function index()
    {
        $this->load->view('templates/aute_header');
        $this->load->view('admin/login');
        $this->load->view('templates/aute_footer');
    }
 
	function login(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$where = array(
			'username' => $username,
			'password' => $password
		);
		
		$user = $this->ModelMaster->getBy('user', $where)->num_rows();
		$data_user = $this->ModelMaster->getBy('user', $where)->row();
		
		$user_level = $data_user->id_level != 2 ? 'Administrator' : 'Technician';
		
		if($user > 0){
			$data_session = array(
				'id' => $data_user->id_user,
				'fullname' => $data_user->nama_user,
				'id_level' => $data_user->id_level,
				'level' => $user_level,
				'username' => $username,
				'email' => $data_user->email_user,
				'phone' => $data_user->telp_user
			);
 
			$this->session->set_userdata($data_session);
 
			redirect(base_url(""));
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show">Wrong username or password !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			
			redirect(base_url("auth"));
		}
	}
 
	function logout(){
		$this->session->sess_destroy();
		
		$this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show">Sign out successfully !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		
		redirect(base_url("auth"));
	}
}