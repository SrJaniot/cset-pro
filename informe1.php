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
	
// consulta para llenar la grafica de torta			
$reportePie = consultaSql("select area, sum(correctas) 'correctas', sum(erradas)'erradas', 
				sum(sinContestar)'sinContestar',count(pruid)'total' from informepersonal 
				where pruid = $pruid");	
$reportePie = $reportePie->fetch_object();

// consulta para llenar la linea de puntajes
$reporteLinea = consultaSql("select CONCAT(us.usuNombre1,' ', us.usuApellido1 ,' - ',us.ficId) 'aprendiz', 
				sum(correctas) 'correctas', sum(erradas)'erradas', sum(sinContestar)'sinContestar',
				count(pruid)'total' from informepersonal ip inner join usuario us on ip.usuId = us.usuId
				where pruid = $pruid group by ip.usuId order by correctas;");

// numero total de aprendices vinculados ala prueba y total de los q la presentaron
$totalAp = consultaSql("select count(usuid) 'total', count(pruUsuHoraInicio)'iniciaron' from pruebausuario where pruid = $pruid");	
$totalAp = $totalAp->fetch_object();			
?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
	
  google.load("visualization", "1.1", {packages:["bar","table","corechart","line"]});
  google.setOnLoadCallback(drawChart);
	  
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['areas', '% correctas', '% Erradas', '% sin contestar'],		  
		<?php while($rep=$reporte->fetch_object()){	
					$co = resPorcen2($rep->correctas,$rep->total);
					$er = resPorcen2($rep->erradas  ,$rep->total);
					$sc = resPorcen2($rep->sinContestar,$rep->total);
				echo "['$rep->area', $co, $er, $sc],";		
		}?>]);

        var options = {
			chart: {title: 'Grafico General',
			subtitle:"Porcentaje de efectividad por areas de la prueba"},
			width: 800, height: 550,
			colors: ['#0FA31B', '#DD2229', '#959595'],};
/*----------------------------------------------------------------------------*/

       var chart = new google.charts.Bar(document.getElementById('graficoBarras'));
       chart.draw(data, options);	

        var data2 = google.visualization.arrayToDataTable([
          ['total', 'valor'],
          ['Correctas', <?php echo $reportePie->correctas ?>],
          ['Erradas', <?php echo $reportePie->erradas ?>],
          ['Sin contestar', <?php echo $reportePie->sinContestar ?>]
        ]);
		
		var options = {title: '% de Totales',is3D: false, 
		colors: ['#0FA31B', '#DD2229', '#959595'],legend: 'none',fontSize:20,
		width: 280, height: 280,};
		
 		var chart = new google.visualization.PieChart(document.getElementById('graficoCircular'));
        chart.draw(data2, options);

/*----------------------------------------------------------------------------*/
        var data3 = google.visualization.arrayToDataTable([
          ['areas','Cant Preguntas', '% correctas', '% Erradas', '% sin contestar',
		  		    'Correctas', 'Erradas', 'Sin contestar','Total' ],		  
		<?php 
		
		mysqli_data_seek($reporte,0); // permite usar una consulta q ya fue recorrida	
		while($rep=$reporte->fetch_object()){	
					$co = resPorcen2($rep->correctas,$rep->total);
					$er = resPorcen2($rep->erradas  ,$rep->total);
					$sc = resPorcen2($rep->sinContestar,$rep->total);
				echo "['$rep->area', $rep->canPre, $co, $er, $sc , $rep->correctas, 
				$rep->erradas, $rep->sinContestar, $rep->total ],";	}?>]);
								
        var table = new google.visualization.Table(document.getElementById('tabla'));
        table.draw(data3, {showRowNumber: true, width:"100%",fontSize:20});
		
		
/*----------------------------------------------------------------------------*/

    var data4 = google.visualization.arrayToDataTable([
          ['Nombre/ficha','Correctas'],      
    <?php     
    while($rep=$reporteLinea->fetch_object()){ 
		$co = resPorcen2($rep->correctas,$rep->total);
		$er = resPorcen2($rep->erradas  ,$rep->total);
		$sc = resPorcen2($rep->sinContestar,$rep->total);
        echo "['$rep->aprendiz', $co],";  }
        ?>]);  
		
		
		 var options = {
		  title: 'Curva de puntajes individuales de los aprendices de menor a mayor',
          colors: ['#0FA31B', '#DD2229', '#959595'],
		  width: '100%', height: 450,
         // curveType: 'function',
          legend: { position: 'bottom' },
		   hAxis: { textPosition: 'none'},
		   vAxis: { viewWindowMode:'explicit',viewWindow:{ 'max':100,'min':0 } },
        };

        var chart = new google.visualization.LineChart(document.getElementById('graficoLinea'));
        chart.draw(data4, options);
		
      }
    </script>

<title>Informe General</title>
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
        <h1 class="text-center" >Informe General de la Prueba</h1><br>
        
        <h4><?php echo $dPru->pruNombre ?> (Id: <?php echo $pruid ?>)</h4>        
        <h5 style="color:#606060">Descripcion: <?php echo $dPru->pruDescripcion ?>
         Habilitada desde <b><?php echo $dPru->pruFechaInicio ?></b> 
         hasta el <b><?php echo $dPru->pruFechaFin  ?></b>, 
         con una duracion de <b><?php echo $dPru->pruTiempo  ?></b></h5>
         <h4 style="color:#606060">
         Esta prueba fue habilitada para <b><?php echo $totalAp->total ?></b> 
         aprendices de los cuales <b><?php echo $totalAp->iniciaron ?></b> la presentaron.</h4>     
        <div style="border-bottom: solid 1px #EEEEEE;"></div>
      <br>
            
			<center>
            <div >
            <div id="graficoBarras"></div>
            <div id="graficoCircular" style="position:absolute; bottom:165px; right:50px"></div>
            </div>       
 			<div id="tabla" style="width:80%"></div>
           </center>   
            <br>
      </div>
      <div class="col-xs-12">
      <div style="border-bottom: solid 1px #EEEEEE;"></div>
      <br>
      <center><h2>Grafica lineal por puntajes en porcentaje</h2></center>
      <center><div id="graficoLinea" style="width:90%"></div></center>
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