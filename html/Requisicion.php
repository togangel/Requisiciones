<?php 
	function Lista(){
		$Squery="select R.Id Folio, D.Descripcion Documento, T.Descripcion Taller, DP.Descripcion Departamento, convert(varchar, R.Fecha, 103) Fecha, R.Estatus, ";
		$Squery.="case isnull(FechaAutorizo, 0) when 0 then 0 else 1 end Autoriza ";
		$Squery.="from tblRequisiciones R ";
		$Squery.="inner join cTipoDeDocumento D on D.id=R.IdTipoDocumento ";
		$Squery.="inner join cTalleres T on T.id=R.IdTaller ";
		$Squery.="inner join cDepartamentos DP on DP.Id=R.IdArea ";
		$Squery.="where convert(varchar, getdate(), 103)=convert(varchar, R.Fecha, 103) and R.FechaRecibioAlmacen is null order by R.Estatus desc, R.Id";
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
?>
 
<script type="text/javascript">
	function eliminar(id){
		var confirma=confirm('Cancelar Requisicion con folio: '+id);
		if(confirma==true){
			var xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function(){
				if(xmlhttp.readyState==4 && xmlhttp.status==200){
					location="Principal.php";
				}
			}
			xmlhttp.open("GET","includes/eliminarid.php?folio="+id,true);
			xmlhttp.send();
		}
	}

	function imprimir(id){
		window.open('includes/inprimirpdf.php?folio='+id, "Imprimir", "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no");
	}

	function detalle(id) {
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById('detalle').innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","includes/detalleR.php?folio="+id,true);
		xmlhttp.send();
	}

	function Buscar() {
		fol=document.getElementById('fol').value;
		tall=document.getElementById('tall').value;
		depa=document.getElementById('depa').value;
		fecha=$("#fecha").val();
		estatus=$("#estatus").val();
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById('listaR').innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","includes/BuscarRequisicion.php?fol="+fol+"&depa="+depa+"&tall="+tall+"&fecha="+fecha+"&estatus="+estatus,true);
		xmlhttp.send();
	}


	function limpia2() {
		$('#divLista ul').remove();
	}
</script>


<style type="text/css">
#cuerpo
{
	width: 85%;
}
h4{
	width: 300px;
	text-align: center;
	margin: 0 auto;
	padding: 1em;
	font-size: 18px;
}
#listaR{
	width: 100%;
	height: auto;
	height: 400px;
	overflow: auto;
	margin-bottom: 10px;
	border: solid black 1px;
	border-radius: 5px;
}
	
	.edit{
		border-radius: 2px;
		border: solid 1px #ccc;
		background: #fff;
		color: #000;
	}
	#listaR table{
		list-style:none;
		border-radius: 5px;
		width: 100%;
	}

	#listaR ul{
		list-style:none;
		border-radius: 5px;
	}

	#listaR table tr{
		width: 100%;
		margin: auto;
		border-radius: 5px;
		height: 40px;
		text-align: center;
	}
	#listaR table tr td{
		width: 120px;
		border: 1.5px solid white;
	}
	#listaR table tr:nth-child(odd){
		background: #9CFCBB;
}

#listaR table tr:nth-child(even){
background: white;
}

#detalle{
	width: 100%;
	height: 300px;
	border:solid 1px black;
	border-radius: 5px;
	overflow: auto;
}

#detalle table{
	width: 100%;
	border-radius: 5px;
	margin: 0 auto;
	margin-bottom: 10px;
}
#detalle table td{
	width: 100px;
	height: 40px;
	text-align: center;

}

#detalle table tr:nth-child(odd){
		background: #f1f1f1;
}

#detalle table tr:nth-child(even){
background: #fff;
}

.imprimir{
	margin:auto;
	float: right;
	margin-right: 100px;
	margin-bottom: 25px;
}

#BDetalle{
	margin: 15px auto;
	width: 100%;
	max-width: 980px;
	background: #9CF8FC;
}
#BDetalle input,#BDetalle select{
	background: #FFFF4B;
	display: inline-block;
	width: 100%;
	max-width: 300px;
	height: 35px;
	vertical-align: top;
}

</style>
<div id="BDetalle">
	<h4>Filtrar</h4>
	<label for="fol"></label><input placeholder="Folio" style="width:50px;" type="text" id="fol" name="fol">
	<label for="tall">Taller </label><select id="tall" name="tall">
		<?php echo $select->cTalleres2();?>
	</select>
	<label for="depa">Área </label><select placeholder="nel" id="depa" name="depa">
		<?php echo $select->cDepartamentos2();?>
	</select><br><br>
	<label for="fecha">Fecha: </label><input type="date" id="fecha" name="fecha">
	 <label for="estatus">Cancelados </label><input type="checkbox" name="estatus" id="estatus" value="1"> 
	  <button onclick="Buscar();">Buscar</button>
</div>
<div id="listaR">
		<?php Lista();?>
</div>
<div id="detalle">
</div>