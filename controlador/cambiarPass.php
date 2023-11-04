<?php 
	//imprime las variables con su contenido	
	//foreach ($_POST as $key => $value){ echo "{$key} = {$value}\r\n<br>";} 
	
	include ("../modelo/conexion.php");
	
	$id = $_POST['id'];
	//$pass1 = md5($_POST['pass1']);
	$pass1 = $_POST['pass1'];
	
	$Conexion=Conectarse();
	$sql="select * from usuario where usuId= '$id' and usuPassword = '$pass1'";
	$resultado=$Conexion->query($sql);
	
	if ($resultado->num_rows) {	
	
		//$pass2 = md5($_POST['pass2']);
		$pass2 = $_POST['pass2'];
		$sql="UPDATE usuario SET `usuPassword`='$pass2' WHERE `usuId`=$id;";	
		//echo $sql;		
		$res = consultaSql($sql);
				
		if ($res){
				echo "Contraseña cambiada correctamente";
			}else{
				echo "Ocurrio un error inesperado, vuelva a intentarlo";
			}		
	}else{

			echo "Verifique su contraseña actual";	
	}


?>