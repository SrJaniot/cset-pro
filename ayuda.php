<?php 
session_start();
extract ($_REQUEST);
include ("modelo/conexion.php");
/*esta linea valida que exista una sesion, si no existe me manda al index, ademas valida
que el rol seal el indicado para la pagina si no es asi igualmente me manda a index*/
if(!isset($_SESSION['usuId'])){ header('location:index.php'); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include 'inc/head.php'; ?>
<title>Ayuda</title>
</head>

<body>
<?php 
include 'inc/header.php'; // cabecera de la pagina
$nav=11 ; // esta variable indica la pasteña a la que se le modifica el css en el nav
include 'inc/nav.php'; //barra de navegacion
?>
<section id="section2" class="colorfondo" >
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1 class="text-center" >Ayuda</h1>
        <?php if($_SESSION['rol']!='admin'){ ?> 
         <form action="controlador/procesaReporte.php" method="post" id="formEnviar">
          <input type="hidden" name="id" 
          value="<?php echo $_SESSION['usuId']?>" required>
          <div class="col-xs-12 col-sm-8 col-sm-push-2">
            <br>
            <label>
            <h4></h4>
            </label>
            <div class="form-group has-feedback mb">
            <textarea rows="2" class="form-control input-lg has-error" placeholder="Escriba aqui detalladamente su problema para que sea revisado por un administrador" name="problema"></textarea>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <label class="control-label mb">
              <h4 class="mb"></h4>
              </label>
            </div>
            <h4></h4>
          </div>
          <div class="col-xs-12"> 
            <button type="submit" class="botonStandar center-block" id="enviar">
            <h4> &nbsp;&nbsp;enviar&nbsp;&nbsp; </h4>
            </button>
          </div>
        </form>       
         <?php } ?>    
             
             <div class="col-xs-12">
             <h3>Descarga de manuales del sistema</h3>
             </div>
     <?php if($_SESSION['rol']=='admin'){ ?> 
            <div class="col-xs-12"> 
            <a href="vista/Manual CSETPRO Admin.pdf">  
            <button class="botonStandar3">
            <h4> &nbsp; <span class="glyphicon glyphicon-download-alt"></span>
            &nbsp;&nbsp;Manual Admin&nbsp;&nbsp; </h4>
            </button>
             </a>
             <br><br>
            </div>
     <?php } ?>
     <?php if($_SESSION['rol']=='admin' or $_SESSION['rol']=='instructor'){ ?> 
            <div class="col-xs-12"> 
            <a href="vista/Manual CSETPRO Instructor.pdf">  
            <button class="botonStandar3">
            <h4> &nbsp; <span class="glyphicon glyphicon-download-alt"></span>
            &nbsp;&nbsp;Manual Instructor&nbsp;&nbsp; </h4>
            </button>
             </a>
             <br><br>
            </div>
     <?php } ?>     
     <?php if($_SESSION['rol']=='admin' or $_SESSION['rol']=='aprendiz'){ ?> 
            <div class="col-xs-12"> 
            <a href="vista/Manual CSETPRO Aprendiz.pdf">  
            <button class="botonStandar3">
            <h4> &nbsp; <span class="glyphicon glyphicon-download-alt"></span>
            &nbsp;&nbsp;Manual Aprendiz&nbsp;&nbsp; </h4>
            </button>
             </a>
             <br><br>
            </div>
     <?php } ?>   
     <?php if($_SESSION['rol']=='admin' or $_SESSION['rol']=='consultor'){ ?> 
            <div class="col-xs-12"> 
            <a href="vista/Manual CSETPRO Consultor.pdf">  
            <button class="botonStandar3">
            <h4> &nbsp; <span class="glyphicon glyphicon-download-alt"></span>
            &nbsp;&nbsp;Manual Consultor&nbsp;&nbsp; </h4>
            </button>
             </a>
             <br><br>
            </div>
     <?php } ?>   
      </div>
    </div>
  </div>
</section>
<?php  include 'inc/footer.php'; //pie de pagina de la pagina?>
<script>

$(document).ready(function() {
	
	$("textarea").keyup(function (){validar(this,0,0,0,0,400,0,0)});	
	
	$( "#formEnviar" ).submit(function( event ) {	

		v6 = validar("textarea",0,0,0,1,400,0,0);	
		
		if (v6) {
			return;						
		}else {
			event.preventDefault();
		}
	}); // form
}); 
<?php 
if(isset($_GET['res'])) {
switch ($_GET['res']) {
		case "1":
		echo "alert('Se ha enviado el reporte con el problema');";
		break;

		case "2":
		echo "alert('error al ingresar los datos, vuelva a intentarlo');";
		break;
	}
}
	 ?>		
</script>
</body>
</html>