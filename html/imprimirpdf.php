<?php 
session_start();
	if(!isset($_SESSION['nomina']) && !isset($_SESSION['usuario'])) header('Location: index.php');
include_once('fpdf.php'); 


$pdf = new FPDF(); 
$pdf->AddPage(); 
$pdf->SetFont('Arial','B',16); 
$pdf->Cell(40,10,'¡Hola, Mundo!'); 
$pdf->Output(); 
?> 