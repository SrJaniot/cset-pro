<?php 
if (isset($_GET['departamento']) && !empty($_GET['departamento'])){

	include ("../modelo/conexion.php");
	
	$departamento = $_GET['departamento'];

	$resultado= consultaSql("select  munid, munnombre from municipio where mundepartamento = '$departamento';");
	$i = 0;
 $rawdata = array();
    while($row = $resultado->fetch_array(MYSQLI_ASSOC))
    {
        $rawdata[$i] = $row;
        $i++;
    }
	
	//print_r($rawdata);
	echo json_encode($rawdata);	
	
	}else{
		echo "Error en los valores GET, no se pueden procesar";		
	}
 ?>
 