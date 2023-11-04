<?php 
session_start();
extract ($_REQUEST);
require "modelo/conexion.php";
		
/*esta linea valida que exista una sesion, si no existe me manda al index, ademas valida
que el rol seal el indicado para la pagina si no es asi igualmente me manda a index*/
if(!isset($_SESSION['usuId']) or $_SESSION['rol']!='admin'){ header('location:index.php'); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include 'inc/head.php'; ?>
<title>Insertar Registro</title>
</head>

<body>
<?php 
include 'inc/header.php'; // cabecera de la pagina
$nav=12 ; // esta variable indica la pasteña a la que se le modifica el css en el nav
include 'inc/nav.php'; //barra de navegacion
?>
<section id="section2" class="colorfondo" >
  <div class="container">
<?php 
$tablaGeneral = (isset($_GET['tab'])) ? $_GET['tab']:"error"; // esto es un if else
	$prefijo = "vista/form";
	
	if(isset($_GET['id'])){ $prefijo = "vista/editar";}
	switch ($tablaGeneral) {
		
		case "ficha":
 		include ($prefijo."Ficha.php");
		break;

		case "usuario":
		include ($prefijo."Usuario.php");
		break;

		case "prueba":
		//include ($prefijo."Prueba.php");
		echo "<script >window.history.back(-1);</script>";
		break;

		case "pregunta":
		//include ($prefijo."Pregunta.php");
		echo "<script >window.history.back(-1);</script>";
		break;

		case "centroFormacion":
		include ($prefijo."Centro.php");
		break;

		case "institucion":
		//include ($prefijo."Institucion.php"); 
		echo "<script >window.history.back(-1);</script>";
		break;

		case "sede":
		//include ($prefijo."Sede.php");
		echo "<script >window.history.back(-1);</script>";
		break;

		case "municipio":
		include ($prefijo."Municipio.php");
		break;

		case "auxiliar":
		include ($prefijo."Auxiliar.php");
		break;

		default:
		echo"<br> <h2 class='text-center'>Error en la seleccion vuelva a intentarlo</h2> <br><br>"; 
		break;
		} 	
 ?>
  </div>
</section >
<?php  include 'inc/footer.php'; //pie de pagina de la pagina?>

</body>
</html>