<?php
	$select=new CatalogosSelect();
?>
<form>
	<p><h2>Requisiciones</h2></p>
	<div id="cuerpore">
		<p><label for="taller">Taller</label>
		<select id="taller">
			<?php echo $select->cTalleres();?>
		</select></p>
		<p><label for="departamento">Departamento</label>
		<select id="departamento">
			<?php echo $select->cDepartamentos();?>
		</select></p>
		<p><label for="unidad">Unidad </label>
		<input type="text" onblur="if(this.value!='')Unidad(this.value, this.id, estatusunidads.name);else estatusunidads.value='';" style="width:60px;" id="unidad" name="unidad" required="required">
		<label for="estatusunidads">Estatus Unidad </label>
			<input type="text" id="estatusunidads" name="estatusunidads" readonly="readonly" required="required"></p>
		<div>
			<?php include('servicio.php');?>
		</div>
		<input type="button" value="Eliminar toda la lista" id="btnEliminarTodos" required="required"></p>
		<p><label for="solicitantes">No. Solicitante </label>
		<input onblur="if(this.value!=''){empleado(this.value, this.id, 'empleados');}" style="width:55px;" type="text" name="solicitantes" id="solicitantes" required="required">
		<strong><span id="empleados"></span></strong></p>
		<p><input type='submit' value='Guardar'></p>
	</div>
	<script type="text/javascript" src="js/servicio.js"></script>
</form>