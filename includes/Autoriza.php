<?php 
	session_start();
	if(!isset($_SESSION['nomina']) && !isset($_SESSION['usuario'])) header('Location: index.php');
	$user=$_SESSION['usuario'];
	include('connection.php');
	$folio=$_GET['folio'];
	$Squery="update tblRequisiciones set FechaAutorizo=getdate(), IdAutorizo=".$user." where Id=".$folio;
	$conn=Connection();
	$count = $conn->exec($Squery);
	echo $Squery;
	$conn=null;
	$stmt = null;
?>