<?php
session_start();
	//imprime las variables con su contenido	
	foreach ($_POST as $key => $value){ echo "{$key} = {$value}\r\n<br>";}
	//imprime un arreglo de las variables existentes
	//print_r(array_keys($_GET));

if(isset($_POST['proceso'])){
	
	include ("../modelo/conexion.php");
	$tabla = "centroFormacion";	
	$pagHeader = "../cruds.php?tab=centroFormacion";
	$proceso = $_POST['proceso'];
	$idtab = substr($tabla,0,3)."Id";
	$cod = ""; // para el log
	
	if($proceso == "agregar"){ // sentencias para AGREGAR un nuevo registro
		
		$codigo = nulo($_POST['codigo']);
		$nombre = nulo($_POST['nombre']);
		$sigla = nulo($_POST['sigla']);
		$municipio = nulo($_POST['municipio']);
		$direccion = nulo($_POST['direccion']);
		$telefono = nulo($_POST['telefono']);
		$blog  = nulo($_POST['blog']);

		$sql ="INSERT INTO centroformacion VALUES ($codigo, $nombre, $direccion, $municipio, $sigla, $telefono, $blog,  $now );";
		echo $sql."<br>";
		
		$insercion = consultaSql($sql);
		
		if($insercion) {
				echo "insercion ejecutada correctamente";
				echo "select MAX($idtab) ultimo from $tabla;";
				//$ultimo = consultaSql("select MAX($idtab) ultimo from $tabla;");
				//$ultimo = $ultimo->fetch_object()->ultimo;
				echo logs("Se ha insertado ".$_POST['codigo']." en la tabla $tabla");
				header('Location:'.$pagHeader.'&res=1');
			}else{
				echo "error en la insercion de los datos, verifique el contenido";
			    header('Location:'.$pagHeader.'&res=2');
			}	
		
	} else if ($proceso == "modificar"){ // sentencias para MODIFICAR un  registro

		$cod = $_POST['codigox'];
		$codigo = nulo($_POST['codigox']);
		$nombre = nulo($_POST['nombre']);
		$sigla = nulo($_POST['sigla']);
		$direccion = nulo($_POST['direccion']);
		$telefono = nulo($_POST['telefono']);
		$blog  = nulo($_POST['blog']);

		$insercion = consultaSql("UPDATE `centroformacion` SET 
		`cenNombre` = $nombre, 
		`cenDireccion` = $direccion, 
		`cenSigla` = $sigla, 
		`cenTelefono` = $telefono, 
		`cenBlog` = $blog 
		 WHERE `cenId` = $codigo;");
				
			if($insercion) {
				echo "modificacion ejecutada correctamente";
				logs("Se ha modificado $cod en la tabla $tabla");
				header('Location:'.$pagHeader.'&res=3');
			}else{
				echo "error en la modificacion de los datos, verifique el contenido";
				header('Location:'.$pagHeader.'&res=4');
			}	

	} else if ($proceso == "eliminar"){ // sentencias para ELIMINAR un registro
	
		$id = nulo($_POST["id"]);
		$cod = $_POST["id"];
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
