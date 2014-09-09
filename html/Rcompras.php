<style>
#subtipo select{
	width: 130px;
}
.suggest-element{
margin-left:5px;
margin-top:5px;
width:350px;
cursor:pointer;
}
#suggestions {
width:350px;
height:150px;
overflow: auto;
}
</style>
<script>
	function Unidad(value, id, input) {
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4 && xmlhttp.status==200){
				if(xmlhttp.responseText===''){
					document.getElementById(id).value='';
					document.getElementById(input).value='';
					alert('No se encontro la unidad: '+value);
				}
				else document.getElementById(input).value=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","includes/Unidad.php?unidad="+value,true);
		xmlhttp.send();
	}

	function BuscaUnidad(value, id) {
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4 && xmlhttp.status==200){
				if(xmlhttp.responseText===''){
					document.getElementById(id).value='';
					alert('No se encontro la unidad: '+value);
				}
			}
		}
		xmlhttp.open("GET","includes/Unidad.php?unidad="+value,true);
		xmlhttp.send();
	}

	function empleado(value, id, div) {
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function() {
			if(xmlhttp.readyState==4 && xmlhttp.status==200){
				if(xmlhttp.responseText==='Empleado no encontrado'){
					document.getElementById(id).value='';
					document.getElementById(div).innerHTML='';
					alert('No se encontro al empleado con No.Nomina: '+value);
				}
				else document.getElementById(div).innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","includes/Empleado.php?empleado="+value,true);
		xmlhttp.send();
	}

	function folios(folio) {
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function() {
			if(xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById(folio).value=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","includes/Folio.php?script=1",true);
		xmlhttp.send();
	}

	function valida(){
		if(document.getElementById("departamento").value==='' || document.getElementById("ctaller").value===''){
			alert("Completa todos los campos");
			return;
		}
		else return confirm('Los datos son correctos');
	}

	function Tipo(value){
		if(value==='9'){
			document.getElementById('unidad').disabled=true;
			document.getElementById('estatusunidads').disabled=true;
			document.getElementById('unidad').value='';
			document.getElementById('estatusunidads').value='';
			document.getElementById('subtipo').innerHTML='';
			eliminalista();
		}
		else if(value==='10'){
			document.getElementById('unidad').disabled=false;
			document.getElementById('estatusunidads').disabled=false;
			document.getElementById('subtipo').innerHTML='   <select id="subtipoval" name="subtipoval"><option value="1">Servicio</option><option value="2">Refaccion</option></select>';
			eliminalista();
		}
		/*var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function() {
			if(xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById(folio).value=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","includes/Folio.php",true);
		xmlhttp.send();*/
	}
</script>
<div id="ventanas"></div>
<form method="post" action="includes/RCompras.php">
	<p><h2>Requisiciones</h2></p>
	<div id="cuerpore">
		<p><label for="tipo">Tipo</label>
		<select id="tipo" name="tipo" onchange="Tipo(this.value);">
			<option value="9">Compra</option>
			<option value="10">Servicio</option>
		</select></p>
		<p><label for="folio">Folio </label>
		<input style="width:55px;" readonly="readonly" onclick="folios(this.id);" value="<?php include('includes/Folio.php');?>" type="text" name="folio" id="folio"></p>
		<p><label for="ctaller">Taller</label>
		<select id="ctaller" name="ctaller">
			<?php echo $select->cTalleres();?>
		</select></p>
		<p><label for="departamento">Área</label>
		<select id="departamento" name="departamento">
			<?php echo $select->cDepartamentos();?>
		</select></p>
		<p><label for="unidad">Unidad </label>
		<input type="text" onblur="if(this.value!='')Unidad(this.value, this.id, estatusunidads.name);else estatusunidads.value='';" style="width:60px;" id="unidad" name="unidad" required="required" disabled="disabled">
		<label for="estatusunidads">Estatus Unidad </label>
		<input type="text" id="estatusunidads" name="estatusunidads" readonly="readonly" required="required" disabled="disabled"></p>
		<div>
			<?php include('compra.php');?>
		</div>
		<p><input type="button" value="Eliminar toda la lista" id="btnEliminarTodo"></p>
		<p><label for="cobservaciones">Observaciones</label><br>
		<textarea style="width:300px;height:100px;" name="cobservaciones" id="cobservaciones" required="required"></textarea></p>
		<p><label for="solicitante">No. Solicitante </label>
		<input onblur="if(this.value!=''){empleado(this.value, this.id, 'cempleado');}" style="width:55px;" type="text" name="solicitante" id="solicitante" required="required">
		<strong><span id="cempleado"></span></strong></p>
		<p><input type='submit' value='Guardar' onclick="return confirm('Los datos son correctos')"></p>
	</div>
	<script type="text/javascript" src="js/compras.js"></script>
</form>