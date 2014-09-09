<?php
	session_start();
	if(isset($_SESSION['nomina']) and isset($_SESSION['usuario'])) header('Location: Principal.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Turicun</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
		<link href="img/favicon.ico" rel="shortcut icon" type="image/x-icon">
		<link rel="stylesheet" href="css/login.css">
	</head>
	<body>
		<?php include('html/encabezado.html');?>
		<div id="cuerpo">
			<div id="cuerpo_login">
				<form action="includes/Login.php" method="POST">
					<p class="inlog"><label for="user">Usuario</label></p>
					<p class="inlog"><input name="user" type="text" id="user" required="required"></p>
					<p class="inlog"><label for="pass">Contraseña</label></p>
					<p class="inlog"><input name="pass" type="password" id="pass" required="required"></p>
					<p class="inlog"><input value="Entrar" type="submit" id="button_enter"></p>
				</form>
			</div>
		</div>
	</body>
</html>