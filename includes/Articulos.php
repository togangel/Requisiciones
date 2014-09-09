<?php
	session_start();
	if(!isset($_SESSION['nomina']) && !isset($_SESSION['usuario'])) header('Location: index.php');
	include ('connection.php');
	$Squery="select Id, Descripcion from cArticulos A where A.Estatus=1 order by 2";
	$conn=Connection();
	$stmt=$conn->query($Squery);
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$row['Id'].'">'.$row['Descripcion'].'</option>';
	}
	$conn=null;
	$stmt = null;
?>