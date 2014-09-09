<?php
	session_start();
	include('Usuario.php');
	$Usuario=$_POST["user"];
	$Password=$_POST["pass"];
	if(ValidaUsuario($Usuario, $Password))
		header('Location: ../Principal.php');
	else
		header('Location: ../index.php');
?>