<?php
include "varCon.php";

/*la variable global now es para convertir la hora del server a la hora 
  de colombia mediante mysq,l esta toma la hora GMT y le resta 5 horas */
$now = "CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-05:00')";

// toma dos valores y devuelve el porcentaje del uno respecto al otro
function resPorcen($correctas, $total){
	 if ($correctas != 0){
			 $aux = round($correctas/$total*100,2);
		 }else{
			 $aux ="0";
		 }
	 return $aux."%" ;
	}
	
function resPorcen2($correctas, $total){
	 if ($correctas != 0){
			 $aux = round($correctas/$total*100,1);
		 }else{
			 $aux ="0";
		 }
	 return $aux;
	}

function color100($valor) {
	
		if ($valor >= 88){
			$color = "#3294F3";
		}elseif($valor >= 70){
			$color = "#0AC64F";
		}elseif($valor >= 50){
			$color = "#9EFC65";
		}elseif($valor >= 35){
			$color = "#FCF565";
		}elseif($valor >= 20){
			$color = "#FCB565";
		}else{
			$color = "#F92525";	
		}
		return $color;	
	}

//devuelve un color dependiendo de un entero q le pasen
function colorB($valor) {
	
		if ($valor == 0){
			$color = "#3294F3";
		}elseif($valor == 1){
			$color = "#0AC64F";
		}elseif($valor == 2){
			$color = "#9EFC65";
		}elseif($valor == 3){
			$color = "#FCF565";
		}elseif($valor == 4){
			$color = "#FCB565";
		}else{
			$color = "#F92525";	
		}
		return $color;	
	}
	
// muestra un icono dependiendo del int recibido
function resOk ($valor){
	if ($valor == 1){
		$resultado = ' class="glyphicon glyphicon-ok-sign" style="color: #26B328; font-size:1.4em; cursor:pointer" ';
	} elseif ($valor == 0) {
		$resultado = 'class="glyphicon glyphicon-remove-sign" style="color: #DD5B5B; font-size:1.4em; cursor:pointer" ';		
	} elseif ($valor == 2) {
   $resultado = 'class="glyphicon glyphicon-exclamation-sign" style="color: #A7A7A7; font-size:1.4em; cursor:default" ';		
	}else {
		$resultado = 'ER';		
	}
	return $resultado;
	}
	
// muestra un icono dependiendo del int recibido
function resOk2 ($valor){
	if ($valor == 1){
		$resultado = 'Respondi&oacute; correctamente ';
	} elseif ($valor == 0) {
		$resultado = 'Respuesta incorrecta ';		
	} elseif ($valor == 2) {
		$resultado = 'Pregunta sin responder ';		
	}else {
		$resultado = 'ER';		
	}
	return $resultado;
	}	
	
// convierto un numero de segundos en formato time 00:00:00
function secToHora($tiempo){
	$hour = floor($tiempo / 3600);
	$mins = floor(($tiempo - ($hour*3600)) / 60);
	$secs = floor($tiempo % 60);
	$c1 = ($hour < 10)?"0":"";
	$c2 = ($mins < 10)?"0":"";
	$c3 = ($secs < 10)?"0":"";
	return $c1.$hour.':'.$c2.$mins.':'.$c3.$secs;
}

//convierte una fecha en timesnap a datetime
function td($fecha){
	$aux = new DateTime();
	$la_time = new DateTimeZone('America/Bogota');
	$aux->setTimezone($la_time);
	$aux->setTimestamp($fecha);					
	return 	$aux->format('Y-m-d H:i:s');		
}	

// para un string tipo TIME a segundos
function timeSec($hora) { 
    list($h, $m, $s) = explode(':', $hora); 
    return ($h * 3600) + ($m * 60) + $s; 
} 

// pasa una cantidad de seguntos a formato time
function secTime($segundos) { 
    $h = floor($segundos / 3600); 
    $m = floor(($segundos % 3600) / 60); 
    $s = $segundos - ($h * 3600) - ($m * 60); 
    return sprintf('%02d:%02d:%02d', $h, $m, $s); 
}

function nosi($valor){
	if($valor){
		return "si";
		}else{
		return "no";
		}
	
	}

function segundosFecha($seg) {
	$horas = floor($seg/3600);
	$minutos = floor(($seg-($horas*3600))/60);
	$segundos = $seg-($horas*3600)-($minutos*60);
	if($horas<10)$horas = "0".$horas;
	if($minutos<10)$minutos = "0".$minutos;
	if($segundos<10)$segundos = "0".$segundos;
	return $horas.":".$minutos.":".$segundos;
}

function Conectarse(){
	
	//$mysqli = new mysqli(varCon('host'),varCon('user'),varCon('pass'),varCon('db'));
	$mysqli = new mysqli('localhost','root','101299','csetpro');
	
	$mysqli->set_charset('utf8');
	if ($mysqli->connect_errno)
	{
		echo "Error de conexion a la Base de Datos CSETPRO ".$mysqli->connect_error;
		exit();
	}
	else
	{	
		return $mysqli;
	}		
}
//devuleve el resultado del auna consulta sql cualquiera
function consultaSql ($consulta){
	$Conexion=Conectarse();
	$sql="SET SESSION group_concat_max_len = 10000;";
	$Conexion->query($sql);	
	$sql="$consulta";
	$resultado=$Conexion->query($sql);
	$Conexion->close();	
	return $resultado;				
	}

// agrega uns entrada en la tabla log	
function logs($accion, $user="NULL"){
	$now = "CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-05:00')";	
if ($user == "NULL"){
	$usuario = (isset($_SESSION['usuId'])) ? $_SESSION['usuId']:"NULL";
	} else {
		$usuario = $user;
		}

	consultaSql("INSERT INTO `log` VALUES (NULL, $usuario, '$accion', $now);");
	}
	
// Devuelve el nombre de las columnas de la tabla que se le pase como parametro
function consultaColumnas($tabla){ 
	$Conexion=Conectarse();
	$sql="describe $tabla;";
	$resultado=$Conexion->query($sql);	
	$Conexion->close();				
	return $resultado;	
	}
// Devuelve el nombre de las columnas de la tabla que se le pase como parametro
function consultaColumnasArreglo($tabla){
	$resultado = consultaColumnas($tabla);
	$nombre = array();
	$valor = 0;
		while($row=$resultado->fetch_array(MYSQLI_BOTH)) {
		array_push($nombre, array( 'db' => $row[0], 'dt' => $valor ));
		$valor++;
		}	
		$resultado->free();
	return $nombre;
	}
//	print_r(consultaColumnasArreglo("areapregunta"));
//	print_r(consultaColumnasArreglo("centroformacion"));
// Devuelve el nombre de las columnas de la tabla que se le pase como parametro y agrega un <th>

function consultaColumnasId($tabla){
	$valor = consultaColumnasArreglo($tabla);
	return $valor[0]['db'];
	}
function consultaColumnasth($tabla){
	$resultado = consultaColumnas($tabla);
	
	while($row=$resultado->fetch_array(MYSQLI_BOTH))
		{
 			 ?><th><?php echo $row[0]; ?></th><?php
			}		
	$resultado->free();			
	}	
	
function nulo($valor){
	if ($valor == ""){
		return "NULL";
		}else{
		$valor = "'".htmlspecialchars(addslashes($valor),ENT_QUOTES)."'";
		return $valor;
			}	
	}

function comilla($valor){
	$valor = "'".$valor."'";
return $valor;
}

function consola( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Array: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( '" . $data . "' );</script>";
    echo $output;
}	

// Decodifica los valores de un objeto mysql que contengan html del tipo  &lt; &gt; y comillas ( < > ' " )
function htmlDecode ($objeto){
	foreach($objeto as $indice=>$valor)
	//{$objeto->$indice = htmlspecialchars_decode($valor);}	
	{$objeto->$indice = addslashes(htmlspecialchars_decode($valor,ENT_QUOTES));}	
	return $objeto;
}

// funcion que comprueba si una variable esta compuesta de letras
function sonLetras($variable){
	//compruebo que los caracteres sean los permitidos 
	$permitidos = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóúÁÉÍÓÚüÜ,-_ "; 
	for ($i=0; $i<strlen($variable); $i++){ 
	    if (strpos($permitidos, substr($variable,$i,1))===false){ 
	        //echo $variable . " no esta compuesto de letras<br>"; 
	        return false; 
	    } 
	} 
	//echo $variable . " esta compuesto de letras<br>"; 
	return true; 
}

?>