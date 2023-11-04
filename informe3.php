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

// consulta para llenar las barras y la tabla
$reporte = consultaSql("select pruid, area, competencia, sum(correctas) 'correctas', 		 
	count(pruid)'total',ROUND(sum(correctas)*100 / count(pruid), 1) 'porcentaje'
	from informepersonal where pruid = $pruid
	group by  area, competencia order by area, competencia;");
	
$largoTabla = $reporte->num_rows;

// numero total de aprendices vinculados ala prueba y total de los q la presentaron
$totalAp = consultaSql("select count(usuid) 'total', count(pruUsuHoraInicio)'iniciaron' from pruebausuario where pruid = $pruid");	
$totalAp = $totalAp->fetch_object();	

// areas de la prueba
$areasCiclo = consultaSql("select DISTINCT(pregunta.preArea) from pruebapregunta pp
		inner join pregunta on pp.preId = pregunta.preId where pp.pruid = $pruid order by prearea;");	
	
?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
	
  google.load("visualization", "1.1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);

function drawChart() {  


       var data = google.visualization.arrayToDataTable([
         ['area', '% Efectividad', { role: 'annotation' }, { role: 'style' } ],
			<?php    
			$area = "";
			$color = -1;
			while($rep=$reporte->fetch_object()){   
			
				if ($area != $rep->area){$area = $rep->area;$color++;}
				
			?>['<?php echo $rep->competencia." de ".$rep->area ?>', <?php echo $rep->porcentaje ?>,
			 '<?php echo $rep->porcentaje ?>%', '<?php echo colorB($color) ?>' ],	
			<?php } ?>        	 
    	  ]);
		
      var options = {
			title: 'Grafico por competencias',
			legend: 'none',
			width:"90%",height: <?php echo $largoTabla*60 ?>};		
								
        var table = new google.visualization.BarChart(document.getElementById('tabla'));
        table.draw(data, options);
		
      }
    </script>

<title>Informe Desglosado por competencias </title>
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
        <h1 class="text-center" >Informe Desglosado por competencias</h1><br>
        
        <h4><?php echo $dPru->pruNombre ?> (Id: <?php echo $pruid ?>)</h4>        
        <h5 style="color:#606060">Descripcion: <?php echo $dPru->pruDescripcion ?>
         Habilitada desde <b><?php echo $dPru->pruFechaInicio ?></b> 
         hasta el <b><?php echo $dPru->pruFechaFin  ?></b>, 
         con una duracion de <b><?php echo $dPru->pruTiempo  ?></b></h5>   
        
        Esta grafico muesta la efectividad en las respuestas desglosando por las competencias de cada area
      <br>  
      <br>  
      </div>
      
      <div class="col-xs-12">
      <center>    
 	<div id="tabla" style="width:100%"></div>
    <div style="width:500px;">
    <?php
	 $color = -1;
	while($ac=$areasCiclo->fetch_object()){  
	$color++;
	?> 
		<h3 style="text-align:left"><span class="glyphicon glyphicon-tag" style="color:<?php echo colorB($color) ?>"></span>
           &nbsp; <?php echo $ac->preArea ?></h3> 
    <?php } ?>
    </div>    
    </center>  
    <!-- <div style="border-bottom: solid 1px #EEEEEE;"></div> --> 
      
      <hr>
      </div>
      
    </div>
  </div>
</section>
<?php  include 'inc/footer.php'; //pie de pagina de la pagina?>
<script>
$(document).ready(function() {

$("#xxx").click(function(){
		
	});
});

</script>
</body>
</html>