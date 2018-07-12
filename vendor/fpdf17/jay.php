<?php
require('fpdf.php');

//echo "<pre>"; print_r($_SERVER); die();

function createpdf()
{
	$pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40,10,'Hello World!');
    $pdf->Output('test.pdf', 'D');
}

?>