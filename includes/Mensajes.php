<?php
	include_once 'Connection.php';
	if(!isset($_SESSION['nomina'])){
		header('Location: ../index.php');
	}
	$Squery="select E.ApPaterno+' '+E.ApMaterno+' '+E.Nombres Nombre, A.Descripcion, convert(varchar, A.FechaEnviado, 103) Fecha ";
	$Squery.="from cAndroid_Users AU ";
	$Squery.="inner join cEmpleados E on E.NoNomina=AU.Nomina and E.NoNomina=".$_SESSION['nomina']." ";
	$Squery.="inner join cAndroid_AsignacionAvisos AA on AA.idUsuario=AU.id ";
	$Squery.="inner join cAndroid_Avisos A on A.idTipoAviso=AA.idTipoAviso ";
	$conn=Connection();
	$stmt=$conn->query($Squery);
	echo "Mensajes<br>";
	$rol=true;
	echo "<table>";
	echo "<tr><td><strong>Fecha de envio: </strong></td><td><strong>Mensaje:</strong></td></tr>";
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		if($rol) {echo $row['Nombre']."<br><br><br>";$rol=false;}
		echo "<tr><td>".$row['Fecha']."</td><td> ".$row['Descripcion']."</td></tr>";
	}
	echo "</table>";
	$conn=null;
	$stmt = null;
?>