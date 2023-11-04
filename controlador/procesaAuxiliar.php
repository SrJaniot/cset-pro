<?php
session_start();
	//imprime las variables con su contenido	
	foreach ($_POST as $key => $value){ echo "{$key} = {$value}\r\n<br>";}
	//imprime un arreglo de las variables existentes
	//print_r(array_keys($_GET));

if(isset($_POST['proceso'])){
	include ("../modelo/conexion.php");
	$pagHeader = "../cruds.php?tab=auxiliar";
	$proceso = $_POST['proceso'];
	$cod = ""; // para el log
	$tabla = "auxiliar";
	
	if($proceso == "agregar"){ // sentencias para AGREGAR un nuevo registro
		
		$clase  = nulo($_POST['clase']);
		$valor1 = nulo($_POST['valor1']);
		$valor2 = nulo($_POST['valor2']);
		$valor3 = nulo($_POST['valor3']);

		$insercion = consultaSql("INSERT INTO auxiliar VALUES (NULL, $clase, $valor1, $valor2, $valor3,  $now ); ");
		
		if($insercion) {
				echo "insercion ejecutada correctamente";
				$ultimo = consultaSql("select MAX(auxid) ultimo from $tabla;");
				$ultimo = $ultimo->fetch_object()->ultimo;
				echo logs("Se ha insertado $ultimo en la tabla $tabla");
				header('Location:'.$pagHeader.'&res=1');
			}else{
				echo "error en la insercion de los datos, verifique el contenido";
				header('Location:'.$pagHeader.'&res=2');
			}	
		
	} else if ($proceso == "modificar"){ // sentencias para MODIFICAR un  registro

		$cod = $_POST["auxId"];
		$auxId = nulo($_POST['auxId']);
		$clase = nulo($_POST['clase']);
		$valor1 = nulo($_POST['valor1']);
		$valor2 = nulo($_POST['valor2']);
		$valor3 = nulo($_POST['valor3']);

		$insercion = consultaSql("UPDATE auxiliar SET auxClase = $clase, 
														`auxValor1` = $valor1, 
														`auxValor2` = $valor2, 
														`auxValor3` = $valor3 
														 WHERE auxId = $auxId;");
				
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
		$insercion = consultaSql("DELETE FROM $tabla WHERE auxId = $id");
			
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
