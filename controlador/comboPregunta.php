<?php 
if (isset($_GET['valor1']) && !empty($_GET['valor1'])){

	include ("../modelo/conexion.php");
	
	$valor1 = $_GET['valor1'];

	$resultado= consultaSql("select * from auxiliar where  auxClase = 'tipoPrueba' and auxValor1 = '$valor1';");
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
 