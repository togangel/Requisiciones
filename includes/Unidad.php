<?php
	include ('connection.php');
	$unidad=$_REQUEST["unidad"];
	$Squery="select E.Id, E.Descripcion from cUnidades U inner join cEstatus E on E.Id=U.IdEstatus where U.NoEconomico='".$unidad."'";
	$conn=Connection();
	$stmt=$conn->query($Squery);
	if($row=$stmt->fetch(PDO::FETCH_ASSOC))
		$Descripcion=$row['Descripcion'];
	else $Descripcion="";
	$conn=null;
	$stmt = null;
	echo $Descripcion;
?>