<?php 
session_start();
extract ($_REQUEST);
require "modelo/conexion.php";
	
$tablaGeneral = (isset($_GET['tab'])) ? $_GET['tab']:"error"; // esto es un if else
$mostrarBoton = "no";
/* comprueba mediante un array si esta diponible la tabla que viene por GET
$tablas = array("ficha","usuario","pruebas","areaPregunta","pregunta","centroFormacion","instituciones","municipios");
if (in_array("ficha", $tablas)) {
    $tablaGeneral = "ficha";
}*/
	
	switch ($tablaGeneral) {
		case "ficha":
		$tablaGeneral = "ficha1";
		$tituloTabla = "Fichas del Centro"; // titulo dinamico de la pagina
		$mostrarBoton = "si";
		break;

		case "usuario":
		$tablaGeneral = "usuario1";
		$tituloTabla = "Usuarios del Sistema"; 
		$mostrarBoton = "si";
		break;

		case "prueba":
		$tablaGeneral = "prueba1";
		$tituloTabla = "Pruebas Existentes"; 
		break;

		case "pregunta":
		$tablaGeneral = "pregunta1";
		$tituloTabla = "Preguntas Existentes"; 

		break;

		case "centroFormacion":
		$tablaGeneral = "centroformacion1";
		$tituloTabla = "Centros de Formacion"; 
		$mostrarBoton = "si";
		break;

		case "institucion":
		$tablaGeneral = "institucion1";
		$tituloTabla = "Instituciones Educativas"; 
		break;
		
		case "sede":
		$tablaGeneral = "sede1";
		$tituloTabla = "Sedes de Instituciones"; 
		break;

		case "municipio":
		$tablaGeneral = "municipio1";
		$tituloTabla = "Municipios de Colombia"; 
		$mostrarBoton = "si";
		break;
		
		case "auxiliar":
		$tablaGeneral = "auxiliar";
		$tituloTabla = "Tablas Auxiliares"; 
		$mostrarBoton = "si";
		break;
		
		default:
		$tituloTabla = "<br> Error en la seleccion vuelva a intentarlo <br><br>"; 
		$tablaGeneral = "error"; 
		break;
		} 	
	
/*esta linea valida que exista una sesion, si no existe me manda al index, ademas valida
que el rol seal el indicado para la pagina si no es asi igualmente me manda a index*/
if(!isset($_SESSION['usuId']) or $_SESSION['rol']!='admin'){ header('location:index.php'); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include 'inc/head.php'; ?>
<title>CRUD's</title>
</head>

<body>
<?php 
include 'inc/header.php'; // cabecera de la pagina
$nav=12 ; // esta variable indica la pasteña a la que se le modifica el css en el nav
include 'inc/nav.php'; //barra de navegacion
?>
<section id="section2" class="colorfondo" >
  <div class="container">
<?php  if ($tablaGeneral=="error"){?> 
 <h2 class="text-center"><?php echo $tituloTabla ?></h2>
 <?php }else{?>
    <div class="row">
      <div class="col-xs-12">
      <?php if($tablaGeneral == "ficha1" or $tablaGeneral == "usuario1"){ ?>  
      <a href="procesarExcel.php?tab=<?php echo $_GET['tab']; ?>">
          <button type="submit" class="botonStandar3" style="position: absolute; left:0px">
        <h4>&nbsp;<span class="glyphicon glyphicon-list-alt"></span>
         &nbsp;Cargar con Excel&nbsp;&nbsp; </h4>
        </button>
		</a>   
        <?php } ?>
      <?php if($mostrarBoton == "si"){ ?>          
       <a href="crudRegistro.php?tab=<?php echo $_GET['tab']; ?>">
          <button type="submit" class="botonStandar" style="position: absolute; right:0px">
        <h4> &nbsp;&nbsp;Anadir Nuevo&nbsp;&nbsp; </h4>
        </button>
		</a> 
        <?php } ?>  
        <h2 class="text-center"><?php echo $tituloTabla ?></h2>
      </div>
    </div>
    <div class="row">
      <section class="col-xs-12">
        <table id="example" class="display" cellspacing="0" width="100%">
          <thead>
            <tr>
              <?php $resultado = consultaColumnasth($tablaGeneral);?>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <?php $resultado = consultaColumnasth($tablaGeneral);?>
            </tr>
          </tfoot>
        </table>
      </section>
    </div>
<?php }?>
  </div>
</section>
<?php  include 'inc/footer.php'; //pie de pagina de la pagina?>
<script>
			
$(document).ready(function() {
	$('#example').dataTable( {
		
	//configuraciones para conectar al server
		"processing": true,
		"serverSide": true,
		"ajax": "modelo/server_processing.php<?php echo '?t='.$tablaGeneral ?>",		
	//longitud de la consulta "-1 para mostrar todos los registros"
		"lengthMenu": [[15, 30, 50, 100], [15, 30, 50, 100]],
	//paga que hacer visibles los botones "primero" y "ultimo"
		 "pagingType": "full_numbers",
	// mostrar el scroll horizontal
		"scrollX": true,		
	//configuraciones para cambiar idioma de etiquetas
		"language": idiomaDT, 
	} );//datatable
	
   var table = $('#example').DataTable();
   
	$('#example tbody').on( 'click', 'tr', function () {

	 if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }	
	});
	
	$('#example tbody').on( 'click', 'tr', function () {
		if ( $(this).hasClass('selected') == false ) {
		var id = $( this ).children(":first").text() 
			if(!isNaN(id)){
				  window.open("crudRegistro.php?tab="+ $(document).getUrlParam("tab") +"&id="+ id, "_self");	
			}		
		}		
	});	
} ); // document

<?php 
if(isset($_GET['res'])) {
switch ($_GET['res']) {
		case "1":
		echo "alert('registro ingresado correctamente');";
		break;

		case "2":
		echo "alert('error al ingresar los datos, vuelva a intentarlo');";
		break;

		case "3":
		echo "alert('registro modificado correctamente');";
		break;

		case "4":
		echo "alert('error al modificar los datos, vuelva a intentarlo');";
		break;
		
		case "5":
		echo "alert('eliminacion de registro exitosa');";
		break;

		case "6":
		echo "alert('No se pudo eliminar el registro, vuelva a intentarlo');";
		break;
	}
}
	 ?>			
</script>
</body>
</html>