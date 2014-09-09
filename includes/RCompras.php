<?php
	include ('Connection.php');
	session_start();
	if(!isset($_SESSION['nomina']) && !isset($_SESSION['usuario'])) header('Location: index.php');
	try{
		$tipo=$_POST['tipo'];
		if($tipo=='9'){
			compras();
		}
		else if($tipo=='10'){
			if(isset($_POST['subtipoval'])){
				$subtipo=$_POST['subtipoval'];
					servicios();
			}
		}
}
catch(PDOException $e)
    {
    echo '<script src="js/tabs.js">alert('.$e->getMessage().');</script>';
    }

    function compras(){
    	$folio=folios();
	$taller=$_POST['ctaller'];
	$departamento=$_POST['departamento'];
	$solicitante=$_POST['solicitante'];
	$observaciones=$_POST['cobservaciones'];
	$user=$_SESSION['usuario'];
	$sql="insert into tblRequisiciones (Id, IdTipoDocumento, Fecha, IdTaller, IdArea, IdSolicita, Estatus, IdUsuarioReg, FechaReg, Observaciones) ";
	$sql.="values(".$folio.", 9, getdate(), ".$taller.", ".$departamento.", (select E.Id from cEmpleados E where E.NoNomina='".$solicitante."'), 1, ";
	$sql.=$user.", getdate(), '".$observaciones."')";
	echo $sql."<br><br>";
	$conn=Connection();
	$count = $conn->exec($sql);
	for($i=0; $i<200; $i++){
		if(isset($_POST['detunidad'.$i]) and isset($_POST['articulo'.$i]) and isset($_POST['noparte'.$i])){
		if(isset($_POST['cantidad'.$i]) and isset($_POST['prioridad'.$i])){
			$unidad=$_POST['detunidad'.$i];
			$descripcion=$_POST['articulo'.$i];
			$cantidad=$_POST['cantidad'.$i];
			$noparte=$_POST['noparte'.$i];
			$prioridad=$_POST['prioridad'.$i];
			$sqldet="insert into tblRequisicionesDet ";
			$sqldet.="(id, IdRequisicion, IdTipo, idUnidad, IdEstatusUnidad, IdDescripcion, Cantidad, NoDeParte, Prioridad, Estatus, IdUsuarioReg, FechaReg) ";
			$sqldet.="values(".foliodet().", ".$folio.", 1, (select Id from cUnidades U where U.NoEconomico='".$unidad."'), (select IdEstatus from cUnidades U where U.NoEconomico='".$unidad."'), ";
			$sqldet.="".$descripcion.", ".$cantidad.", '".$noparte."', ".$prioridad.", 1, ".$user.", GETDATE())";
			echo $sqldet;
			$count = $conn->exec($sqldet);
		}}
	}
	echo'<script>alert("Guardado correcto");location="../Principal.php";</script>';
    }

    function servicios(){

    	$folio=folios();
    	$subtipo=$_POST['subtipoval'];
		$taller=$_POST['ctaller'];
		$departamento=$_POST['departamento'];
		$solicitante=$_POST['solicitante'];
		$observaciones=$_POST['cobservaciones'];
		$unidad=$_POST['unidad'];
		$user=$_SESSION['usuario'];
		$sql="insert into tblRequisiciones (Id, IdTipoDocumento, Fecha, IdTaller, IdArea, IdSolicita, Estatus, IdUsuarioReg, FechaReg, Observaciones, idUnidad, IdEstatusUnidad) ";
		$sql.="values(".$folio.", 10, getdate(), ".$taller.", ".$departamento.", (select E.Id from cEmpleados E where E.NoNomina='".$solicitante."'), 1, ";
		$sql.=$user.", getdate(), '".$observaciones."', (select Id from cUnidades U where U.NoEconomico='".$unidad."'), (select IdEstatus from cUnidades U where U.NoEconomico='".$unidad."'))";
		$conn=Connection();
		$count = $conn->exec($sql);
		for($i=0; $i<200; $i++){
			if(isset($_POST['servicio'.$i])){
				$descripcion=$_POST['servicio'.$i];
				$sqldet="insert into tblRequisicionesDet ";
				$sqldet.="(id, IdRequisicion, IdTipo, IdDescripcion, Estatus, IdUsuarioReg, FechaReg) ";
				$sqldet.="values(".foliodet().", ".$folio.", 1, ".$descripcion.", 1, ".$user.", GETDATE())";
				$count = $conn->exec($sqldet);
		}
		else if(isset($_POST['articulo'.$i]) and isset($_POST['noparte'.$i])){
		if(isset($_POST['cantidad'.$i])){
			$descripcion=$_POST['articulo'.$i];
			$cantidad=$_POST['cantidad'.$i];
			$noparte=$_POST['noparte'.$i];
			$sqldet="insert into tblRequisicionesDet ";
			$sqldet.="(id, IdRequisicion, IdTipo, IdDescripcion, Cantidad, NoDeParte, Estatus, IdUsuarioReg, FechaReg) ";
			$sqldet.="values(".foliodet().", ".$folio.", 2, ";
			$sqldet.="".$descripcion.", ".$cantidad.", '".$noparte."', 1, ".$user.", GETDATE())";
			$count = $conn->exec($sqldet);
		}
	}
	echo'<script>alert("Guardado correcto");location="../Principal.php";</script>';
    }

    function compras2(){
    	$folio=folios();
	$taller=$_POST['ctaller'];
	$departamento=$_POST['departamento'];
	$solicitante=$_POST['solicitante'];
	$observaciones=$_POST['cobservaciones'];
	$unidad=$_POST['unidad'];
	$user=$_SESSION['usuario'];
	$sql="insert into tblRequisiciones (Id, IdTipoDocumento, Fecha, IdTaller, IdArea, IdSolicita, Estatus, IdUsuarioReg, FechaReg, Observaciones, idUnidad, IdEstatusUnidad) ";
	$sql.="values(".$folio.", 10, getdate(), ".$taller.", ".$departamento.", (select E.Id from cEmpleados E where E.NoNomina='".$solicitante."'), 1, ";
	$sql.=$user.", getdate(), '".$observaciones."', (select Id from cUnidades U where U.NoEconomico='".$unidad."'), (select IdEstatus from cUnidades U where U.NoEconomico='".$unidad."'))";
	$conn=Connection();
	$count = $conn->exec($sql);
	for($i=0; $i<200; $i++){
		
	}
	}
	echo'<script>alert("Guardado correcto");location="../Principal.php";</script>';
    }


    function folios(){
    	$Squery="select AÑO ano, FOLIO from FoliosSys2011 F where F.TABLA='tblRequisiciones'";
	$conn=Connection();
	$stmt=$conn->query($Squery);
	if($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		$ano=$row['ano'];
		$Squery="update FoliosSys2011 set Folio=".(intval($row['FOLIO'])+1)." where TABLA='tblRequisiciones'";
		$count = $conn->exec($Squery);
		return $ano[2].$ano[3].(intval($row['FOLIO'])+1);
	}
    }

    function foliodet(){
    	$Squery="select AÑO ano, FOLIO from FoliosSys2011 F where F.TABLA='tblRequisicionesDet'";
	$conn=Connection();
	$stmt=$conn->query($Squery);
	if($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		$ano=$row['ano'];
		$Squery="update FoliosSys2011 set Folio=".(intval($row['FOLIO'])+1)." where TABLA='tblRequisicionesDet'";
		$count = $conn->exec($Squery);
		return $ano[2].$ano[3].(intval($row['FOLIO'])+1);
	}
    }
?>