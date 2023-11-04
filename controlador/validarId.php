<?php 
if ((isset($_GET['numero']) && !empty($_GET['numero'])) && (isset($_GET['tabla']) && !empty($_GET['tabla']))){

	include ("../modelo/conexion.php");
	
	$numero = $_GET['numero'];
	$tabla = $_GET['tabla'];
	
	$tablaId =(isset($_GET['col']))? $_GET['col']: substr($tabla,0,3)."Id";
	$resultado= consultaSql("select count(*) existe from $tabla where $tablaId =$numero;");
	//echo ("select count(*) existe from $tabla where $tablaId =$numero;");
	$resultado = $resultado->fetch_object();
 	echo $resultado->existe;

	}else{
	echo "Error en los valores GET, no se pueden procesar";		
		}
 ?>
 
