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

// trae el codigo de las fichas y la cantidad
$fichas = consultaSql("select DISTINCT(us.ficId) from informepersonal ip inner join usuario us on ip.usuId = us.usuId where ip.pruId = $pruid order by ficid;");
$canFichas = $fichas->num_rows;

//trae las areas y la cantidad de areas
$areas = consultaSql("select DISTINCT(area) areas from informepersonal where pruId = $pruid;");	
$canAreas = $areas->num_rows;

// trae los valores de las areas por fichas (tabla principal)
$reporte = consultaSql("select us.ficId,ip.area,ROUND(sum(correctas)*100/count(pruid), 1) 'porcentaje' 
					from informepersonal ip inner join usuario us on ip.usuId = us.usuId
					where ip.pruId = $pruid group by us.ficId, ip.area order by ip.area, us.ficId ;");	

// consulta para llenar la tabla de promedios generales
$reporte2 = consultaSql("select us.ficId, fi.ficNombre, fi.ficInicio, fi.ficJornada,
				 ROUND(sum(correctas)*100 / count(pruid), 1) 'promedio' 
				from informepersonal ip inner join usuario us on ip.usuId = us.usuId
				inner join ficha fi on us.ficId = fi.ficId
				where ip.pruId = $pruid group by us.ficId order by ip.area, us.ficId ;");	
?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
	
  google.load("visualization", "1.1", {packages:["bar","table"]});
  google.setOnLoadCallback(drawChart);

function drawChart() {  
	
var data = new google.visualization.DataTable();
  // Add columns
     data.addColumn('string', 'areas del conocimiento'); 
<?php while($fic=$fichas->fetch_object()){ ?> 
   data.addColumn('number', '<?php echo $fic->ficId ?>'); 
 <?php } ?>
 

  data.addRows(<?php echo $canAreas ?>);
  
	<?php $cont = 0;
	while($are=$areas->fetch_object()){ ?> 
	   data.setCell(<?php echo $cont++ ?>,0,'<?php echo $are->areas ?>'); 
	 <?php } ?> 
  
	<?php 	
	$cont = 0;$contx = 0;$cont2 = 1;	
	while($rep=$reporte->fetch_object()){ ?> 
	 data.setCell(<?php echo $cont ?>,<?php echo $cont2 ?>,<?php echo $rep->porcentaje ?>); 
	   
	 <?php 
	 $contx++;$cont2++;
	 if($contx % $canFichas == 0){ $cont++; }
	 if($cont2 % ($canFichas+1) == 0){ $cont2 = 1; }	 	
	 }	 ?> 
								
        var table = new google.charts.Bar(document.getElementById('barras'));
        table.draw(data, {width:"100%", height: <?php echo $canAreas*$canFichas*25 ?>, bars: 'horizontal',});

/*---------------------------------------------------------------------------------------*/
		
        var data2 = google.visualization.arrayToDataTable([
          ['ficha', 'nombre', 'inicio', 'jornada', 'promedio'],		  
		<?php while($rep=$reporte2->fetch_object()){	
		echo "['$rep->ficId','$rep->ficNombre','$rep->ficInicio' ,'$rep->ficJornada',$rep->promedio],";		
		}?>]);	
			
        var table = new google.visualization.Table(document.getElementById('tabla'));
        table.draw(data2, {width:"100%"});		
		
      }
    </script>

<title>Informe por Fichas</title>
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
        <h1 class="text-center" >Informe por Fichas</h1><br>
        
        <h4><?php echo $dPru->pruNombre ?> (Id: <?php echo $pruid ?>)</h4>        
        <h5 style="color:#606060">Descripcion: <?php echo $dPru->pruDescripcion ?>
         Habilitada desde <b><?php echo $dPru->pruFechaInicio ?></b> 
         hasta el <b><?php echo $dPru->pruFechaFin  ?></b>, 
         con una duracion de <b><?php echo $dPru->pruTiempo  ?></b></h5>
         <h4 style="color:#606060">
         Esta prueba fue habilitada para <b><?php echo $totalAp->total ?></b> 
         aprendices de los cuales <b><?php echo $totalAp->iniciaron ?></b> la presentaron.</h4>     
        
        Este grafico muesta los puntajes en porcentaje de cada una de las fichas que presentaron la prueba desglosandolo por areas del conocimiento.
      <br>  
      <br>  
      </div>
      
      <div class="col-xs-12">
      <center>    
 	<div id="barras" style="width:100%"></div><hr><br>
 	<div id="tabla" style="width:80%"></div></center>  
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