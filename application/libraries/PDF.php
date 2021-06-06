<?php
require('fpdf.php');

class PDF extends FPDF {

    function __construct() {
        parent::__construct();
    }

    function Header(){
		$this->SetXY(5,5);
		$this->SetFont('Arial','B',18);
		$this->Cell(169, 6, 'PANDU MULYA', 0, 2, 'L');

		$this->SetFont('Arial','I',10);
		$this->Cell(169, 5, 'Jalan Guyangan - Berbek, Gandu', 0, 2, 'L');
		$this->Cell(169, 5, 'Bagor - Nganjuk', 0, 2, 'L');
		$this->Cell(169, 5, 'Telp. 0822 2933 2933', 0, 2, 'L');
		
		$this->Line(5, 33, 205, 33);
		$this->Line(5, 34, 205, 34);
		$this->Ln();
	}

	function Footer()
	{
		$this->SetY(-12);
		$this->SetFont('Arial','I',8);

		$this->Line(5, 277, 205, 277);
		$this->Cell(12, 4, "* Pembayaran bisa dilakukan secara cash maupun transfer.", 0, 1);
		$this->Cell(12, 4, "** Untuk informasi lebih lanjut, silakan menghubungi nomor yang tertera.", 0, 1);
	}
}
?>