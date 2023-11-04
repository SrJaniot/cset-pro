<?php
session_start();
	//imprime las variables con su contenido	
	foreach ($_POST as $key => $value){ echo "{$key} = {$value}\r\n<br>";}
	//imprime un arreglo de las variables existentes
	//print_r(array_keys($_GET));

if(isset($_POST['proceso'])){
	
	include ("../modelo/conexion.php");
	$tabla = "usuario";	
	$pagHeader = "../cruds.php?tab=usuario";
	$proceso = $_POST['proceso'];
	$idtab = substr($tabla,0,3)."Id";
	$cod = ""; // para el log
	
	if($proceso == "agregar"){ // sentencias para AGREGAR un nuevo registro
		
		$cod       = $_POST['numeroDocumento'];
		$tipo      = nulo($_POST['tipoDocumento']);
		$numero    = nulo($_POST['numeroDocumento']);
		$rol       = nulo($_POST['rol']);
		$nombre1   = nulo($_POST['nombre1']);
		$nombre2   = nulo($_POST['nombre2']);
		$apellido1 = nulo($_POST['apellido1']);
		$apellido2 = nulo($_POST['apellido2']);
		$telefono  = nulo($_POST['telefono']);
		$celular   = nulo($_POST['celular']);
		$correo    = nulo($_POST['correo']);
		$fecha     = nulo($_POST['fecha']);
		$sexo      = nulo($_POST['sexo']);
		$estado    = nulo($_POST['estado']);
		// si no existe la variable ficha entonces ficha es igual a NULL
		$ficha     = (isset($_POST['ficha']))? $_POST['ficha']:"NULL";
		// la contraseña por defecto es el numero de documento
		//$pass = nulo(md5($cod));
		$pass = nulo($cod);

		$sql ="INSERT INTO usuario VALUES (NULL, $tipo, $numero, $numero, $nombre1, $nombre2, $apellido1, $apellido2, DEFAULT, $sexo, $fecha, $telefono, $celular, $correo, $rol, $ficha, $pass,  $now , $estado); 
";
		echo $sql."<br>";
		
		$insercion = consultaSql($sql);
		
		if($insercion) {
				echo "insercion ejecutada correctamente";
				//echo "select MAX($idtab) ultimo from $tabla;";
				//$ultimo = consultaSql("select MAX($idtab) ultimo from $tabla;");
				//$ultimo = $ultimo->fetch_object()->ultimo;
				echo logs("Se ha insertado $cod en la tabla $tabla");
				header('Location:'.$pagHeader.'&res=1');
			}else{
				echo "error en la insercion de los datos, verifique el contenido";
			    header('Location:'.$pagHeader.'&res=2');
			}	
		
	} else if ($proceso == "modificar"){ // sentencias para MODIFICAR un  registro
		
		$cod       = $_POST['numeroDocumento'];
		$id       = $_POST['idx'];
		$tipo      = nulo($_POST['tipoDoc']);
		$numero    = nulo($_POST['numeroDocumento']);
		$rol       = nulo($_POST['rol']);
		$nombre1   = nulo($_POST['nombre1']);
		$nombre2   = nulo($_POST['nombre2']);
		$apellido1 = nulo($_POST['apellido1']);
		$apellido2 = nulo($_POST['apellido2']);
		$telefono  = nulo($_POST['telefono']);
		$celular   = nulo($_POST['celular']);
		$correo    = nulo($_POST['correo']);
		$fecha     = nulo($_POST['fecha']);
		$sexo      = nulo($_POST['sexo']);
		$estado    = nulo($_POST['estado']);
		// si no existe la variable ficha entonces ficha es igual a NULL
		$ficha     = nulo((isset($_POST['ficha']))? $_POST['ficha']:"NULL");	
		
		$sql = "UPDATE usuario SET 
		`usuNumeroDoc` = $numero, 
		`usuNombre1` = $nombre1, 
		`usuNombre2` = $nombre2, 
		`usuApellido1` = $apellido1, 
		`usuApellido2` = $apellido2, 
		`usuSexo` = $sexo, 
		`usuFechaNacimiento` = $fecha, 
		`usuTelefono` = $telefono, 
		`usuCelular` =$celular, 
		`usuCorreo` = $correo, 
		`usuRol` = $rol, 
		`ficId` = $ficha, 
		`usuInsercion` =  $now , 
		`usuEstado` = $estado 
		 WHERE 
		`usuId` = $id;";
		echo $sql;
		$insercion = consultaSql($sql);
				
			if($insercion) {
				echo "modificacion ejecutada correctamente";
				logs("Se ha modificado $cod en la tabla $tabla");
				header('Location:'.$pagHeader.'&res=3');
			}else{
				echo "error en la modificacion de los datos, verifique el contenido";
				header('Location:'.$pagHeader.'&res=4');
			}	

	} else if ($proceso == "eliminar"){ // sentencias para ELIMINAR un registro
	
		$id = nulo($_POST["idd"]);
		$cod = $_POST["idd"];
		echo "DELETE FROM $tabla WHERE auxId = $id"; 
		$insercion = consultaSql("DELETE FROM $tabla WHERE $idtab = $id");
			
			if($insercion) {
				echo "eliminacion ejecutada correctamente";
				logs("Se ha eliminado $cod en la tabla $tabla");
				header('Location:'.$pagHeader.'&res=5');
			}else{
				echo "error en la eliminacion de los datos, verifique el contenido";
				header('Location:'.$pagHeader.'&res=6');
			}			
	} 
		
}else{
	echo "ingreso prohibido";
	header('Location:'.$pagHeader);			
}

?>
<meta charset="UTF-8">
