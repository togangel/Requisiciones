<?php 
	function Autoriza(){
		$Squery="select R.Id Folio, D.Descripcion Documento, T.Descripcion Taller, DP.Descripcion Departamento, convert(varchar, R.Fecha, 103) Fecha, R.Estatus ";
		$Squery.="from tblRequisiciones R ";
		$Squery.="inner join cTipoDeDocumento D on D.id=R.IdTipoDocumento ";
		$Squery.="inner join cTalleres T on T.id=R.IdTaller ";
		$Squery.="inner join cDepartamentos DP on DP.Id=R.IdArea ";
		$Squery.="where R.FechaAutorizo is null and R.Estatus=1 order by R.Id";
		$conn4=Connection();
		$stmt4=$conn4->query($Squery);
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
		while($row4=$stm4t->fetch(PDO::FETCH_ASSOC)){
			$val.='<tr>';
			$val.='<td>'.$row4['Folio'].'</td>';
			$val.='<td>'.$row4['Documento'].'</td>';
			$val.='<td>'.$row4['Taller'].'</td>';
			$val.='<td>'.$row4['Departamento'].'</td>';
			$val.='<td>'.$row4['Fecha'].'</td>';
			if($row4['Estatus']=='1') $val.='<td>Activo</td>';
			else $val.='<td>Cancelado</td>';
			$val.='<td><button id="'.$row4['Folio'].'" onclick="detalles(this.id);" class="edit">Detalle</button></td>';
			if($row4['Estatus']=='1')
				$val.='<td><button id="'.$row4['Folio'].'" onclick="autorizar(this.id);" class="edit">Autorizar</button></td>';
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
	function autorizar(id){
		var confirma=confirm('Autorizar Requisicion con folio: '+id);
		if(confirma==true){
			var xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function(){
				if(xmlhttp.readyState==4 && xmlhttp.status==200){
					location="Principal.php";
				}
			}
			xmlhttp.open("GET","includes/Autoriza.php?folio="+id,true);
			xmlhttp.send();
		}
	}

	function detalles(id) {
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById('detalleautorizar').innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","includes/detalleR.php?folio="+id,true);
		xmlhttp.send();
	}
</script>

<style type="text/css">
	#autorizar{
		width: 100%;
		height: auto;
		height: 400px;
		overflow: auto;
		margin-bottom: 20px;
		border: solid black 1px;
		border-radius: 5px;
	}
	#autorizar table{
	margin: 0 auto;
	}

	#autorizar ul{
		list-style:none;
		border-radius: 5px;
	}

	#autorizar table tr{
		width: 100%;
		margin: auto;
		border-radius: 5px;
		height: 40px;
		text-align: center;
	}
	#autorizar table tr td{
		width: 120px;
	}

	#autorizar table tr:nth-child(odd){
		background: #f1f1f1;
}

#autorizar table tr:nth-child(even){
background: #fff;
}

#detalleautorizar{
	width: 100%;
	height: 300px;
	border:solid 1px black;
	border-radius: 5px;
	overflow: auto;
}

#detalleautorizar table{
	width: 100%;
	border-radius: 5px;
	margin: 0 auto;
	margin-bottom: 10px;
}
#detalleautorizar table td{
	width: 100px;

		height: 40px;
	text-align: center;

}

#detalleautorizar table tr:nth-child(odd){
		background: #f1f1f1;
}

#detalleautorizar table tr:nth-child(even){
background: #fff;
}

</style>
<div id="autorizar">
	<?php Autoriza();?>
</div>
<div id="detalleautorizar">
</div>