<form>
	<p><h2>Requisiciones</h2></p>
	<p><label>Tipo</label>
	<select onchange="reportes(this.value);">
		<option value="Rcompras.php">Compras</option>
		<option value="Rservicio.php">Servicios</option>
	</select></p>
	<div id="cuerpore">
	</div>
	<script type="text/javascript" src="js/listas.js"></script>
</form>