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
$reporte = consultaSql("select us.usuId, us.usuNumeroDoc, us.ficId, 
concat(us.usuNombre1,' ', ifnull(us.usuNombre2,''),' ', us.usuApellido1,' ', ifnull(us.usuApellido2,''))'nombre',
sum(correctas) 'correctas', sum(erradas)'erradas', sum(sinContestar)'sinContestar' 
from informepersonal ip inner join usuario us on ip.usuId = us.usuId 
where ip.pruId = $pruid group by ip.usuId  order by nombre");	
?>
    <title>Generar Informes individuales</title>
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
        <h1 class="text-center" >Generar Informes individuales</h1>
        <br>
        <h4><?php echo $dPru->pruNombre ?> (Id: <?php echo $pruid ?>)</h4>
        <h5 style="color:#606060">Descripcion: <?php echo $dPru->pruDescripcion ?> Habilitada desde <b><?php echo $dPru->pruFechaInicio ?></b> hasta el <b><?php echo $dPru->pruFechaFin  ?></b>, 
              con una duracion de <b><?php echo $dPru->pruTiempo  ?></b></h5>
        <h4 style="color:#606060"> Esta prueba fue habilitada para <b><?php echo $totalAp->total ?></b> aprendices de los cuales <b><?php echo $totalAp->iniciaron ?></b> la presentaron.</h4>
        
       Desde esta tabla puede ver los informes individuales de los aprendices que presentaron la prueba, posteriorme puede generar los PDF's individuales  <br>
        <br>
      </div>
          <div class="col-xs-12">

         <div class="table-responsive">
          <table id="example" class="table table-striped table-bordered table-hover table-condensed ">
            <thead>
              <tr>
                <th style="vertical-align:middle;" class="text-center">Documento</th>
                <th style="vertical-align:middle;" class="text-center">Nombre</th>
                <th style="vertical-align:middle;" class="text-center">Ficha</th>
                <th style="vertical-align:middle;" class="text-center">Correctas</th>
                <th style="vertical-align:middle;" class="text-center">Erradas</th>
                <th style="vertical-align:middle;" class="text-center">Sin contestar</th>
                <th style="vertical-align:middle;" class="text-center">Ver</th>
              </tr>
            </thead>
            <tbody id="tableScroll">
             <?php while($rep=$reporte->fetch_object()){ ?>   
             <tr>
                <td style="font-size:1.3em;" > <?php echo $rep->usuNumeroDoc ?></td>
                <td style="font-size:1.3em;" > <?php echo $rep->nombre ?></td>
                <td style="font-size:1.3em;" > <?php echo $rep->ficId ?></td>
                <td style="font-size:1.3em;" > <?php echo $rep->correctas ?></td>
                <td style="font-size:1.3em;" > <?php echo $rep->erradas ?></td>
                <td style="font-size:1.3em;" > <?php echo $rep->sinContestar ?></td>
                <td style="font-size:1.3em;" > 
                <a href="informePersonal.php?pruid=<?php echo $pruid ?>&usuid=<?php echo $rep->usuId ?>" target="_blank">
                <button>Ver Informe</button></a></td>
              </tr>
              <?php 	}?>  
            </tbody>
          </table>
        <!-- <div style="border-bottom: solid 1px #EEEEEE;"></div> -->
        
        <hr>
      </div>
    </div>
      
  </div>
 </section>
<?php  include 'inc/footer.php'; //pie de pagina de la pagina?>
<script>
$(document).ready(function() {

});

</script>
</body>
</html>