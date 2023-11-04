<?php
//sleep(1);
	//imprime las variables con su contenido	
	//foreach ($_POST as $key => $value){ echo "{$key} = {$value}\r\n<br>";}
	//print_r($_FILES)."<br>";
	//print_r($_POST)."<br>";
	
if(isset ($_FILES ["archivo"])){
	//toma el archivo y lo pasa a una variable
	$foto = $_FILES["archivo"];
	//extrae las propiedades del archivo
	$nombre = $foto["name"];
	$tipo = $foto["type"];
	$ruta_provisional = $foto["tmp_name"] ;
	$size = $foto["size"];
	// otras propiedades del archivo calculadas
	$dimensiones = getimagesize($ruta_provisional); 
	$width = $dimensiones[0];
	$height = $dimensiones[1];
	$carpeta = "img/fperfil/";
 
	$trozos = explode(".", $nombre); 
	$extension = end($trozos);  

	$nombre = $_POST["nombreFoto"].".".$extension;
	
	if ($tipo != "image/jpeg" && $tipo != "image/png"){
		echo "Error, el archivo no es una imagen"; 
		}
	else if ($size > 1024*1024){
		echo "Error, el tamaño máximo permitido es un 1MB"; 
		}
	else if ($width > 1000 || $width < 60 || $height > 1000 || $height < 60){
		echo "Error la anchura y la altura de la images debe de ser menores de 1000px";
		}
	else{
		$src = $carpeta.$nombre;
		//echo $src;
		move_uploaded_file ($ruta_provisional, "../".$src); 
		$time = '?'.time();
		echo "<img src= $src$time  alt='foto Perfil' style='width: 100%';>";
		
		//actualizar el dato de la imagen en el campo usuario
		include ("../modelo/conexion.php");
		consultaSql("UPDATE `usuario` SET `usuFoto`='$nombre' WHERE  `usuId`=".$_POST["nombreFoto"].";");
		
		}
}else {
	echo "error inesperado";
	}
?>