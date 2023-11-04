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
	if($_SESSION['usuId']!= $aprendiz){header('location:index.php'); 
	}

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

ob_start();
?>
<style>
<!--
.fila {font-size: 12px;color: #7A7A7A; text-align:right}
.text-center {text-align: center;}
.pandding {padding:0px;margin:0px;}
table > tr > td { background-color:#D04447}
.wrap { margin:0 auto 0 auto; width:390px; }


#encabezado {padding:5px 0; border-top: 1px solid #7A7A7A; border-bottom: 1px solid #7A7A7A; width:100%;}
#encabezado .fila #col_1 {width: 5%}
#encabezado .fila #col_2 {width: 20%}
#encabezado .fila #col_3 {text-align:center; width: 40%}
#encabezado .fila #col_4 {width: 20%}
#encabezado .fila #col_5 {width: 15%}

#puntaje {width:100px; height:100px; 
background-color:<?php echo  color100($totales->correctas / $totales->total*100) ?>; 
position:absolute;right:0px; top:70px; border-radius:50px}

#puntajeValor {
	font-weight:bold; margin-top:37px; font-size:23px; 
	text-align:center; width:100px;  text-align:center; padding-left:5px
	}
-->
</style>
<page backtop="25mm" backbottom="20mm" backleft="25mm" backright="25mm">
<page_header> 
       <table id="encabezado">
            <tr class="fila">
                <td id="col_1" ></td>
                <td id="col_2">
					<img src="img/logoCP.png" width="100" height="65" alt=""/>
                </td>
                <td id="col_3">
                    <span id="span1"> </span><br>
                    <span id="span2"></span>
                </td>
                <td id="col_4">
					<img src="img/logoSenaNegro.png" width="65" height="65" alt=""/>
                </td>
                <td id="col_5"></td>
            </tr>
        </table>
</page_header>

<page_footer class="footer">
  <div class="fila"> 
Centro de servicios empresariales y turisticos CSET 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br> 
  Informe generado con el sistema CSETPRO &copy; el dia de
    <?php  $time = time();echo date("Y-m-d", $time)." a las ".date("H:i:s", $time); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </div>
</page_footer>
<?php /////////////////////////////////////////////////////////////////////////////////// ?>

<div id="puntaje"><h2 id="puntajeValor">
<?php echo resPorcen($totales->correctas , $totales->total) ?>
</h2></div>
<br>
<h2 class="text-center">Informe Personal Prueba </h2><br>

      <div>
        <div class="padding"><b><?php echo $dPru->pruNombre ?> (Id: <?php echo $pruid ?>)</b></div>      
        <div style="color:#606060;width:450px;">Descripcion: <?php echo $dPru->pruDescripcion ?></div>       <br>
        
        <div>Aprendiz: <b><?php echo $datosApre->usuNombre1." ".$datosApre->usuNombre2." ".$datosApre->usuApellido1." ".$datosApre->usuApellido2 ?></b></div>       
         <div>Documento: <b><?php echo $datosApre->usuTipoDoc." ".$datosApre->usuNumeroDoc ?></b>
          &nbsp;&nbsp; Ficha: <b><?php echo $datosApre->ficId ?></b></div>
           <div style="color:#5F5F5F; font-size:10px">Prueba presentada el: <?php echo $DatosPruUsu->pruUsuHoraInicio ?></div>
<br>
      </div>
      
      <div>
 <div >
      <table cellspacing="0" bordercolor="#C8C8C8" border="0.5">

           <tr style="background-color:#E8E8E8">
             <th style="padding:5px" >Area y Competencia</th>
             <th style="padding:5px" > Correctas</th>
             <th style="padding:5px" > Erradas</th>
             <th style="padding:5px" > Sin contestar</th>
             <th style="padding:5px" >Totales</th>
           </tr>
		<?php 	
        $resul = consultaSql("select pruid,usuid, area, competencia, sum(correctas) 'correctas', 
				sum(erradas)'erradas', sum(sinContestar)'sinContestar',count(pruid)'total' 
				from informepersonal where pruid = $pruid and usuid = $aprendiz
				group by area order by area, competencia;");

		 ?>
        
           <?php  while($res=$resul->fetch_object()){ ?> 
           <tr style=" background-color:#BFEEFC; font-weight:bold">
             <td  style="font-size:16px"><?php echo $res->area ?></td>             
             <td style="padding:4px; text-align:center"><?php echo $res->correctas ?></td>
             <td style="padding:4px; text-align:center"><?php echo $res->erradas ?></td>
             <td style="padding:4px; text-align:center"><?php echo $res->sinContestar ?></td>
             <td style="padding:4px; text-align:center"><?php echo $res->total ?></td>
           </tr>
		   <?php 
		    $resul2 = consultaSql("select pruid,usuid, area, competencia, sum(correctas) 'correctas', 
      sum(erradas)'erradas', sum(sinContestar)'sinContestar',count(pruid)'total' 
      from informepersonal where pruid = $pruid and usuid = $aprendiz and area = '$res->area'
      group by competencia order by area, competencia;");
		   
          while($res2=$resul2->fetch_object()){ ?> 
           <tr>
             <td style="font-size:1em;"><?php echo $res2->competencia ?></td>             
             <td style="padding:4px; text-align:center"><?php echo $res2->correctas ?></td>
             <td style="padding:4px; text-align:center"><?php echo $res2->erradas ?></td>
             <td style="padding:4px; text-align:center"><?php echo $res2->sinContestar ?></td>
             <td style="padding:4px; text-align:center"><?php echo $res2->total ?></td>
           </tr>

           <?php } //fin del segundo while
       } //fin del primer while ?>
           
           <tr style="background-color:#299DFC; font-size:1.5em; font-weight:bold;">
             <td style="padding:4px; text-align:center; font-size:18px">TOTALES</td>
             <td style="padding:4px; text-align:center"><?php echo $totales->correctas ?></td>
             <td style="padding:4px; text-align:center"><?php echo $totales->erradas ?></td>
             <td style="padding:4px; text-align:center"><?php echo $totales->sinContestar ?></td>
             <td style="padding:4px; text-align:center"><?php echo $totales->total ?></td>
           </tr>
      </table><br>

  </div>
      </div> 



</page>
<?php 

$contenido = ob_get_clean();
include ("modelo/html2pdf/html2pdf.class.php");
$pdf = new HTML2PDF('P', 'LETTER', 'es', 'UTF-8');
$pdf->writeHTML($contenido);
//$pdf->pdf->IncludeJS('print(TRUE)'); // para lanzar la impresora de inmediato
$nameFile = "informe_".$pruid."-".$datosApre->usuNumeroDoc."_".$datosApre->usuNombre1."_".$datosApre->usuApellido1;
$pdf->Output($nameFile.'.pdf');

 ?>
