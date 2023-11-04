<?php
session_start();
extract ($_REQUEST);
require "../modelo/conexion.php";

$login = $_REQUEST['login'];
//$pass = md5($_REQUEST['pass']);
$pass = $_REQUEST['pass'];

$user = consultaSql("select * from usuario where usuNumeroDoc= '$login'");
$user = $user->fetch_object();

$head = "";

	if($user == ""){
		echo "el usuario no existe";
		$head="?val=1"; 
		
	} elseif($user->usuEstado == 0) {
		echo "el usuario esta inactivo";
		logs("Usuario inactivo intento ingresar", $user->usuId);
		$head="?val=3"; 
		
	} elseif($user->usuPassword != $pass) {
		echo "el usuario existe, pero la contraseña esta mal";
		logs("Error en la contraseña al intentar ingresar", $user->usuId);
		$head="?val=2"; 
		
	} else{
		echo "Todo bien";
		
		$_SESSION['usuId']= $user->usuId;	
		$_SESSION['nombre']= $user->usuNombre1." ".$user->usuNombre2." ".$user->usuApellido1;		
		$_SESSION['foto']= $user->usuFoto;			
		$_SESSION['rol']= $user->usuRol;	
		
		logs("Inicio de sesion");
		}

header("location:../index.php".$head);

?>
