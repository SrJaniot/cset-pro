<?php 
session_start();

	include ("../modelo/conexion.php");
	//imprime las variables con su contenido	
	foreach ($_POST as $key => $value){ echo "{$key} = {$value}\r\n<br>";}
	
	if(isset($_POST['id']) && isset($_POST['problema'])){
	
		$id = $_POST['id'];
		$problema = nulo($_POST['problema']);
		
		$insercion = consultaSQL("INSERT INTO reporte VALUES (NULL, $id, $problema,  $now , NULL, NULL);");
			
			if($insercion) {
				echo "problema insertado correctamente";
				header('Location:../ayuda.php?res=1');
			}else{
				echo "error en la insercion de los datos, verifique el contenido";
				header('Location:../ayuda.php?res=2');
			}	
		
		}else{
			echo "error al recibir los datos";
		}
 ?>