<?php
session_start();
//imprime las variables con su contenido	
//foreach ($_POST as $key => $value){ echo "{$key} = {$value}\r\n<br>";}
//print_r($_FILES)."<br>"; print_r($_POST)."<br>";

if(isset($_POST['proceso'])){
	
	include ("../modelo/conexion.php");
	$proceso = $_POST['proceso'];

	if($proceso == "terminar"){ // sentencias para AGREGAR un nuevo registro
	
	
		$pruid = $_POST['pruid'];	
		$usuid = $_POST['usuid'];	

		$sql ="UPDATE pruebausuario SET pruUsuHoraFin= $now WHERE pruId= $pruid AND usuId= $usuid";
		$insercion = consultaSql($sql);
		if($insercion){
			echo "Prueba Terminada";
			}	else{
				echo "Ocurrio un error ";				
				}	
		
	} else if ($proceso == "establecer"){ // sentencias para 
	
	} else if ($proceso == "eliminar"){ // sentencias para ELIMINAR un registro

	} 

}else{
	echo "ingreso prohibido";
	header('Location:'.$pagHeader);	
	
}
?>