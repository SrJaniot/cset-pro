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
$reporte = consultaSql("select area, COUNT(DISTINCT(preid)) 'canPre', sum(correctas)
 'correctas', sum(erradas)'erradas', sum(sinContestar)'sinContestar',count(pruid)'total' from informepersonal where pruid = $pruid group by area order by area, competencia;");

// numero total de aprendices vinculados ala prueba y total de los q la presentaron
$totalAp = consultaSql("select count(usuid) 'total', count(pruUsuHoraInicio)'iniciaron' from pruebausuario where pruid = $pruid");	
$totalAp = $totalAp->fetch_object();	

// numero total de aprendices vinculados ala prueba y total de los q la presentaron
$areas = consultaSql("select DISTINCT(pregunta.preArea) from pruebapregunta pp
					inner join pregunta on pp.preId = pregunta.preId where pp.pruid = $pruid
					order by pregunta.preArea");	
$ta = $areas->num_rows;	

// puntajes por categoria de los aprendices
$puntajes = consultaSql("select us.usuNumeroDoc, us.ficId,
			concat(us.usuNombre1,' ', ifnull(us.usuNombre2,''),' ', us.usuApellido1,' ', ifnull(us.usuApellido2,''))'nombre',
			sum(correctas) 'correctas', ROUND(sum(correctas)*100 / count(ip.pruid), 1) 'porcentaje'
			from informepersonal ip inner join usuario us on ip.usuid = us.usuId
			where ip.pruid = $pruid group by  ip.area, ip.usuid order by ip.usuid, area;");	
$totalAprendices = $puntajes->num_rows/$ta;		
?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
	
  google.load("visualization", "1.1", {packages:["table"]});
  google.setOnLoadCallback(drawChart);

function drawChart() {  
	
var data = new google.visualization.DataTable();
  // Add columns
  data.addColumn('string', 'Documento');
  data.addColumn('string', 'Ficha');
  data.addColumn('string', 'Nombre');
  <?php while($ar=$areas->fetch_object()){ ?>
  data.addColumn('number', '<?php echo substr($ar->preArea,0,15) ?>');
  data.addColumn('number', '%');
  <?php }  ?>
   data.addColumn('number', ' pre correctas'); 
 
  // Add empty rows
  data.addRows(<?php echo $totalAprendices?>);
  
  // añadir celdar
  <?php $i = 0;	$to = 0;
	while($pu=$puntajes->fetch_object()){ 
	 $mo = ($i % $ta);
	 if($mo == 0){ ?>
			data.setCell(<?php echo $i/$ta ?>, 0, '<?php echo $pu->usuNumeroDoc ?>');
			data.setCell(<?php echo $i/$ta ?>, 1, '<?php echo $pu->ficId ?>');
			data.setCell(<?php echo $i/$ta ?>, 2, '<?php echo $pu->nombre ?>');	 			 
		<?php } ?> 
 data.setCell(<?php echo($i-$mo)/$ta ?>,<?php echo ($mo*2 + $ta-1) ?>, <?php echo $pu->correctas ?>); 
 data.setCell(<?php echo($i-$mo)/$ta ?>,<?php echo ($mo*2 + $ta) ?>, <?php echo $pu->porcentaje ?>,
 ' <?php echo $pu->porcentaje?>% '); 
 	 <?php
	 $to = $to +  $pu->correctas; 
	  if($mo == 3){ ?>
			data.setCell(<?php echo ($i-$ta+1)/$ta ?>, <?php echo $ta*2+3 ?>, '<?php echo $to ?>');			
		<?php 
		$to = 0;
		} ?> 
  <?php  $i++ ; }  ?>  
								
        var table = new google.visualization.Table(document.getElementById('tabla'));
        table.draw(data, {width:"100%"});
		
      }
    </script>

<title>Informe Detallado de Aprendices</title>
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
        <h1 class="text-center" >Informe Detallado de Aprendices</h1><br>
        
        <h4><?php echo $dPru->pruNombre ?> (Id: <?php echo $pruid ?>)</h4>        
        <h5 style="color:#606060">Descripcion: <?php echo $dPru->pruDescripcion ?>
         Habilitada desde <b><?php echo $dPru->pruFechaInicio ?></b> 
         hasta el <b><?php echo $dPru->pruFechaFin  ?></b>, 
         con una duracion de <b><?php echo $dPru->pruTiempo  ?></b></h5>
         <h4 style="color:#606060">
         Esta prueba fue habilitada para <b><?php echo $totalAp->total ?></b> 
         aprendices de los cuales <b><?php echo $totalAp->iniciaron ?></b> la presentaron.</h4>     
        
        Esta tabla muestra los puntajes indivuduales obtenidos en cada area por cantidad de preguntas y porcentaje, igualmente muestra la cantidad total de preguntas correctas
      <br>  
      <br>  
      </div>
      
      <div class="col-xs-12">
      <center>    
 	<div id="tabla" style="width:100%"></div></center>  
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