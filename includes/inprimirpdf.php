<?php 
	session_start();
	if(!isset($_SESSION['nomina']) && !isset($_SESSION['usuario'])) header('Location: index.php');
	header('Content-Type: text/html; charset=UTF-8');
	include_once('fpdf17/fpdf.php');
	include('Connection.php');

	function Tipo($folio){
		$Squery="select IdTipoDocumento from tblRequisiciones R where R.Id=".$folio;
		$conn=Connection();
		$val="";
		$stmt=$conn->query($Squery);
		if($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			switch($row['IdTipoDocumento']){
				case '9':
					$val="Requisicion de Compra";
				break;
				case '10':
					$val="Requisicion de Servicio";
				break;
			}
		}
		$conn=null;
		$stmt = null;
		return $val;
	}

	function compras($folio, $pdf){
		$Squery="select T.Descripcion Taller, DP.Descripcion Departamento, convert(varchar, R.Fecha, 103) Fecha, R.Observaciones, ";
		$Squery.="isnull(E.ApPaterno+' '+E.ApMaterno+' '+E.Nombres, '') Solicita, ";
		$Squery.="isnull(E2.ApPaterno+' '+E2.ApMaterno+' '+E2.Nombres, '') Autoriza, ";
		$Squery.="isnull(E3.ApPaterno+' '+E3.ApMaterno+' '+E3.Nombres, '') Recibe ";
		$Squery.="from tblRequisiciones R ";
		$Squery.="inner join cTalleres T on T.id=R.IdTaller ";
		$Squery.="inner join cDepartamentos DP on DP.Id=R.IdArea ";
		$Squery.="left join cEmpleados E on E.Id=R.IdSolicitante ";
		$Squery.="left join cEmpleados E2 on E2.Id=R.IdAutorizo ";
		$Squery.="left join cEmpleados E3 on E3.Id=R.IdRecibeAlmacen ";
		$Squery.="where R.Id=".$folio;
		$conn=Connection();
		$stmt=$conn->query($Squery);
		$Observaciones="";
		$Solicita="";
		$Autoriza="";
		$Recibe="";
		if($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$pdf->Cell(25,10,"Fecha: ".$row['Fecha'],0,0, 'L');
			$pdf->Cell(55,10,"Taller: ".$row['Taller'],0,0, 'L');
			$pdf->Cell(55,10,"Area: ".$row['Departamento'],0,0, 'L');
			$pdf->Cell(55,10,"Tipo de mantenimiento: ",0,1, 'L');
			$Observaciones=$row['Observaciones'];
			$Solicita=$row['Solicita'];
			$Autoriza=$row['Autoriza'];
			$Recibe=$row['Recibe'];
		}
		$conn=null;
		$stmt = null;
		$Squery="select RD.Id, 'Refaccion' Tipo, A.Descripcion A, U.NoEconomico, E.Descripcion, RD.NoDeParte, RD.Cantidad, RD.Prioridad ";
		$Squery.="from tblRequisicionesDet RD ";
		$Squery.="left join cUnidades U on U.Id=RD.IdUnidad ";
		$Squery.="left join cEstatus E on E.Id=RD.IdEstatusUnidad ";
		$Squery.="inner join cArticulos A on A.Id=RD.IdDescripcion ";
		$Squery.="where RD.IdRequisicion=".$folio;
		$conn=Connection();
		$stmt=$conn->query($Squery);
		$pdf->Cell(12,10,'Id',1,0, 'C');
		$pdf->Cell(13,10,'Tipo',1,0, 'C');
		$pdf->Cell(90,10,'Descripcion',1,0, 'C');
		$pdf->Cell(10,10,'Unidad',1,0, 'C');
		$pdf->Cell(30,10,'Estatus Unidad',1,0, 'C');
		$pdf->Cell(15,10,'No.Parte',1,0, 'C');
		$pdf->Cell(12,10,'Cantidad',1,0, 'C');
		$pdf->Cell(12,10,'Prioridad',1,1, 'C');
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$pdf->Cell(12,10,$row['Id'],1,0, 'C');
			$pdf->Cell(13,10,$row['Tipo'],1,0, 'C');
			$pdf->Cell(90,10,$row['A'],1,0, 'C');
			$pdf->Cell(10,10,$row['NoEconomico'],1,0, 'C');
			$pdf->Cell(30,10,$row['Descripcion'],1,0, 'C');
			$pdf->Cell(15,10,$row['NoDeParte'],1,0, 'C');
			$pdf->Cell(12,10,$row['Cantidad'],1,0, 'C');
			$pdf->Cell(12,10,$row['Prioridad'],1,1, 'C');
		}
		$pdf->Ln(5);
		$pdf->Cell(170,5, 'Observaciones:',0,1, 'L');
		$pdf->Cell(194,15, $Observaciones,1,1, 'L');
		$pdf->Ln(3);
		$pdf->Cell(60,5, 'Solicitante',1,0, 'C');
		$pdf->Cell(7,5, '',0,0, 'L');
		$pdf->Cell(60,5, 'Autorizacion',1,0, 'C');
		$pdf->Cell(7,5, '',0,0, 'L');
		$pdf->Cell(60,5, 'Almacen-Recibido',1,1, 'C');
		$pdf->Cell(60,20, $Solicita,1,0, 'C');
		$pdf->Cell(7,20, '',0,0, 'L');
		$pdf->Cell(60,20, $Autoriza,1,0, 'C');
		$pdf->Cell(7,20, '',0,0, 'L');
		$pdf->Cell(60,20, $Recibe,1,1, 'C');
		$pdf->Cell(60,5, 'Firma',1,0, 'C');
		$pdf->Cell(7,5, '',0,0, 'L');
		$pdf->Cell(60,5, 'Firma',1,0, 'C');
		$pdf->Cell(7,5, '',0,0, 'L');
		$pdf->Cell(60,5, 'Firma',1,1, 'C');
		$conn=null;
		$stmt = null;
	}

	function servicio($folio, $pdf){
		$Squery="select T.Descripcion Taller, DP.Descripcion Departamento, convert(varchar, R.Fecha, 103) Fecha, R.Observaciones, ";
		$Squery.="isnull(E.ApPaterno+' '+E.ApMaterno+' '+E.Nombres, '') Solicita, ";
		$Squery.="isnull(E2.ApPaterno+' '+E2.ApMaterno+' '+E2.Nombres, '') Autoriza, ";
		$Squery.="isnull(E3.ApPaterno+' '+E3.ApMaterno+' '+E3.Nombres, '') Recibe, ";
		$Squery.="U.NoEconomico, Es.Descripcion ";
		$Squery.="from tblRequisiciones R ";
		$Squery.="inner join cTalleres T on T.id=R.IdTaller ";
		$Squery.="inner join cDepartamentos DP on DP.Id=R.IdArea ";
		$Squery.="inner join cUnidades U on U.Id=R.IdUnidad ";
		$Squery.="inner join cEstatus Es on Es.Id=R.IdEstatusUnidad ";
		$Squery.="left join cEmpleados E on E.Id=R.IdSolicitante ";
		$Squery.="left join cEmpleados E2 on E2.Id=R.IdAutorizo ";
		$Squery.="left join cEmpleados E3 on E3.Id=R.IdRecibeAlmacen ";
		$Squery.="where R.Id=".$folio;
		$conn=Connection();
		$stmt=$conn->query($Squery);
		$Observaciones="";
		$Solicita="";
		$Autoriza="";
		$Recibe="";
		$unidad="";
		$Descripcion="";
		if($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$pdf->Cell(25,10,"Fecha: ".$row['Fecha'],0,0, 'L');
			$pdf->Cell(55,10,"Taller: ".$row['Taller'],0,0, 'L');
			$pdf->Cell(55,10,"Area: ".$row['Departamento'],0,0, 'L');
			$pdf->Cell(55,10,"Unidad: ".$row['NoEconomico'],0,1, 'L');
			$pdf->Cell(55,10,"Estatus Unidad: ".$row['Descripcion'],0,0, 'L');
			$pdf->Cell(55,10,"Tipo de mantenimiento: ",0,1, 'L');
			$Observaciones=$row['Observaciones'];
			$Solicita=$row['Solicita'];
			$Autoriza=$row['Autoriza'];
			$Recibe=$row['Recibe'];
		}
		$conn=null;
		$stmt = null;
		$Squery="select RD.Id, 'Servicio' Tipo, A.Descripcion ";
		$Squery.="from tblRequisicionesDet RD ";
		$Squery.="inner join Cat_ServiciosExternos A on A.Id=RD.IdDescripcion ";
		$Squery.="where RD.idtipo=1 and RD.IdRequisicion=".$folio;
		$conn=Connection();
		$stmt=$conn->query($Squery);
		$i=0;
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			if($i==0){
				$pdf->Cell(194,10,"Servicios",1,1, 'C');
				$pdf->Cell(12,10,'Id',1,0, 'C');
				$pdf->Cell(13,10,'Tipo',1,0, 'C');
				$pdf->Cell(169,10,'Descripcion',1,1, 'C');
				$i++;
			}
			$pdf->Cell(12,10,$row['Id'],1,0, 'C');
			$pdf->Cell(13,10,$row['Tipo'],1,0, 'C');
			$pdf->Cell(169,10,$row['Descripcion'],1,1, 'C');
		}
		$pdf->Ln(5);
		$Squery="select RD.Id, 'Refaccion' Tipo, A.Descripcion, RD.NoDeParte, RD.Cantidad ";
		$Squery.="from tblRequisicionesDet RD ";
		$Squery.="inner join cArticulos A on A.Id=RD.IdDescripcion ";
		$Squery.="where RD.idtipo=2 and RD.IdRequisicion=".$folio;
		$conn=Connection();
		$stmt=$conn->query($Squery);
		$i=0;
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			if($i==0){
				$pdf->Cell(194,10,"Refacciones",1,1, 'C');
				$pdf->Cell(12,10,'Id',1,0, 'C');
				$pdf->Cell(13,10,'Tipo',1,0, 'C');
				$pdf->Cell(142,10,'Descripcion',1,0, 'C');
				$pdf->Cell(15,10,'No.Parte',1,0, 'C');
				$pdf->Cell(12,10,'Cantidad',1,1, 'C');
				$i++;
			}
			$pdf->Cell(12,10,$row['Id'],1,0, 'C');
			$pdf->Cell(13,10,$row['Tipo'],1,0, 'C');
			$pdf->Cell(142,10,$row['Descripcion'],1,0, 'C');
			$pdf->Cell(15,10,$row['NoDeParte'],1,0, 'C');
			$pdf->Cell(12,10,$row['Cantidad'],1,1, 'C');
		}
		$pdf->Ln(5);
		$pdf->Cell(170,5, 'Observaciones:',0,1, 'L');
		$pdf->Cell(194,15, $Observaciones,1,1, 'L');
		$pdf->Ln(3);
		$pdf->Cell(60,5, 'Solicitante',1,0, 'C');
		$pdf->Cell(7,5, '',0,0, 'L');
		$pdf->Cell(60,5, 'Autorizacion',1,0, 'C');
		$pdf->Cell(7,5, '',0,0, 'L');
		$pdf->Cell(60,5, 'Almacen-Recibido',1,1, 'C');
		$pdf->Cell(60,20, $Solicita,1,0, 'C');
		$pdf->Cell(7,20, '',0,0, 'L');
		$pdf->Cell(60,20, $Autoriza,1,0, 'C');
		$pdf->Cell(7,20, '',0,0, 'L');
		$pdf->Cell(60,20, $Recibe,1,1, 'C');
		$pdf->Cell(60,5, 'Firma',1,0, 'C');
		$pdf->Cell(7,5, '',0,0, 'L');
		$pdf->Cell(60,5, 'Firma',1,0, 'C');
		$pdf->Cell(7,5, '',0,0, 'L');
		$pdf->Cell(60,5, 'Firma',1,1, 'C');
		$conn=null;
		$stmt = null;
	}

	class PDF extends FPDF{
		function Header(){
			$this->Image('../img/logo.png',3,3,30);
			$this->SetFont('Arial','B',15);
			$this->Cell(40);
			$this->Cell(50,10, Tipo($_GET['folio']),0,0,'C');
			$this->Ln(0);
		}
	}

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','',8);
	$pdf->Cell(180,10,'Folio: '.$_GET['folio'],0,1, 'R');
	$pdf->Ln(5);
	$Squery="select IdTipoDocumento from tblRequisiciones R where R.Id=".$_GET['folio'];
	$conn=Connection();
	$stmt=$conn->query($Squery);
	if($row=$stmt->fetch(PDO::FETCH_ASSOC)){ 
		$val=$row['IdTipoDocumento'];
		if($val=='9')
		compras($_GET['folio'], $pdf);
		else{
			servicio($_GET['folio'], $pdf);
		}
	}
	$pdf->Output();
?>