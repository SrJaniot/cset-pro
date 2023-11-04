<?php 
session_start();
extract ($_REQUEST);
include ("modelo/conexion.php");
/*esta linea valida que exista una sesion, si no existe me manda al index, ademas valida
que el rol seal el indicado para la pagina si no es asi igualmente me manda a index*/
if(!isset($_SESSION['usuId']) or !isset($_GET['pruid']) or !isset($_GET['usuid'])){ 
	header('location:index.php'); }

$pruid = $_GET['pruid'];
$aprendiz = $_GET['usuid'];

// datos de la prueba		
$datosPrueba = consultaSql("select * from prueba where pruid = $pruid");					
$dPru = $datosPrueba->fetch_object();

//envia al usuario al index si no tiene vinculada la prueba
$vinculado = consultaSql("select count(*) 'vinculado' from pruebausuario where usuid = $aprendiz and pruid = $pruid");					
$vinculado = $vinculado->fetch_object();
if($vinculado->vinculado < 1) {header('location:index.php');}

if($_SESSION['rol']=='aprendiz'){ 
//envia al usuario al index si es un aprendiz diferente al que inicio sesion
	if($_SESSION['usuId']!= $aprendiz){header('location:index.php'); }

//envia al usuario al index si la prueba no esta habilitada para mostrar resultados
if(!$dPru->pruMostrarResultados) {header('location:index.php');}

//envia al usuario al index si la prueba no esta habilitada para mostrar resultados por tiempo
$fueHace = consultaSql("select (UNIX_TIMESTAMP($now) - UNIX_TIMESTAMP(pruusuhorafin)) 'fueHace' from pruebausuario where usuid = $aprendiz and pruid = $pruid;");					
$fueHace = $fueHace->fetch_object();
if($fueHace->fueHace < 0) {header('location:index.php');}

}

$totales = consultaSql("select pruid,usuid, area, competencia, sum(correctas) 'correctas', 
			sum(erradas)'erradas', sum(sinContestar)'sinContestar',count(pruid)'total' 
			from informepersonal where pruid = $pruid and usuid = $aprendiz;");
$totales = $totales->fetch_object();

$datosApre = consultaSql("select * from usuario where usuid = $aprendiz;");
$datosApre = $datosApre->fetch_object();

$DatosPruUsu = consultaSql("select * from pruebausuario where usuid = $aprendiz and pruid = $pruid;");					
$DatosPruUsu = $DatosPruUsu->fetch_object();

?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include 'inc/head.php'; ?>

  <style type="text/css">
  .puntosCirculo {
	height:120px;
	width:120px;
	background-color: <?php echo  color100($totales->correctas / $totales->total*100) ?>;
	border-radius:60px;
	float: right;
	}
  </style>

<title>Informe Personal</title>
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
      <a href="informePersonalPDF.php?pruid=<?php echo $pruid ?>&usuid=<?php echo $aprendiz ?>" target="_blank">
        <button id="btnInforme"  class="botonStandar3" style="position: absolute; right:0px">
				<h4>&nbsp;&nbsp;Generar PDF&nbsp;&nbsp;</h4>
        </button></a>
      <br><br><br>
         <h2 class="text-center" >Informe Personal Prueba </h2><br>
      </div>
      
      <div class="col-xs-12 col-xs-push-0 col-sm-7 col-md-push-1">
        <h4><?php echo $dPru->pruNombre ?> (Id: <?php echo $pruid ?>)</h4>
        
        <h6 style="color:#606060">Descripcion: <?php echo $dPru->pruDescripcion ?></h6>
       
        <div style="border-bottom: solid 1px #EEEEEE;"></div>

        <h4>Aprendiz: <?php echo $datosApre->usuNombre1." ".$datosApre->usuNombre2." ".$datosApre->usuApellido1." ".$datosApre->usuApellido2 ?></h4>       
         <h4>Documento: <b><?php echo $datosApre->usuTipoDoc." ".$datosApre->usuNumeroDoc ?></b>
         &nbsp;&nbsp; Ficha: <b><?php echo $datosApre->ficId ?></b></h4>
    <div style="color:#5F5F5F">Prueba presentada el: <?php echo $DatosPruUsu->pruUsuHoraInicio ?></div>
      <br>
      </div> 
       <div class="col-xs-12 col-xs-push-0 col-sm-3 col-md-push-1">
       <div class="puntosCirculo">
       <div style="font-size:2em; font-weight:bold;margin-top: 40px;
margin-left: 7px;" class="text-center"><?php 

 echo resPorcen( $totales->correctas , $totales->total);

 ?></div>
       </div>
       </div> 
       <div class="clearfix"></div> 
      <div class="col-xs-12 col-xs-push-0 col-md-10 col-md-push-1 ">    
 <table border="1" bordercolor="#C7C7C7" class="table table-condensed"> 
         <colgroup>
            <col width="20%">
            <col width="20%">
            <col width="20%">
            <col width="20%">
            <col width="20%">
            <col width="20%">
        </colgroup>    
        <thead>
           <tr style="background-color:#E8E8E8">
             <th style="padding:1px 5px" colspan="2" >Area y Competencia</th>
             <th style="padding:1px 5px" colspan="1">
             <span <?php echo resOk(1) ?>></span> Correctas</th>
             <th style="padding:1px 5px" colspan="1">
             <span <?php echo resOk(0) ?>></span> Erradas</th>
             <th style="padding:1px 5px" colspan="1">
             <span <?php echo resOk(2) ?>></span> Sin contestar</th>
             <th style="padding:1px 5px" colspan="1">Totales</th>
           </tr>
        </thead>
		<?php 	
        $resul = consultaSql("select pruid,usuid, area, competencia, sum(correctas) 'correctas', 
				sum(erradas)'erradas', sum(sinContestar)'sinContestar',count(pruid)'total' 
				from informepersonal where pruid = $pruid and usuid = $aprendiz
				group by area order by area, competencia;");

		 ?>
        <tbody>        
           <?php  while($res=$resul->fetch_object()){ ?> 
           <tr style=" background-color:#BFEEFC; font-weight:bold">
             <td colspan="2" style="font-size:1.4em;"><?php echo $res->area ?></td>             
             <td class="tdc"><?php echo $res->correctas ?></td>
             <td class="tdc"><?php echo $res->erradas ?></td>
             <td class="tdc"><?php echo $res->sinContestar ?></td>
             <td class="tdc"><?php echo $res->total ?></td>
           </tr>
 
 		<?php 
				
        $resul2 = consultaSql("select pruid,usuid, area, competencia, sum(correctas) 'correctas', 
			sum(erradas)'erradas', sum(sinContestar)'sinContestar',count(pruid)'total' 
			from informepersonal where pruid = $pruid and usuid = $aprendiz and area = '$res->area'
			group by competencia order by area, competencia;");

            while($res2=$resul2->fetch_object()){ ?> 
           <tr>
             <td colspan="2" style="font-size:1em;"><?php echo $res2->competencia ?></td>             <td class="tdc"><?php echo $res2->correctas ?></td>
             <td class="tdc"><?php echo $res2->erradas ?></td>
             <td class="tdc"><?php echo $res2->sinContestar ?></td>
             <td class="tdc"><?php echo $res2->total ?></td>
           </tr>

           <?php } //fin del segundo while
		   } //fin del primer while ?>

           <tr style="background-color:#299DFC; font-size:1.5em; font-weight:bold;">
             <td colspan="2" style="font-size:1em;">TOTALES</td>
             <td class="tdc"><?php echo $totales->correctas ?></td>
             <td class="tdc"><?php echo $totales->erradas ?></td>
             <td class="tdc"><?php echo $totales->sinContestar ?></td>
             <td class="tdc"><?php echo $totales->total ?></td>
           </tr>
			
        </tbody>
 </table>        
 
<hr>

      </div><!-- fin de col 12 -->
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