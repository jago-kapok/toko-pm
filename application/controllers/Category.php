<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
{	
    public function __construct()
    {
        parent::__construct();
		// authentication();
		
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
			$row["category_code"]	= $val->category_code;
			$row["category_desc"]	= $val->category_desc;
			$row["action"]			= "	<button class=\"btn btn-xs btn-danger detail-data\" data-id=\"".$val->category_id."\">
											<i class=\"fa fa-trash\"></i>
										</button>";
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
	
	public function data()
    {
		$id_pelanggan = $this->uri->segment(3);
		$customer = $this->ModelMaster->getBy('pelanggan', array('id_pelanggan'=>$id_pelanggan))->result_array();
		
		foreach($customer as $data){
			$output[] = array(
				"nama_pelanggan" => $data['nama_pelanggan'],
				"alamat_pelanggan" => $data['alamat_pelanggan']
			);
		}
		
		echo json_encode($output);
    }
	
	public function create()
	{
		$noreg_pelanggan = $this->input->post('noreg_pelanggan');
		$nama_pelanggan = $this->input->post('nama_pelanggan');
		$alamat_pelanggan = $this->input->post('alamat_pelanggan');
		$tarif = $this->input->post('tarif');
		$daya = $this->input->post('daya');
		$lat = $this->input->post('lat');
		$lang = $this->input->post('lang');
		
		$data = array(
			'noreg_pelanggan' => $noreg_pelanggan,
			'nama_pelanggan' => $nama_pelanggan,
			'alamat_pelanggan' => $alamat_pelanggan,
			'tarif' => $tarif,
			'daya' => $daya,
			'lat' => $lat,
			'lang' => $lang,
		);
	 
		$query = $this->ModelMaster->getBy('pelanggan', array('noreg_pelanggan'=>$noreg_pelanggan));
		
		if($query->num_rows() <= 0){
			$this->ModelMaster->add('pelanggan', $data);
			$this->session->set_flashdata('message', '<div class="alert for-alert alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;New data was added successfully !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		} else {
			$this->session->set_flashdata('message', '<div class="alert for-alert alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Reg. Number : '.$noreg_pelanggan.' exist in table !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		}
		redirect('customer');
	}
	
	public function update()
	{
		$id_pelanggan = $this->input->post('id_pelanggan');
		$noreg_pelanggan = $this->input->post('noreg_pelanggan');
		$nama_pelanggan = $this->input->post('nama_pelanggan');
		$alamat_pelanggan = $this->input->post('alamat_pelanggan');
		$tarif = $this->input->post('tarif');
		$daya = $this->input->post('daya');
		$lat = $this->input->post('lat');
		$lang = $this->input->post('lang');
		
		$data = array(
			'noreg_pelanggan' => $noreg_pelanggan,
			'nama_pelanggan' => $nama_pelanggan,
			'alamat_pelanggan' => $alamat_pelanggan,
			'tarif' => $tarif,
			'daya' => $daya,
			'lat' => $lat,
			'lang' => $lang,
		);
		$where = array('id_pelanggan' => $id_pelanggan);
	 
		$this->ModelMaster->edit('pelanggan', $where, $data);
		$this->session->set_flashdata('message', '<div class="alert for-alert alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data for : '.$noreg_pelanggan.' / '.$nama_pelanggan.' was updated !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('customer');
	}

    public function delete()
    {
        $where = ['id_pelanggan' => $this->uri->segment(3)];
		$query = $this->ModelMaster->getBy('pelanggan', $where);
		$row = $query->row();
		
        $this->ModelMaster->delete('pelanggan', $where);
		$this->session->set_flashdata('message', '<div class="alert for-alert alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data for : '.$row->noreg_pelanggan.' / '.$row->nama_pelanggan.' was deleted !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('customer');
    }
	
	public function import(){
		require './application/libraries/excel_reader2.php';
		// require './application/libraries/SpreadsheetReader.php';
		
		$config['upload_path']		= './assets/tmp_file/';
		$config['allowed_types']	= 'xls|xlsx';
		$config['max_size']			= 2048;
		$config['file_name']		= 'CUST-'.date("Y-m-d");
		
		$this->load->library('upload', $config);
		
		if(!$this->upload->do_upload('excel_file')){
			$this->session->set_flashdata('message', '<div class="alert for-alert alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Error while uploading file !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('customer');
		} else {
			$data = new Spreadsheet_Excel_Reader($_FILES["excel_file"]["tmp_name"]);
			$baris = $data->rowcount($sheet_index = 0);
			
			for($i=2; $i<=$baris; $i++){
				$noreg_pelanggan	= $data->val($i, 1);
				$nama_pelanggan		= $data->val($i, 2);
				$alamat_pelanggan	= $data->val($i, 3);
				$daya				= $data->val($i, 4);
				$tarif				= $data->val($i, 5);
				$lat				= $data->val($i, 6);
				$lang				= $data->val($i, 7);

				if($noreg_pelanggan != ''){
					$row = $this->db->query("INSERT INTO pelanggan (
							noreg_pelanggan,
							nama_pelanggan,
							alamat_pelanggan,
							daya,
							tarif,
							lat,
							lang
						) VALUES (
							'$noreg_pelanggan',
							'$nama_pelanggan',
							'$alamat_pelanggan',
							'$daya',
							'$tarif',
							'$lat',
							'$lang'
						)"
					);
				}
			}
			
			array_map('unlink', glob('./assets/tmp_file/*.xls'));
			array_map('unlink', glob('./assets/tmp_file/*.xlsx'));
			
			$this->session->set_flashdata('message', '<div class="alert for-alert alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Import data successfully !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('customer');
		}
	}
	
	public function export()
    {
        $data['title'] = 'Customer Database';
		$data['customer'] = $this->ModelMaster->getAll('pelanggan')->result_array();

        $this->load->view('customer/export', $data);
    }
}