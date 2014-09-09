<?php 
	function Recibe(){
		$Squery="select R.Id Folio, D.Descripcion Documento, T.Descripcion Taller, DP.Descripcion Departamento, convert(varchar, R.Fecha, 103) Fecha, R.Estatus ";
		$Squery.="from tblRequisiciones R ";
		$Squery.="inner join cTipoDeDocumento D on D.id=R.IdTipoDocumento ";
		$Squery.="inner join cTalleres T on T.id=R.IdTaller ";
		$Squery.="inner join cDepartamentos DP on DP.Id=R.IdArea ";
		$Squery.="where not R.FechaAutorizo is null and R.FechaRecibioAlmacen is null and R.Estatus=1 order by R.Id";
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
			$val.='<td><button id="'.$row['Folio'].'" onclick="detallerecibe(this.id);" class="edit">Detalle</button></td>';
			if($row['Estatus']=='1')
				$val.='<td><button id="'.$row['Folio'].'" onclick="recibe(this.id);" class="edit">Recibir</button></td>';
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
 
<script type="text/javascript">
	function recibe(id){
		var confirma=confirm('Autorizar Requisicion con folio: '+id);
		if(confirma==true){
			var xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function(){
				if(xmlhttp.readyState==4 && xmlhttp.status==200){
					location="Principal.php";
				}
			}
			xmlhttp.open("GET","includes/Recibido.php?folio="+id,true);
			xmlhttp.send();
		}
	}

	function detallerecibe(id) {
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById('detallerecibe').innerHTML=xmlhttp.responseText;
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
		width: 98%;
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

#detallerecibe{
	padding-top:20px;
	width: 100%;
	height: 300px;
	border:solid 1px black;
	border-radius: 5px;
	overflow: auto;
}

#detallerecibe table{
	width: 100%;
	border-radius: 5px;
	margin: 0 auto;
	margin-bottom: 10px;
}
#detallerecibe table td{
	width: 100px;

		height: 40px;
	text-align: center;

}

#detallerecibe table tr:nth-child(odd){
		background: #f1f1f1;
}

#detallerecibe table tr:nth-child(even){
background: #fff;
}

</style>
<div id="recibe">
	<?php Recibe();?>
</div>
<div id="detallerecibe">
</div>