<?php include('Consultas.php');?>
<script type='text/javascript' src='https://www.google.com/jsapi'></script>
<script type="text/javascript">
	google.load('visualization', '1', {packages:['table']});
	google.setOnLoadCallback(drawVisualization);
	function drawVisualization() {
		var data = google.visualization.arrayToDataTable(<?php echo SemaforoTablaEmpleado(); ?>);
		visualization = new google.visualization.Table(document.getElementById('tableempleado'));
		var formatter = new google.visualization.ColorFormat();
		formatter.addRange(1, 2, '#0AAE0A', '#0AAE0A');
		formatter.addRange(2, 3, 'yellow', 'yellow');
		formatter.addRange(3, 4, '#FE0505', '#FE0505');
		formatter.addRange(4, null, 'white', 'white');
		formatter.format(data, 9);
		visualization.draw(data, {allowHtml: true, showRowNumber: true});
	}
</script>
<div id='tableempleado'></div>