<?php
	session_start();
	if(!isset($_SESSION['nomina']) and !isset($_SESSION['usuario'])) header('Location: index.php');
	include('includes/Catalogos.php');
	$select=new CatalogosSelect();
?>
<!DOCTYPE <html></html>
<html>
<img src="" alt="">
	<head>
		<title>Turicun</title>
		<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
		<link href="img/favicon.ico" rel="shortcut icon" type="image/x-icon">
		<script src="js/tabs.js"></script>
		<link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="css/estilo.css">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="css/listas.css">
		<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
		<script>
			$(function(){$( "#tabs" ).tabs();});
		</script>
	</head>
	<body>
		<div id="menu">
			<?php include('html/menu.html');?>
		</div>
		<div id="cuerpo">
			<div id="tabs">
				<?php include("includes/Permisos.php"); ?>
			</div>
		</div>
	</body>
</html>