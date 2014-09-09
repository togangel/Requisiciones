<?php
	include('connection.php');
	session_start();
	if(!isset($_SESSION['nomina']) && !isset($_SESSION['usuario'])) header('Location: index.php');
	function compras($folio){
		$Squery="select RD.Id, 'Compra' Tipo, A.Descripcion A, U.NoEconomico, E.Descripcion, RD.NoDeParte, RD.Cantidad, RD.Prioridad ";
		$Squery.="from tblRequisicionesDet RD ";
		$Squery.="left join cUnidades U on U.Id=RD.IdUnidad ";
		$Squery.="left join cEstatus E on E.Id=RD.IdEstatusUnidad ";
		$Squery.="inner join cArticulos A on A.Id=RD.IdDescripcion ";
		$Squery.="where RD.IdRequisicion=".$folio;
		$conn=Connection();
		$stmt=$conn->query($Squery);
		$i=0;
		$val="<table>";
		$val.='<tr><td><strong>Compras</strong></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
		$val.='<tr>';
		$val.='<td><strong>Id</strong></td>';
		$val.='<td><strong>Tipo</strong></td>';
		$val.='<td><strong>Descripcion</strong></td>';
		$val.='<td><strong>Unidad</strong></td>';
		$val.='<td><strong>Estatus Unidad</strong></td>';
		$val.='<td><strong>No.Parte</strong></td>';
		$val.='<td><strong>Cantidad</strong></td>';
		$val.='<td><strong>Prioridad</strong></td>';
		$val.='</tr>';
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$val.='<tr>';
			$val.='<td>'.$row['Id'].'</td>';
			$val.='<td>'.$row['Tipo'].'</td>';
			$val.='<td>'.$row['A'].'</td>';
			$val.='<td>'.$row['NoEconomico'].'</td>';
			$val.='<td>'.$row['Descripcion'].'</td>';
			$val.='<td>'.$row['NoDeParte'].'</td>';
			$val.='<td>'.$row['Cantidad'].'</td>';
			$val.='<td>'.$row['Prioridad'].'</td>';
			$val.='</tr>';
		}
		$val.="</table>";
		echo $val;
		$conn=null;
		$stmt = null;
	}


	function servicio($folio){
		$Squery="select RD.Id, 'Servicio' Tipo, A.Descripcion ";
		$Squery.="from tblRequisicionesDet RD ";
		$Squery.="inner join Cat_ServiciosExternos A on A.Id=RD.IdDescripcion ";
		$Squery.="where RD.idtipo=1 and RD.IdRequisicion=".$folio;
		$conn=Connection();
		$val="<table>";
		$stmt=$conn->query($Squery);
		$i=0;
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			if($i==0){
				$val.='<tr><td colspan="1"><strong>Servicios</strong></td><td></td><td></td></tr>';
				$val.='<tr>';
				$val.='<td><strong>Id</strong></td>';
				$val.='<td><strong>Tipo</strong></td>';
				$val.='<td><strong>Descripcion</strong></td>';
				$val.='</tr>';
				$i++;
			}
			$val.='<tr>';
			$val.='<td>'.$row['Id'].'</td>';
			$val.='<td>'.$row['Tipo'].'</td>';
			$val.='<td>'.$row['Descripcion'].'</td>';
			$val.='</tr>';
		}
		$conn=null;
		$stmt = null;

		$Squery="select RD.Id, 'Refaccion' Tipo, A.Descripcion, RD.NoDeParte, RD.Cantidad ";
		$Squery.="from tblRequisicionesDet RD ";
		$Squery.="inner join cArticulos A on A.Id=RD.IdDescripcion ";
		$Squery.="where RD.idtipo=2 and RD.IdRequisicion=".$folio;
		$conn=Connection();
		$stmt=$conn->query($Squery);
		$i=0;
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			if($i==0){
				$val.='<tr><td><strong>Refacciones</strong></td><td></td><td></td><td></td><td></td></tr>';
				$val.='<tr>';
				$val.='<td><strong>Id</strong></td>';
				$val.='<td><strong>Tipo</strong></td>';
				$val.='<td><strong>Descripcion</strong></td>';
				$val.='<td><strong>No.Parte</strong></td>';
				$val.='<td><strong>Cantidad</strong></td>';
				$val.='</tr>';
				$i++;
			}
			$val.='<tr>';
			$val.='<td>'.$row['Id'].'</td>';
			$val.='<td>'.$row['Tipo'].'</td>';
			$val.='<td>'.$row['Descripcion'].'</td>';
			$val.='<td>'.$row['NoDeParte'].'</td>';
			$val.='<td>'.$row['Cantidad'].'</td>';
			$val.='</tr>';
		}
		$val.="</table>";
		echo $val;
		$conn=null;
		$stmt = null;
	}

	$folio=$_GET['folio'];
	$Squery="select IdTipoDocumento from tblRequisiciones R where R.Id=".$folio;
	$conn=Connection();
	$stmt=$conn->query($Squery);
	if($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		$val=$row['IdTipoDocumento'];
		if($val=='9')
			compras($folio);
		else
			servicio($folio);
	}
	echo '<button class="imprimir" id="'.$folio.'" onclick="imprimir(this.id);">Imprimir</button>';
?>