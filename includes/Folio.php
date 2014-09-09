<?php
	if(!isset($_SESSION['nomina']) && !isset($_SESSION['usuario'])) header('Location: index.php');
	if(isset($_GET['script'])) include ('connection.php');
	$Squery="select AÑO ano, FOLIO from FoliosSys2011 F where F.TABLA='tblRequisiciones'";
	$conn=Connection();
	$stmt=$conn->query($Squery);
	if($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		$ano=$row['ano'];
		echo $ano[2];
		echo $ano[3];
		echo (intval($row['FOLIO'])+1);
	}
	else{
		echo "error";
	}
	$conn=null;
	$stmt = null;
?>