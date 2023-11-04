<?php
session_start();
//imprime las variables con su contenido	
//foreach ($_POST as $key => $value){ echo "{$key} = {$value}\r\n<br>";}
//print_r($_FILES)."<br>"; print_r($_POST)."<br>";

if(isset($_POST['proceso'])){
	
	include ("../modelo/conexion.php");
	$tabla = "opcion";	
	$proceso = $_POST['proceso'];
	$imagenOk = false;
	$nombre  = "";
	$carpeta = "";
	$rutaTmp = "";

	if($proceso == "agregar"){ // sentencias para AGREGAR un nuevo registro
	
		if(isset($_FILES ["imagen"]) && $_FILES["imagen"]["name"] != ''){
			
			//toma el archivo y lo pasa a una variable
			$foto    = $_FILES["imagen"];
			//extrae las propiedades del archivo
			$nombre  = $foto["name"];
			$tipo    = $foto["type"];
			$rutaTmp = $foto["tmp_name"] ;
			$size    = $foto["size"];
			// otras propiedades del archivo calculadas
			$dimensiones = getimagesize($rutaTmp); 
			$width = $dimensiones[0];
			$height = $dimensiones[1];
			$carpeta = "img/pregunta/";

			
			if ($tipo != "image/jpeg" && $tipo != "image/png"){
				echo "Error, el archivo no es una imagen"; 
			}
			else if ($size > 1024*1024*15){
				echo "Error, el tamaño máximo permitido es un 4 Megabytes"; 
			}
			else if ($width > 20000 || $width < 60 || $height > 20000 || $height < 60){
				echo "Error la anchura y la altura de la images debe de ser menores de 2000px";
			}
			else{
				
				$imagenOk = true;
			}
		}else {
		//	echo " Sin imagen\n";
			$imagenOk = true;
		}

		if ($imagenOk) {			
 
			$preId       = $_POST['preid'];		
			$estado       = nulo($_POST['estado']);
			$opcion        = nulo($_POST['opcion']);

			$sql ="INSERT INTO opcion  VALUES (NULL, $preId, $opcion, NULL, $estado, NULL);";
			$insercion = consultaSql($sql);
			echo $insercion;
		} 

	} else if ($proceso == "establecer"){ // sentencias para 
	
		$opcid = $_POST['opcid'];	
		$resid = $_POST['resid'];	

		$sql =" UPDATE resultado SET opcId=$opcid, resFecha= $now WHERE resId=$resid;";
		$insercion = consultaSql($sql);
		if($insercion){
			echo "Selecionado correctamente";
			}	
	} else if ($proceso == "eliminar"){ // sentencias para ELIMINAR un registro
		
		$id = $_POST["id"];
		$sql = "DELETE FROM $tabla WHERE opcId = $id";
		//echo $sql;
		$insercion = consultaSql($sql);
		echo $insercion;
		//unlink("../img/pregunta/".$id.".png");	

	} 

}else{
	echo "ingreso prohibido";
	header('Location:'.$pagHeader);	
	
}

?>
