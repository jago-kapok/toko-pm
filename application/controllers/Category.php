<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
{	
    public function __construct()
    {
        parent::__construct();
		authentication();

		$this->load->model("CategoryModel", "mod_category");
    }

    public function index()
    {
        $data['title'] = 'Data Kategori';

        $this->load->view('templates/header', $data);
        $this->load->view('category/index', $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/js/category');
    }
	
	public function getData()
	{
		$list = $this->mod_category->getAll();
		$data = [];
		$no = $_POST["start"];
		foreach($list as $val)
		{
			$no++;
			$row					= [];
			$row["no"]				= $no;
			$row["category_desc"]	= $val->category_desc;
			$row["action"]			= "	<a href=\"javascript:void(0)\" class=\"btn btn-xs btn-info\" data-toggle=\"modal\" data-target=\"#category_update\"
				data-category_id=\"".$val->category_id."\"
				data-category_desc=\"".$val->category_desc."\"
			>
											<i class=\"fa fa-edit\"></i>
										</a>&nbsp;
										<a href=\"category/delete/".$val->category_id."\" class=\"btn btn-xs btn-danger\" onclick=\"return confirm('Hapus data ini ?')\">
											<i class=\"fa fa-trash\"></i>
										</a>";
			$data[] = $row;
		}

		$output = array(
			"draw"				=> $_POST['draw'],
			"recordsTotal"		=> $this->mod_category->countAll(),
			"recordsFiltered"	=> $this->mod_category->countFilter(),
			"data"				=> $data,
		);
		echo json_encode($output);
	}
	
	public function create()
	{
		$category_desc = $this->input->post('category_desc');
		
		$data = array(
			'category_desc' => $category_desc
		);
	 
		$exist = $this->MasterModel->getBy('category', array('category_desc'=>$category_desc));
		
		if($exist->num_rows() == 0){
			$this->MasterModel->add('category', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data berhasil ditambahkan !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Kategori '.strtoupper($category_desc).' sudah ada !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		}
		redirect('category');
	}
	
	public function update()
	{
		$category_id	= $this->input->post('category_id');
		$category_desc	= $this->input->post('category_desc');
		
		$data = array(
			'category_desc' => $category_desc
		);
		$where = array('category_id' => $category_id);
	 
		$exist = $this->MasterModel->getBy('category', array('category_desc'=>$category_desc));
		
		if($exist->num_rows() == 0){
			$this->MasterModel->edit('category', $where, $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data berhasil diperbarui !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data '.strtoupper($category_desc).' sudah ada !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		}
		redirect('category');
	}

    public function delete()
    {
        $where = ['category_id' => $this->uri->segment(3)];
		$query = $this->MasterModel->getBy('category', $where);
		$row = $query->row();
		
        $this->MasterModel->delete('category', $where);
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data '.strtoupper($row->category_desc).' berhasil dihapus !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('category');
    }
}
