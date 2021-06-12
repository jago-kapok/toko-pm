<?php
require('fpdf.php');

class PDFReport extends FPDF {

    function __construct() {
        parent::__construct();
    }

    function Header(){
		$this->SetXY(5,5);
		$this->SetFont('Arial','B',15);
		$this->Cell(200, 6, 'LAPORAN '.$_SESSION['report_title'], 0, 2, 'C');

		$this->SetFont('Arial','I',8);
		$this->Cell(100, 5, 'Periode : '.date('d M Y', strtotime($_SESSION['start_date'])) .' - '.date('d M Y', strtotime($_SESSION['to_date'])), 0, 1, 'L');
		
		$this->Line(5, $this->getY(), 205, $this->getY());
		$this->Line(5, $this->getY() + 0.5, 205, $this->getY() + 0.5);
	}

	function Footer()
	{
		$this->SetY(-12);
		$this->SetFont('Arial','I',7);

		$this->Line(5, $this->getY() - 1, 210, $this->getY() - 1);
		$this->Cell(3, 3, "*", 0, 0, 'R');
		$this->Cell(5, 3, "Kekeliruan barang, segera memberitahu maksimal 3 hari setelah barang diterima.", 0, 1);
		
		$this->Cell(3, 3, "**", 0, 0, 'R');
		$this->Cell(5, 3, "Retur atau potong nota, harus persetujuan sales / kantor.", 0, 1);
		
		$this->Cell(3, 3, "***", 0, 0, 'R');
		$this->Cell(5, 3, "Kehilangan barang di ekspedisi, bukan tanggungjawab kami.", 0, 1);
	}
}
?>
