<?php 
session_start();
sleep(1);
	include ("../modelo/conexion.php");
	//imprime las variables con su contenido	
	//foreach ($_POST as $key => $value){ echo "{$key} = {$value}\r\n<br>";}
	
	if(isset($_POST['id']) && isset($_POST['text'])){
	
		$id = $_POST['id'];
		$text = nulo($_POST['text']);
		$insercion = consultaSQL("UPDATE reporte SET `repNota`=$text WHERE  `repid`=$id;");
			
			if($insercion) {
				echo "1";
			}else{
				echo "error en la insercion de los datos, verifique el contenido";
			}	
		
		}else{
			echo "error al recibir los datos";
		}
 ?>