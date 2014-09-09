<?php 
	
	function Lista(){
		$Squery="select R.Id Folio, D.Descripcion Documento, T.Descripcion Taller, DP.Descripcion Departamento, convert(varchar, R.Fecha, 103) Fecha, R.Estatus, ";
		$Squery.="case isnull(FechaAutorizo, 0) when 0 then 0 else 1 end Autoriza ";
		$Squery.="from tblRequisiciones R ";
		$Squery.="inner join cTipoDeDocumento D on D.id=R.IdTipoDocumento ";
		$Squery.="inner join cTalleres T on T.id=R.IdTaller ";
		$Squery.="inner join cDepartamentos DP on DP.Id=R.IdArea ";
		$Squery.="where convert(varchar, getdate(), 103)=convert(varchar, R.Fecha, 103) and R.FechaRecibioAlmacen is null order by R.Estatus desc, R.Id";
		if(isset($_GET['fecha'])) $Squery.="convert(varchar, R.Fecha, 103)="fecha($_GET['fecha']);
		if(isset($_GET['fol'])) $Squery.="convert(varchar, R.Fecha, 103)="fecha($_GET['fecha']);
		if(isset($_GET['tall'])) $Squery.="convert(varchar, R.Fecha, 103)="fecha($_GET['fecha']);
		if(isset($_GET['estatus'])) $Squery.="convert(varchar, R.Fecha, 103)="fecha($_GET['fecha']);

		$conn=Connection();
		$stmt=$conn->query($Squery);
		$i=0;
		$val="<table>";
		$val.='<tr>';
		$val.='<td><strong>Folio</strong></td>';
		$val.='<td><strong>Documento</strong></td>';
		$val.='<td><strong>Taller</strong></td>';
		$val.='<td><strong>Departamento</strong></td>';
		$val.='<td><strong>Fecha</strong></td>';
		$val.='<td><strong>Estatus</strong></td>';
		$val.='<td></td>';
		$val.='<td></td>';
		$val.='</tr>';
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$val.='<tr>';
			$val.='<td>'.$row['Folio'].'</td>';
			$val.='<td>'.$row['Documento'].'</td>';
			$val.='<td>'.$row['Taller'].'</td>';
			$val.='<td>'.$row['Departamento'].'</td>';
			$val.='<td>'.$row['Fecha'].'</td>';
			if(($row['Estatus']=='0')) $val.='<td>Cancelado</td>';
			else if($row['Autoriza']=='1') $val.='<td>Autorizado</td>';
			else $val.='<td>Activo</td>'; 
			$val.='<td><button id="'.$row['Folio'].'" onclick="detalle(this.id);" class="edit">Detalle</button></td>';
			if($row['Estatus']=='1')
				$val.='<td><button id="'.$row['Folio'].'" onclick="eliminar(this.id);" class="edit">Cancelar</button></td>';
			else
				$val.='<td></td>';
			$val.='</tr>';
		}
		$val.="</table>";
		echo $val;
		$conn=null;
		$stmt = null;
	}

	function SQL(){
		$Squery="select R.Id Folio, D.Descripcion Documento, T.Descripcion Taller, DP.Descripcion Departamento, convert(varchar, R.Fecha, 103) Fecha, R.Estatus ";
		$Squery.="from tblRequisiciones R ";
		$Squery.="inner join cTipoDeDocumento D on D.id=R.IdTipoDocumento ";
		$Squery.="inner join cTalleres T on T.id=R.IdTaller ";
		$Squery.="inner join cDepartamentos DP on DP.Id=R.IdArea ";
		$Squery.="where R.FechaAutorizo is null and R.Estatus=1 order by R.Id";
		$conn=Connection();
		$stmt=$conn->query($Squery);
		$i=0;
		$val="<table>";
		$val.='<tr>';
		$val.='<td><strong>Folio</strong></td>';
		$val.='<td><strong>Documento</strong></td>';
		$val.='<td><strong>Taller</strong></td>';
		$val.='<td><strong>Departamento</strong></td>';
		$val.='<td><strong>Fecha</strong></td>';
		$val.='<td><strong>Estatus</strong></td>';
		$val.='<td></td>';
		$val.='<td></td>';
		$val.='</tr>';
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$val.='<tr>';
			$val.='<td>'.$row['Folio'].'</td>';
			$val.='<td>'.$row['Documento'].'</td>';
			$val.='<td>'.$row['Taller'].'</td>';
			$val.='<td>'.$row['Departamento'].'</td>';
			$val.='<td>'.$row['Fecha'].'</td>';
			if($row['Estatus']=='1') $val.='<td>Activo</td>';
			else $val.='<td>Cancelado</td>';
			$val.='<td><button id="'.$row['Folio'].'" onclick="detalles(this.id);" class="edit">Detalle</button></td>';
			if($row['Estatus']=='1')
				$val.='<td><button id="'.$row['Folio'].'" onclick="autorizar(this.id);" class="edit">Autorizar</button></td>';
			else
				$val.='<td></td>';
			$val.='</tr>';
		}
		$val.="</table>";
		echo $val;
		$conn=null;
		$stmt = null;
	}


?>