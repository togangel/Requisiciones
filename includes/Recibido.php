<?php
	session_start();
	if(!isset($_SESSION['nomina']) && !isset($_SESSION['usuario'])) header('Location: index.php');
	include('connection.php');
	$folio=$_GET['folio'];
	$Squery="update tblRequisiciones set IdRecibeAlmacen=".$_SESSION['usuario'].", FechaRecibioAlmacen=getdate() where Id=".$folio;
	$conn=Connection();
	$count = $conn->exec($Squery);
	$conn=null;
	$stmt = null;
?>