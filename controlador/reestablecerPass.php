<?php 
	//imprime las variables con su contenido	
	//foreach ($_POST as $key => $value){ echo "{$key} = {$value}\r\n<br>";} 
	
	include ("../modelo/conexion.php");
	$id = $_POST['id'];
	//$numero = md5($_POST['numero']);
	$numero = $_POST['numero'];
	
	$res = consultaSql("UPDATE `usuario` SET `usuPassword`='$numero' WHERE  `usuId`=$id;");
	
	if ($res){
			echo "Contraseña reestablecida al documento de identidad correctamente";
		}else{
			echo "Error inesperado";
		}
?>