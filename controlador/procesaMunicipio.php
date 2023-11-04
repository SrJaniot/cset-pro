<?php
session_start();
	//imprime las variables con su contenido	
	//foreach ($_POST as $key => $value){ echo "{$key} = {$value}\r\n<br>";}
	
	//imprime un arreglo de las variables existentes
	//print_r(array_keys($_GET));

if(isset($_POST['proceso'])){
	include ("../modelo/conexion.php");
	$pagHeader = "../cruds.php?tab=municipio";
	$proceso = $_POST['proceso'];
	$cod = $_POST["departamento"] . $_POST["codigo"]; // para el log
			
	if($proceso == "agregar"){ // sentencias para AGREGAR un nuevo registro
		
				$resultado=consultaSql("select * from (select  SUBSTRING(munid,1,2) id, mundepartamento 'departamento', munRegion 'region'  from municipio group by mundepartamento) as uno where id = '".$_POST["departamento"]."';");
		$resultado = $resultado->fetch_object();
		
		$id = nulo($_POST["departamento"] . $_POST["codigo"]);
		$departamento = nulo($resultado->departamento);
		$nombre = nulo($_POST['nombre']);
		$region =nulo( $resultado->region);
		$desarrollo = nulo($_POST['desarrollo']);
		$desempeño = nulo($_POST['desempeno']);
		$calificacion = nulo($_POST['calificacion']);
		$categorialey = nulo($_POST['categoriaLey']);
		$capital = nulo($_POST['capital']);	
		
		$insercion = consultaSql( "INSERT INTO `csetpro`.`municipio` VALUES ( ".$id.",
															".$departamento.",
															".$nombre.",
															".$region.",
															".$desempeño.",
															".$calificacion.",
															".$desarrollo.", 
															".$categorialey.",
															".$capital.",
															 $now )
															;");
		if($insercion) {
				echo "insercion ejecutada correctamente";
				logs("Se ha insertado $cod en la tabla municipio");
				header('Location:'.$pagHeader.'&res=1');
			}else{
				echo "error en la insercion de los datos, verifique el contenido";
				header('Location:'.$pagHeader.'&res=2');
			}	
		
	} else if ($proceso == "modificar"){ // sentencias para MODIFICAR un  registro

		$resultado=consultaSql("select * from (select  SUBSTRING(munid,1,2) id, mundepartamento 'departamento', munRegion 'region'  from municipio group by mundepartamento) as uno where id = '".$_POST["departamento"]."';");
		$resultado = $resultado->fetch_object();
		
		$id = nulo($_POST["departamento"] . $_POST["codigo"]);
		$departamento = nulo($resultado->departamento);
		$nombre = nulo($_POST['nombre']);
		$region =nulo( $resultado->region);
		$desarrollo = nulo($_POST['desarrollo']);
		$desempeño = nulo($_POST['desempeno']);
		$calificacion = nulo($_POST['calificacion']);
		$categorialey = nulo($_POST['categoriaLey']);
		$capital = nulo($_POST['capital']);	

	$insercion = consultaSql( "UPDATE municipio SET 
			munNombre = $nombre, 
			munDesempeño = $desempeño, 
			munCalificacion = $calificacion, 
			munDesarrollo = $desarrollo, 
			munCategoriaLey = $categorialey, 
			munCapital = $capital 
			WHERE 
			munId = $id
			;");
			
			if($insercion) {
				echo "modificacion ejecutada correctamente";
				logs("Se ha modificado $cod en la tabla municipio");
				header('Location:'.$pagHeader.'&res=3');
			}else{
				echo "error en la modificacion de los datos, verifique el contenido";
				header('Location:'.$pagHeader.'&res=4');
			}	

	} else if ($proceso == "eliminar"){ // sentencias para ELIMINAR un registro
	
		$id = nulo($_POST["id"]);
		$cod = $_POST["id"];
		//echo("DELETE FROM municipio WHERE munId = $id");
		$insercion = consultaSql("DELETE FROM municipio WHERE munId = $id");
			
			if($insercion) {
				echo "eliminacion ejecutada correctamente";
				logs("Se ha eliminado $cod en la tabla municipio");
				header('Location:'.$pagHeader.'&res=5');
			}else{
				echo "error en la eliminacion de los datos, verifique el contenido";
				header('Location:'.$pagHeader.'&res=6');
			}			
	} 
		
}else{
	echo "ingreso prohibido";
	//header('Location:'.$pagHeader);			
}
?>
<meta charset="UTF-8">
