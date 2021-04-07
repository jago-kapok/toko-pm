<?php
date_default_timezone_set("Asia/Jakarta");
defined('BASEPATH') or exit('No direct script access allowed');

class Target extends CI_Controller
{	
    public function __construct()
    {
        parent::__construct();
		authentication();
    }

    public function index()
    {
        $data['title'] = 'Target Database';
		$data['target'] = $this->ModelMaster->getByCondition(array('target.id_status'=>0))->result_array();
		$data['customer'] = $this->ModelMaster->getAll('pelanggan')->result_array();
		$data['user'] = $this->ModelMaster->getBy('user', array('id_level'=>2))->result_array();
		$data['status'] = $this->ModelMaster->getAll('status')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('target/index', $data);
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
		$data['user'] = $this->ModelMaster->getAll('user')->result_array();
		$data['status'] = $this->ModelMaster->getAll('status')->result_array();
		$data['golongan_pelanggaran'] = $this->ModelMaster->getAll('golongan_pelanggaran')->result_array();
		
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
        $this->load->view('target/history', $data);
        $this->load->view('templates/footer');
    }
	
	public function detail()
    {
		$where = ['id_target' => $this->uri->segment(3)];
		
        $data['title'] = 'View Detailed History';
		$target = $this->ModelMaster->getByCondition($where);
		$data['target'] = $target->row();
		
        $this->load->view('templates/header', $data);
        $this->load->view('target/detail', $data);
        $this->load->view('templates/footer');
    }
	
	public function create()
	{
		$tgl_create = date("Y-m-d H:i:s");
		
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
		
		// Fungsi upload file
		$config['upload_path']		= './mobile/target/';
		$config['allowed_types']	= 'gif|jpg|png|jpeg';
		$config['file_name']		= mt_rand();
 
		$this->load->library('upload', $config);
		$this->upload->do_upload('dok_to');
		// Fungsi upload file
		
		$data = array(
			'id_pelanggan' => $id_pelanggan,
			'dok_to' => $config['file_name'].'.'.pathinfo($_FILES['dok_to']['name'], PATHINFO_EXTENSION),
			'tgl_create' => $tgl_create,
		);
		
		$this->ModelMaster->add('target', $data);
		$this->session->set_flashdata('message', '<div class="alert for-alert alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;New data was added successfully !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('target');
	}
	
	public function update()
	{
		$id_target = $this->input->post('id_target');
		$id_pelanggan = $this->input->post('id_pelanggan');
		$id_status = $this->input->post('id_status');
		$tgl_create = date("Y-m-d H:i:s");
		
		$data = array(
			'id_pelanggan' => $id_pelanggan,
			'id_status' => $id_status,
			'tgl_create' => $tgl_create,
		);
		$where = array('id_target' => $id_target);
	 
		$this->ModelMaster->edit('target', $where, $data);
		$this->session->set_flashdata('message', '<div class="alert for-alert alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data '.$id_target.' was updated !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('target');
	}
	
	public function update_history()
	{
		$id_target = $this->input->post('id_target');
		$golongan_pelanggaran = $this->input->post('golongan_pelanggaran');
		
		$data = array(
			'golongan_pelanggaran' => $golongan_pelanggaran,
		);
		$where = array('id_target' => $id_target);
	 
		$this->ModelMaster->edit('target', $where, $data);
		$this->session->set_flashdata('message', '<div class="alert for-alert alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data '.$id_target.' was updated !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('target/history');
	}
	
	public function send()
	{
		include "./mobile/send_mail_target.php";
		
		$id_target = $this->input->post('id_target');
		$id_user = $this->input->post('id_user');
		
		$data = array(
			'id_user' => $id_user
		);
		$where = array('id_target' => $id_target);
	 
		$this->ModelMaster->edit('target', $where, $data);
		
		$query = $this->ModelMaster->getBy('user', array('id_user'=>$id_user));
		$row = $query->row();
		
		// Fungsi send email
		$subject	= "no-reply [TARGET OPERASI]";
		$body   	= '
<pre style="font-family: courier; font-size: 16px">
<span style="color:red"><strong>INFORMATION !</strong></span><br/>
Daftar Target Operasi telah dikirim ke aplikasi APS anda.
Silakan buka <a href="http://www.p2tl.jos/">Aplikasi APS</a> anda untuk mengecek daftar target operasi<br/><br/><br/><br/>

Terima Kasih.<br/>
<strong>Administrator P2TL</strong>';

		send($row->email_user, $row->nama_user, $subject, $body, 'Tes');
		// Fungsi send email
		
		$this->session->set_flashdata('message', '<div class="alert for-alert alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data '.$id_target.' was updated !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		// redirect('target');
	}

    public function delete()
    {
        $where = ['id_target' => $this->uri->segment(3)];
		$query = $this->ModelMaster->getBy('target', $where);
		$row = $query->row();
		
        $this->ModelMaster->delete('target', $where);
		$this->session->set_flashdata('message', '<div class="alert for-alert alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Data '.$row->id_target.' was deleted !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('target');
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
				$id_pelanggan	= $data->val($i, 1);

				if($id_pelanggan != ''){
					$row = $this->db->query("INSERT INTO target (
							id_pelanggan
						) VALUES (
							'$id_pelanggan'
						)"
					);
				}
			}
			
			array_map('unlink', glob('./assets/tmp_file/*.xls'));
			array_map('unlink', glob('./assets/tmp_file/*.xlsx'));
			
			$this->session->set_flashdata('message', '<div class="alert for-alert alert-dismissible fade show"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Import data successfully !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('target');
		}
	}
	
	public function export()
    {
		$where = "target.id_status != 1";
		
        $data['title'] = 'Target Database';
		$data['target'] = $this->ModelMaster->getByCondition($where)->result_array();

        $this->load->view('target/export', $data);
    }
	
	public function export_visited()
    {
		$where = "target.id_status = 1";
		
        $data['title'] = 'Target Database';
		$data['target'] = $this->ModelMaster->getByCondition($where)->result_array();

        $this->load->view('target/export', $data);
    }
	
	public function export_not_paid()
    {
		$where = "target.id_status > 1 AND target.id_status < 7";
		
        $data['title'] = 'Target Database';
		$data['target'] = $this->ModelMaster->getByCondition($where)->result_array();

        $this->load->view('target/export', $data);
    }
	
	public function export_paid()
    {
		$where = "target.id_status = 7";
		
        $data['title'] = 'Target Database';
		$data['target'] = $this->ModelMaster->getByCondition($where)->result_array();

        $this->load->view('target/export', $data);
    }
	
	public function export_blocked()
    {
		$where = "target.id_status = 8";
		
        $data['title'] = 'Target Database';
		$data['target'] = $this->ModelMaster->getByCondition($where)->result_array();

        $this->load->view('target/export', $data);
    }
	
	public function prints(){
		require './application/libraries/fpdf.php';
		
		$where = ['id_target' => $this->uri->segment(3)];
		$query = $this->ModelMaster->getByCondition($where);
		$row = $query->row();
		
		$pdf = new FPDF();
		$pdf->AddPage('P', 'A4');
		$pdf->SetMargins(10,1,0);
		
		$pdf->Image('./assets/dist/img/header.png',2,0,206);
		$pdf->Ln(30);
		
		$pdf->SetFont('Arial','I',11);
		$pdf->Cell(190,6,date("d-M-Y"),0,1,"R");
		
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(30,6,"Nomor",0,0);
		$pdf->Cell(30,6,": ",0,1);
		// $pdf->Cell(30,6,": ".date("d/m/Y"),0,1);
		$pdf->Cell(30,6,"Lampiran",0,0);
		$pdf->Cell(30,6,": -",0,1);
		$pdf->Cell(30,6,"Perihal",0,0);
		$pdf->Cell(30,6,": Penyelesaian P2TL",0,1);
		$pdf->Cell(32,6,"",0,0);
		$pdf->Cell(30,6,"Surat ".$row->ket_status,0,1);
		$pdf->Ln(15);
		
		$pdf->Cell(30,6,"Dengan Hormat,",0,1);
		$pdf->MultiCell(190,6,"Berdasarkan Berita Acara Hasil Pemeriksaan Penertiban Pemakaian Tenaga Listrik (P2TL) Nomor : ".$row->noba_target.", dengan data  :",0,1);
		$pdf->Ln();
		
		$pdf->SetX(30);
		$pdf->Cell(40,6,"Nama Penghuni",0,0);
		$pdf->Cell(50,6,": ".$row->nama_pelanggan,0,1);
		$pdf->SetX(30);
		$pdf->Cell(40,6,"Alamat",0,0);
		$pdf->Cell(50,6,": ".$row->alamat_pelanggan,0,1);
		$pdf->SetX(30);
		$pdf->Cell(40,6,"Tarif",0,0);
		$pdf->Cell(50,6,": ".$row->tarif,0,1);
		$pdf->SetX(30);
		$pdf->Cell(40,6,"Daya Ketemuan",0,0);
		$pdf->Cell(50,6,": ".$row->daya,0,1);
		$pdf->Ln();
		
		$pdf->MultiCell(190,6,"Telah ditemukan pelanggaran yaitu menggunakan energi listrik tanpa alas hak yang sah.",0,1);
		$pdf->Ln(3);
		
		$pdf->MultiCell(190,6,"Kami menunggu kedatangan Tuan/Nyonya/Saudara-i di Kantor PT. XYZ ____________________ pada setiap jam 08.00 s/d 17.00 WIB, paling lambat 3(tiga) hari kerja sejak tanggal surat diatas untuk melakukan penyelesaian lebih lanjut.",0,1);
		$pdf->Ln(3);
		
		$pdf->MultiCell(190,6,"Demikian disampaikan atas perhatiaanya diucapkan terima kasih.",0,1);
		$pdf->Ln(20);
		
		$pdf->SetX(140);
		$pdf->Cell(40,6,"Manajer",0,0,"C");
		$pdf->Ln(30);
		$pdf->SetX(140);
		$pdf->Cell(40,6,"( ........................................... )",0,0,"C");
		$pdf->Ln(30);
		
		$pdf->SetFont('Arial','I',10);
		$pdf->Cell(30,5,"Petugas P2TL",0,0);
		$pdf->Cell(50,5,": ".$row->nama_user,0,1);
		$pdf->Cell(30,5,"Nomor BA P2TL",0,0);
		$pdf->Cell(50,5,": ".$row->noba_target,0,1);
		
		$pdf->SetY(-5);
		$pdf->Image('./assets/dist/img/footer.png',2,268,206);
		
		$pdf->Output('Surat Panggilan P2TL.pdf', 'I');
	}
}