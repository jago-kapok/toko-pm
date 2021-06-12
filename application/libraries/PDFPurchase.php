<?php
require('fpdf.php');

class PDFPurchase extends FPDF {

    function __construct() {
        parent::__construct();
    }

    function Header(){
		$this->SetXY(5,5);
		$this->SetFont('Arial','B',15);
		$this->Cell(205, 6, 'PEMBELIAN / PURCHASE ORDER', 0, 2, 'C');
		$this->Ln();
	}
}
?>
