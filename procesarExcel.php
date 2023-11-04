<?php 
session_start();
extract ($_REQUEST);
require "modelo/conexion.php";
	
$tablaGeneral = (isset($_GET['tab'])) ? $_GET['tab']:"error"; // esto es un if else

	switch ($tablaGeneral) {
		case "ficha":
		$procesa = "uploadexcelfichas.php";
		$tituloTabla = "Cargar Fichas"; // titulo dinamico de la pagina
		break;

		case "usuario":
		$procesa = "uploadexcelusuarios.php";
		$tituloTabla = "Cargar Usuarios"; 
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
        <h2 class="text-center"><?php echo $tituloTabla ?></h2>
        <section> 
        
        <?php if($tablaGeneral == "ficha"){ ?> 
         Para cargar fichas descargue primero desde <b> <a href="vista/insertarFichas.xlsx">aqui</a> </b> el formato para este fin, luego diligencielo con los datos de los registros a ingresar y mediante el siguiente boton proceda a cargarlo.       
         <?php }?>

        <?php if($tablaGeneral == "usuario"){ ?> 
         Para cargar Usuarios descargue primero desde <b> <a href="vista/insertarUsuarios.xlsx">aqui</a> </b> el formato para este fin, luego diligencielo con los datos de los registros a ingresar y mediante el siguiente boton proceda a cargarlo.       
         <?php }?>
        
         <br><br>
          <form id="formArchivo" >
            <input type="hidden" name="action" value="upload" />
            <h3>
              <input id="archivo" type="file" name="excel" />
            </h3>
          </form>
          <img  id="load" class="loading" src= 'img/load.gif'>
          <br>
          <br>        
          <div id="resultado"></div>
        </section>
      </div>
    </div>
    <?php }?>
  </div>
</section>
<?php  include 'inc/footer.php'; //pie de pagina de la pagina?>
<script>
			
$(document).ready(function() {
$("#load").hide()
$("input[name=excel]").change(function () {

	var ext = $('input[name=excel]').val().split('.').pop().toLowerCase(); 

	if($("input[name=excel]").val()!='' && 
		$.inArray(ext, ['xlsx']) == -1){

		alert('Solo se admiten archivos en formato .xlsx');
		$("input[name=excel]").val('')
		
	}else if($("input[name=excel]").val()!='' && 
		$('input[name=excel]')[0].files[0].size > 2048000){

		alert('El archivo debe pesar menos de 2 MegaBytes');
		$("input[name=excel]").val('')

	}else{
		
		$("#load").show();
		var formData = new FormData ($("#formArchivo")[0]) ;			 			
	
		$.ajax({
			url: "controlador/<?php echo $procesa ?>", 
			type: "POST", 
			data: formData, 
			contentType: false, 
			processData: false, 
			success: function(datos){
				$("#load").hide()
				console.log(datos);			
				$("#resultado").html(datos);											
			}
		});	// fin ajax	
	} // fin del if else

}); // fin envio pregunta

} ); // document

		
</script>
</body>
</html>