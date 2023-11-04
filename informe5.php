<?php 
session_start();
extract ($_REQUEST);
include ("modelo/conexion.php");
/*esta linea valida que exista una sesion, si no existe me manda al index, ademas valida
que el rol seal el indicado para la pagina si no es asi igualmente me manda a index*/
if(!isset($_SESSION['usuId'])){ header('location:index.php'); }
if(!isset($_GET['pruid'])){ header('location:index.php'); }
if($_SESSION['rol']!='instructor' and $_SESSION['rol']!='consultor'){ header('location:index.php'); }?>
<!DOCTYPE html>
<html lang="es">
    <head>
    <?php 
include 'inc/head.php'; 

$pruid = $_GET['pruid'];

// datos de la prueba		
$datosPrueba = consultaSql("select * from prueba where pruid = $pruid");					
$dPru = $datosPrueba->fetch_object();

// numero total de aprendices vinculados ala prueba y total de los q la presentaron
$totalAp = consultaSql("select count(usuid) 'total', count(pruUsuHoraInicio)'iniciaron' from pruebausuario where pruid = $pruid");	
$totalAp = $totalAp->fetch_object();


// consulta para llenar la tabla de promedios generales
$reporte = consultaSql("select ip.preid, area, competencia, sum(correctas) 'correctas',
			 sum(erradas)'erradas', sum(sinContestar)'sinContestar' from informepersonal ip
			inner join pregunta pr on ip.preid = pr.preId
			where pruid = $pruid group by ip.preid  order by correctas desc;");	
?>
    <title>Informe por Preguntas</title>
    </head>

    <body>
<?php 
include 'inc/header.php'; // cabecera de la pagina
$nav=11 ; // esta variable indica la pasteña a la que se le modifica el css en el nav
include 'inc/nav.php'; //barra de navegacion
?>
<section id="section2" class="colorfondo">
      <div class="container">
    <div class="row">
          <div class="col-xs-12">
        <h1 class="text-center" >Informe por Preguntas</h1>
        <br>
        <h4><?php echo $dPru->pruNombre ?> (Id: <?php echo $pruid ?>)</h4>
        <h5 style="color:#606060">Descripcion: <?php echo $dPru->pruDescripcion ?> Habilitada desde <b><?php echo $dPru->pruFechaInicio ?></b> hasta el <b><?php echo $dPru->pruFechaFin  ?></b>, 
              con una duracion de <b><?php echo $dPru->pruTiempo  ?></b></h5>
        <h4 style="color:#606060"> Esta prueba fue habilitada para <b><?php echo $totalAp->total ?></b> aprendices de los cuales <b><?php echo $totalAp->iniciaron ?></b> la presentaron.</h4>
        Esta tabla contiene la lista de las preguntas que se usaron en la prueba, reflejando la cantidad de aprendices que acertaron, erraron o no contestaron cada pregunta, la pregunta se muestra en pantalla dando clic sobre el ID que esta en la primera columna.<br>
        <br>
      </div>
          <div class="col-xs-12">
        <center>
          <div id="tabla" style="width:90%">
          
          

          </div>
         </center> 
         <div class="table-responsive">
          <table id="example" class="table table-striped table-bordered table-hover table-condensed ">
            <thead>
              <tr>
                <th style="vertical-align:middle;" class="text-center"> pre ID </th>
                <th style="vertical-align:middle;" class="text-center"> Area</th>
                <th style="vertical-align:middle;" class="text-center"> Competencia</th>
                <th style="vertical-align:middle;" class="text-center"> Acertaron</th>
                <th style="vertical-align:middle;" class="text-center"> Erraron</th>
                <th style="vertical-align:middle;" class="text-center"> No contestaron</th>
              </tr>
            </thead>
            <tbody id="tableScroll">
             <?php while($rep=$reporte->fetch_object()){ ?>   
             <tr>
                <td style="font-size:1.3em;" data-preid="<?php echo $rep->preId ?>">
                <b class="divpo"><?php echo $rep->preId ?></b></td>
                <td style="font-size:1.3em;"><b><?php echo $rep->area ?></b></td>
                <td style="font-size:1.3em;"><?php echo $rep->competencia ?></td>
                <td class="text-center" style="font-size:1.3em; color:#00AB1E">
                <b><?php echo $rep->correctas ?></b></td>
                <td class="text-center" style="font-size:1.3em; color:#FF2124">
				<?php echo $rep->erradas ?></td>
                <td class="text-center" style="font-size:1.3em; color:#4B4B4B">
				<?php echo $rep->sinContestar ?></td>
              </tr>
              <?php 	}?>  
            </tbody>
          </table>
        <!-- <div style="border-bottom: solid 1px #EEEEEE;"></div> -->
        
        <hr>
      </div>
    </div>
        <div class="modal fade" id="mVentana" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Informacion del Aprendiz</h4>
          </div>
          <div class="modal-body" id="mContenido">
            <div class="container-fluid"> </div>
          </div>
        </div>
        <!-- /.modal-content --> 
      </div>
      <!-- /.modal-dialog --> 
    </div>
    <!-- /.modal --> 
  </div>
 </section>
<?php  include 'inc/footer.php'; //pie de pagina de la pagina?>
<script>
$(document).ready(function() {

$("[data-preid]").click(function(){
	
		var usuid =  <?php echo $_SESSION['usuId'] ?>;
		var pruid = "<?php echo $pruid ?>";
		var preid = $(this).data('preid');
		$("#loadingText").text("Cargando...");
		$("#loadingAjax").fadeIn(300);
		$.ajax({
			url: "controlador/procesaModal.php", 
			type: "POST", 
			data: {proceso:"pregunta",usuid:usuid,pruid:pruid,preid:preid}, 
			success: function(datos){
				$('#mContenido').html(datos)
				$('.modal-title').text("Informacion de la Pregunta")
				$("#loadingAjax").fadeOut(300);	
				$('#mVentana').modal('show')					
			}
		});	

	});
});

</script>
</body>
</html>