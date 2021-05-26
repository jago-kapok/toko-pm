<?php

class Auth extends CI_Controller
{
	function __construct(){
		parent::__construct();
	}
 
	public function index()
    {
        $this->load->view('templates/auth_header');
        $this->load->view('admin/login');
        $this->load->view('templates/auth_footer');
    }
 
	function login(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$where = array(
			'user_name' => $username,
			'user_password' => md5($password)
		);
		
		$user = $this->MasterModel->getBy('user', $where)->num_rows();
		
		if($user > 0){
			$data_user = $this->MasterModel->getBy('user', $where)->row();
		
			$user_level = $data_user->user_level == 1 ? 'Administrator' : 'User';
		
			$data_session = array(
				'user_id'		=> $data_user->user_id,
				'user_fullname'	=> $data_user->user_fullname,
				'user_level'	=> $data_user->user_level,
				'level'			=> $user_level,
				'user_name'		=> $username,
				'user_password'	=> $data_user->user_password,
				'user_address'	=> $data_user->user_address,
				'user_phone'	=> $data_user->user_phone
			);
 
			$this->session->set_userdata($data_session);
 
			redirect(base_url(""));
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show">Username atau password salah !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			
			redirect(base_url("auth"));
		}
	}
 
	function logout(){
		$this->session->sess_destroy();
		
		$this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show">Sign out berhasil !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		
		redirect(base_url("auth"));
	}
}
