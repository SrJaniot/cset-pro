<?php 
session_start();
	include ("../modelo/conexion.php");
	//imprime las variables con su contenido	
	foreach ($_POST as $key => $value){ echo "{$key} = {$value}\r\n<br>";}

		$pagHeader = "../perfil.php";

		$id       = $_POST['id'];
		$telefono  = nulo($_POST['telefono']);
		$celular   = nulo($_POST['celular']);
		$correo    = nulo($_POST['correo']);
		$fecha     = nulo($_POST['fecha']);
		$sexo      = nulo($_POST['sexo']);
		
		$sql = "UPDATE usuario SET 
		`usuSexo` = $sexo, 
		`usuFechaNacimiento` = $fecha, 
		`usuTelefono` = $telefono, 
		`usuCelular` =$celular, 
		`usuCorreo` = $correo 
		 WHERE 
		`usuId` = $id;";
		//echo $sql;
		$insercion = consultaSql($sql);
				
			if($insercion) {
				echo "modificacion ejecutada correctamente";
				logs("El usuario ha modificado sus datos personales");
				header('Location:'.$pagHeader.'?res=1');
			}else{
				echo "error en la modificacion de los datos, verifique el contenido";
				header('Location:'.$pagHeader.'?res=2');
			}	

 ?>