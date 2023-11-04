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
$reporte = consultaSql("select it.insId, ifnull(it.insNombre, 'sin colegio registrado')'colegio', 
count(ip.pruId) 'canAprendices', ROUND(sum(correctas)/count(ip.pruId),1) 'promedio',
mu.munNombre, mu.munDepartamento 
from (select pruId, usuId, sum(correctas)'correctas' from informepersonal where pruId = $pruid GROUP BY	usuId) ip 
left join institucionusuario iu on ip.usuId = iu.usuId 
left join institucion        it on iu.insId = it.insId
left join municipio          mu on it.munId = mu.munId
group by it.insId order by canAprendices desc;");	
?>
    <title>Informe por Colegios</title>
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
        <h1 class="text-center" >Informe por Colegios</h1>
        <br>
        <h4><?php echo $dPru->pruNombre ?> (Id: <?php echo $pruid ?>)</h4>
        <h5 style="color:#606060">Descripcion: <?php echo $dPru->pruDescripcion ?> Habilitada desde <b><?php echo $dPru->pruFechaInicio ?></b> hasta el <b><?php echo $dPru->pruFechaFin  ?></b>, 
              con una duracion de <b><?php echo $dPru->pruTiempo  ?></b></h5>
        <h4 style="color:#606060"> Esta prueba fue habilitada para <b><?php echo $totalAp->total ?></b> aprendices de los cuales <b><?php echo $totalAp->iniciaron ?></b> la presentaron.</h4>
        Este grafico muesta los puntajes en porcentaje de cada una de las fichas que presentaron la prueba desglosandolo por areas del conocimiento. <br>
        <br>
      </div>
          <div class="col-xs-12">
        <center>
          <div id="tabla" style="width:90%">
          
          

          </div>
         </center> 
         <div class="table-responsive">
          <table id="example" class="table table-striped table-hover table-condensed ">
            <thead>
              <tr>
                <th style="vertical-align:middle;" class="text-center"> Codigo  </th>
                <th style="vertical-align:middle;" class="text-center"> Nombre Colegio</th>
                <th style="vertical-align:middle;" class="text-center"> Cant Aprendices</th>
                <th style="vertical-align:middle;" class="text-center"> Promedio</th>
                <th style="vertical-align:middle;" class="text-center"> Municipio</th>
                <th style="vertical-align:middle;" class="text-center"> Departamentos</th>
              </tr>
            </thead>
            <tbody id="tableScroll">
             <?php while($rep=$reporte->fetch_object()){ ?>   
             <tr>
                <td style="font-size:1.3em;" > <?php echo $rep->insId ?></td>
                <td style="font-size:1.1em;"><b><?php echo $rep->colegio ?></b></td>
                <td style="font-size:1.3em;" class="text-center">
				<?php echo $rep->canAprendices ?></td>
                <td style="font-size:1.3em;" class="text-center">
				<?php echo $rep->promedio ?>%</td>
                <td style="font-size:1em;"><?php echo $rep->munNombre ?></td>
                <td style="font-size:1em;"><?php echo $rep->munDepartamento ?></td>
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

	$('#example').dataTable( {
		"lengthMenu": [[-1, 30, 50, 100], ['todos', 30, 50, 100]],
		 "pagingType": "full_numbers",
		"scrollX": true,		
		"language": idiomaDT, 
	} );//datatable

});

</script>
</body>
</html>