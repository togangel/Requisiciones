<?php 
	function ListaR(){
		$Squery="select R.Id Folio, D.Descripcion Documento, T.Descripcion Taller, DP.Descripcion Departamento, convert(varchar, R.Fecha, 103) Fecha, R.Estatus, ";
		$Squery.="case isnull(FechaAutorizo, 0) when 0 then 0 else 1 end Autoriza, case isnull(FechaRecibioAlmacen, 0) when 0 then 0 else 1 end Recibido, ";
		$Squery.="convert(varchar, R.FechaAutorizo, 103) FechaAutoriza, convert(varchar, R.FechaRecibioAlmacen, 103) FechaRecibido ";
		$Squery.="from tblRequisiciones R ";
		$Squery.="inner join cTipoDeDocumento D on D.id=R.IdTipoDocumento ";
		$Squery.="inner join cTalleres T on T.id=R.IdTaller ";
		$Squery.="inner join cDepartamentos DP on DP.Id=R.IdArea ";
		$Squery.="order by R.Estatus desc, R.Id";
		$conn5=Connection();
		$stmt5=$conn5->query($Squery);
		$i=0;
		$val="<table>";
		$val.='<tr>';
		$val.='<td><strong>Folio</strong></td>';
		$val.='<td><strong>Documento</strong></td>';
		$val.='<td><strong>Taller</strong></td>';
		$val.='<td><strong>Departamento</strong></td>';
		$val.='<td><strong>Fecha</strong></td>';
		$val.='<td><strong>Fecha Autorizado</strong></td>';
		$val.='<td><strong>Fecha Recibido</strong></td>';
		$val.='<td><strong>Estatus</strong></td>';
		$val.='<td><strong>Estatus</strong></td>';
		$val.='</tr>';
		while($row5=$stmt5->fetch(PDO::FETCH_ASSOC)){
			$val.='<tr id="'.$row5['Folio'].'" onclick="detallelista(this.id);">';
			$val.='<td>'.$row5['Folio'].'</td>';
			$val.='<td>'.$row5['Documento'].'</td>';
			$val.='<td>'.$row5['Taller'].'</td>';
			$val.='<td>'.$row5['Departamento'].'</td>';
			$val.='<td>'.$row5['Fecha'].'</td>';
			$val.='<td>'.$row5['FechaAutoriza'].'</td>';
			$val.='<td>'.$row5['FechaRecibido'].'</td>';
			if($row5['Estatus']=='0') $val.='<td>Cancelado</td>';
			else if($row5['Recibido']=='1') $val.='<td>Recibido</td>';
			else if($row5['Autoriza']=='1') $val.='<td>Autorizado</td>';
			else $val.='<td>Activo</td>'; 
			$val.='<td><button   class="edit">Detalle</button></td>';
			$val.='</tr>';
		}
		$val.="</table>";
		echo $val;
		$conn=null;
		$stmt = null;
	}
?>
 
<script type="text/javascript">
	function detallelista(id) {
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById('detallelista').innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","includes/detalleR.php?folio="+id,true);
		xmlhttp.send();
	}
</script>

<style type="text/css">
	#recibe{
		width: 100%;
		height: auto;
		height: 400px;
		overflow: auto;
		margin-bottom: 20px;
		border: solid black 1px;
		border-radius: 5px;
	}
	#recibe table{
	margin: 0 auto;
	}

	#recibe ul{
		list-style:none;
		border-radius: 5px;
	}

	#recibe table tr{
		width: 100%;
		margin: auto;
		border-radius: 5px;
		height: 40px;
		text-align: center;
	}
	#recibe table tr td{
		width: 120px;
	}

	#recibe table tr:nth-child(odd){
		background: #f1f1f1;
}

#recibe table tr:nth-child(even){
background: #fff;
}

#detallelista{
	padding-top:20px;
	width: 100%;
	height: 300px;
	border:solid 1px black;
	border-radius: 5px;
	overflow: auto;
}

#detallelista table{
	width: 90%;
	border-radius: 5px;
	margin: 0 auto;
	margin-bottom: 10px;
}
#detallelista table td{
	width: 100px;

		height: 40px;
	text-align: center;

}

#detallelista table tr:nth-child(odd){
		background: #f1f1f1;
}

#detallelista table tr:nth-child(even){
background: #fff;
}

</style>
<div id="recibe">
	<?php ListaR();?>
</div>
<div id="detallelista">
</div>