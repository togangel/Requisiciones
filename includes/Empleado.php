<?php
	session_start();
	if(!isset($_SESSION['nomina']) && !isset($_SESSION['usuario'])) header('Location: index.php');
	include ('connection.php');
	$empleado=$_REQUEST["empleado"];
	$Squery="select E.ApPaterno+' '+E.ApMaterno+' '+E.Nombres Empleado from cEmpleados E where E.IdEstatus!=2 and E.NoNomina='".$empleado."' and E.EsOperador!=1";
	$conn=Connection();
	$stmt=$conn->query($Squery);
	if($row=$stmt->fetch(PDO::FETCH_ASSOC)) $Descripcion=$row['Empleado'];
	else $Descripcion="Empleado no encontrado";
	$conn=null;
	$stmt = null;
	echo $Descripcion;
?>