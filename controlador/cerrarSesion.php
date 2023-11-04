<?php
	session_start();	
	include ("../modelo/conexion.php");
	logs('Se ha cerrado sesion');
	session_unset();
	session_destroy();
	header('location:../index.php');
?>





