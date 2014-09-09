<?php
	include ('connection.php');
	$Squery="select Id, Descripcion from Cat_ServiciosExternos A where A.Estatus=1 order by 2";
	$conn=Connection();
	$stmt=$conn->query($Squery);
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$row['Id'].'">'.$row['Descripcion'].'</option>';
	}
	$conn=null;
	$stmt = null;
?>