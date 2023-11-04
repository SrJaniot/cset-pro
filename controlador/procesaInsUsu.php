<?php 
session_start();
	//imprime las variables con su contenido	
	foreach ($_POST as $key => $value){ echo "{$key} = {$value}\r\n<br>";}
		
if(isset($_POST['proceso'])){
	
	include ("../modelo/conexion.php");
	$tabla = "institucionusuario";	
	$pagHeader = "../perfil.php";
	$proceso = $_POST['proceso'];
	$idtab = substr($tabla,0,3)."Id";
	
	if($proceso == "agregar"){ // sentencias para AGREGAR un nuevo registro
		
		$usuid  = nulo($_POST['fusuId']);
		$insid  = nulo($_POST['finsId']);
		$sedid  = nulo($_POST['fsedId']);
		$tipo   = nulo($_POST['ftitulo']);
		$titulo = nulo($_POST['fobtenido']);
		$nivel   = nulo($_POST['fnivel']);
		$graduado  = nulo($_POST['fgraduado']);
		$ultimo  = nulo($_POST['fultimo']);

		$sql = "DELETE FROM institucionusuario WHERE usuid = $usuid ;"; 
		echo $sql;
		consultaSql($sql);

		$sql ="INSERT INTO institucionusuario VALUES (NULL, $usuid, $insid, $sedid, $tipo, $titulo, $nivel, $graduado, $ultimo);";
		echo $sql."<br>";
		$insercion = consultaSql($sql);
		
		if($insercion) {
				echo "insercion ejecutada correctamente";
				header('Location:'.$pagHeader.'?res=1');
			}else{
				echo "error en la insercion de los datos, verifique el contenido";
			   header('Location:'.$pagHeader.'?res=2');
			}	
		
	} else if ($proceso == "eliminar"){ // sentencias para ELIMINAR un registro
	
		$id = nulo($_POST["id"]);
		
		$sql = "DELETE FROM institucionusuario WHERE usuid = $id ;"; 
		echo $sql;
		$insercion = consultaSql($sql);
			
			if($insercion) {
				echo "eliminacion ejecutada correctamente";
				header('Location:'.$pagHeader.'?res=5');
			}else{
				echo "error en la eliminacion de los datos, verifique el contenido";
				header('Location:'.$pagHeader.'?res=6');
			}			
	} 
		
}else{
	echo "ingreso prohibido";
	header('Location:'.$pagHeader);			
}

?>
<meta charset="UTF-8">
