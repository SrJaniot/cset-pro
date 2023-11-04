<?php 
session_start();
extract ($_REQUEST);
include ("modelo/conexion.php");
/*esta linea valida que exista una sesion, si no existe me manda al index, ademas valida
que el rol seal el indicado para la pagina si no es asi igualmente me manda a index*/
if(!isset($_SESSION['usuId']) or $_SESSION['rol']!='aprendiz' 
or !isset($_GET['prueba']) or !is_numeric($_GET['prueba'])){ header('location:index.php'); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include 'inc/head.php'; ?>
<title>Presentando Prueba</title>
</head>

<body>
<?php 
include 'inc/header.php'; // cabecera de la pagina
 ?> 
<script src="js/kkcountdown.min.js"></script>
  <?php 

$nav=10 ; // esta variable indica la pasteña a la que se le modifica el css en el nav
include 'inc/nav.php'; //barra de navegacion
?>
<section id="section2" class="colorfondo" >
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <?php  
$aprendiz = $_SESSION['usuId'];
$pruid = $_GET['prueba'];
$tiempo = "0";

// datos de la prueba		
$datosPrueba = consultaSql("select * from prueba where pruid = $pruid");					
$datosPrueba = $datosPrueba->fetch_object();

// verifica si el usuario tiene asignada esta prueba
$existePruUsu = consultaSql("select COUNT(*) 'asignado' from pruebausuario where usuid = $aprendiz and pruid = $pruid");
$existePruUsu = $existePruUsu->fetch_object();

// verifica si la prueba tiene preguntas
$cantPreguntas = consultaSql("select count(*) 'cantPreguntas' from pruebapregunta where pruid = $pruid");
$cantPreguntas = $cantPreguntas->fetch_object();

//verifica la prueba tiene habilitada la hora para presetarla
$habilitada = consultaSql("select * from pruebahabilitada where pruid = $pruid;");
$habilitada = $habilitada->fetch_object();

//verifica si el aprendiz presento la prueba
$presento = consultaSql("select if(ifnull(UNIX_TIMESTAMP(pruusuhorainicio),0) = 0,'no','si') 'presento' from pruebausuario where usuid = $aprendiz and pruid = $pruid");
$presento = $presento->fetch_object();

//verifica que la prueba no este finalizada
$finalizado = consultaSql("select ((IFNULL(UNIX_TIMESTAMP(pruusuhorafin),
(UNIX_TIMESTAMP(CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-05:00'))+0)))
-(UNIX_TIMESTAMP(CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-05:00')))) 'restante' 
from pruebausuario 
where pruid = $pruid and usuid = $aprendiz;");
$finalizado = $finalizado->fetch_object();
 
	if(($existePruUsu->asignado) == 0){
		
		echo "<h3>No tiene esta prueba asignada</h3>";
	
	}elseif(($habilitada->habilitada) == "no" and $presento->presento == "no"){	
		
		echo "<h3>Esta prueba Solo esta habilitada desde el <b>$habilitada->prufechainicio </b>
		hasta el <b>$habilitada->prufechafin </b> </h3>";

	}elseif(($cantPreguntas->cantPreguntas) == "0"){	
		
		echo "<h3>Esta prueba no tiene preguntas asignadas </h3>";

	}elseif(($finalizado->restante) < 0){	
		 consola( "Finalizado hace = ". $finalizado->restante); ?> 
         
         <center><h3>Esta prueba ha sido finalizada con exito </h3>
          <?php if($datosPrueba->pruMostrarResultados){ 
					  
			$resultado = consultaSql("select 
			SUM(CASE WHEN opccorrecto = 1 THEN 1 ELSE 0 END) 'correctas',
			SUM(CASE WHEN opccorrecto = 0 THEN 1 ELSE 0 END) 'erradas',
			SUM(CASE WHEN opccorrecto >= 0 THEN 0 ELSE 1 END) 'sinContestar',
			count(usuid) 'total'
			from resultado 
			inner join opcion on resultado.opcId = opcion.opcId
			where pruid = $pruid and usuid = $aprendiz;");
			$resultado = $resultado->fetch_object();
		  ?> 
                     
<table border="1" bordercolor="#C7C7C7" >     
    <thead>
        <tr>
            <th style="padding:1px 5px" colspan="3" >Resultados Aprendiz</th>
            <th style="padding:1px 5px" colspan="1">Total</th>
            <th style="padding:1px 5px" colspan="1">Efectividad</th>
        </tr>
    </thead>

    <tbody>        
        <tr>
            <td style="padding:5px 5px 0px 5px;">
             <span class="glyphicon glyphicon-ok-sign" style="color: #26B328; font-size:1.4em;"
              title="Correctas" data-toggle="tooltip"></span>
            <b style="font-size:1.4em"><?php echo $resultado->correctas ?></b> </td>
            
            <td style="padding:5px 5px 0px 5px;">
            <span class="glyphicon glyphicon-remove-sign" style="color: #DD5B5B; font-size:1.4em;"
             title="Erradas" data-toggle="tooltip"></span>
            <b style="font-size:1.4em"><?php echo $resultado->erradas ?></b></td>
            
            <td style="padding:5px 5px 0px 5px;">
            <span class="glyphicon glyphicon-exclamation-sign" style="color: #A7A7A7; font-size:1.4em;" title="Sin Contestar" data-toggle="tooltip"></span>
            
            <b style="font-size:1.4em"><?php echo $resultado->sinContestar ?></b></td>
            <td style="padding:5px 5px 0px 5px;" >
            <center><b style="font-size:1.4em"><?php echo $resultado->total ?></b></center></td>
             <td style="padding:5px 5px 0px 5px;">
            <center><b style="font-size:1.4em"><?php echo resPorcen($resultado->correctas,$resultado->total) ?></b></center></td>
        </tr>
    </tbody>
</table>
			<br>
           <a href="informePersonal.php?pruid=<?php echo $pruid ?>&usuid=<?php echo $aprendiz ?>">
          	<button class="botonStandar3">&nbsp;&nbsp; Ver informe &nbsp;&nbsp;</button>
           </a>           
           
           </center>
           <?php }
}else{	
	
	//establece el tiempo en donde quedo el usuario la ultima vez q entro
	$tiempo = $finalizado->restante;
	
//consulta que agrega la hora de inicio de la prueba en la BD
// devuleve 1 si es nulo osea que no han iniciado la prueba

$iniciada = consultaSql("SELECT ISNULL(pruusuhorainicio) 'esnulo' FROM pruebausuario 
					WHERE pruId=$pruid 	AND usuId=$aprendiz;");
$iniciada = $iniciada->fetch_object()->esnulo;



	if($iniciada == 1)	{
		// primer ingreso a la prueba	
		
		consultaSql("UPDATE pruebausuario SET 
		pruUsuHoraInicio= $now,
		pruUsuHoraFin = ADDDATE($now, INTERVAL TIME_TO_SEC('$habilitada->pruTiempo') SECOND)		
		WHERE pruId=$pruid AND usuId=$aprendiz;");
		
		$tiempo = timeSec($habilitada->pruTiempo);
		
		// ciclo para ponerle posicion a todas las preguntas
		//echo $datosPrueba->pruMezclarPreguntas." mezclar <br>";
		
		if($datosPrueba->pruMezclarPreguntas){
			$posicionPreguntas = consultaSql("select pp.pruId, pp.preId, prearea, conid from pruebapregunta pp
								inner join pregunta on pp.preId = pregunta.preId
								where pruid = $pruid order by prearea, conid, RAND();");	
		}else{
			$posicionPreguntas = consultaSql("select * from pruebapregunta where pruid = $pruid order by prupreid;");
		}	
		
		
		//cicho q guarda el la bd la posicion de las preguntas random o no
		
		/*
		while($pos=$posicionPreguntas->fetch_object()){
		$pregunta = $pos->preId;
		$contador++;
		consultaSql("INSERT INTO resultado VALUES 
		(NULL, '$aprendiz', '$pruid', '$pregunta', NULL, '$contador', NULL, NULL);");
	
		}*/
							
		$contador = 0;
		$superSql = "INSERT INTO resultado VALUES ";
					
			 while($pp=$posicionPreguntas->fetch_object()){	
				$pregunta = $pp->preId;
				$contador++;		
				$superSql = $superSql."(NULL, '$aprendiz', '$pruid', '$pregunta', NULL, '$contador', NULL, NULL),";			
			} 

		$superSql = substr($superSql, 0, -1).";";
		//echo $superSql;
		$resFinal = consultaSql($superSql);
		$resFinal = ($resFinal)?"Preguntas asignadas por primera vez":"No iniciar la prueba";
		consola($resFinal);							
	}		
	
	
		////////////////////////////////////////////////////
		// desde aqui va el codigo para mostrar la prueba //	
		
		$preguntasListas = consultaSql("select * from resultado1 where usuid = $aprendiz and pruId = $pruid;");						
	while($preLis=$preguntasListas->fetch_object()){
		 ?>
        <div class="preContenedor">
          <div class="preBarra">
            <div style="display:inline"><?php echo  $preLis->resPosicionPregunta; ?></div>
            <div style="display:inline"><?php echo  $preLis->prearea." / ".$preLis->precompetencia; ?> &nbsp;&nbsp;&nbsp;</div>
            <?php if($preLis->conid!= ""){?>
            <div style="display:inline"> 
            <a href="vercontexto.php?contexto=<?php echo $preLis->conid?>" target="_blank"
             data-conid="<?php echo  $preLis->conid ?>" data-estado = "close">
              <button>Ver Contexto <?php echo  $preLis->conid; ?></button></a> 
              </div>
            <?php } ?>
            <div style="display:inline; font-weight:bold" >Sin responder</div>
          </div>
          <br>
          <div class="bloque" data-contexto="<?php echo $preLis->conid?>"></div>
          <div class="preContenido">
            <div><b><?php echo  str_replace("\n", "<br>", $preLis->prepregunta); ?></b></div>
            <?php if ($preLis->preimagen != ""){
				echo  '<div><img  class="img-responsive" src="img/pregunta/'.$preLis->preimagen.'" alt="imagen"></div>';
					}				
				 ?>
            <div><b><?php echo  str_replace("\n", "<br>", $preLis->prepospregunta); ?></b></div>
          </div>
          <br>
          <div class="opciones" id="<?php echo $preLis->resid ?>">
            <?php 
			//////////////////////////////////////////
			// MOSTRAR LA OPCIONES DE CADA PREGUNTA //
		$mezOpc = ($datosPrueba->pruMezclarOpciones)?" order by RAND()":"";
 		$opciones = consultaSql(" select * from opcion where preid = $preLis->preid $mezOpc; ");
			 
		$abc = 1;					
		while($opc=$opciones->fetch_object()){ ?>
            <?php  echo chr(64 + $abc) ?>
            <input  type="radio" 
            		id="<?php echo  $preLis->resid."-".$opc->opcId; ?>" 
                    name="opcionPre<?php echo  $preLis->resid; ?>" 
    			    value="<?php echo  $opc->opcId; ?>" class="">
                    
         <label for="<?php echo  $preLis->resid."-".$opc->opcId; ?>" style="font-weight:normal;">
            <?php echo $opc->opcOpcion ?> 
            </label>
            <br>
            <?php $abc++; } ?>
          </div>
        </div>
        <?php	
		echo "<hr>";
		}?>  
       <div class="col-xs-12">
        <button class="center-block botonStandar" id="btnFinalizar">
        <h4>&nbsp;&nbsp;&nbsp;Finalizar&nbsp;&nbsp;&nbsp;</h4>
        </button>
      </div>  
           
       <div class="timer" ><span id="x1">00:00:00</span>
      <span data-seconds="0" id="timerSecond" ></span></div>  
<?php }	?>
      </div>
      
    </div>
  </div>
</section>

<?php  include 'inc/footer.php'; //pie de pagina de la pagina?>

<script>
$(document).ready(function() {



console.log('<?php echo "tiempo = ". $tiempo." Finalizado ". $finalizado->restante ?>');

if( 0 <=<?php echo $finalizado->restante ?> ){
	$("#timerSecond").attr('data-seconds', <?php echo ($tiempo -1) ?>)
	$("#x1").text("<?php echo secToHora($tiempo) ?>");
	$("#timerSecond").hide();
	
	setTimeout(function() {
    	 $("#x1").text("");
		 $("#timerSecond").show();
	}, 1000);

	$("#timerSecond")
		.kkcountdown({
		hoursText	: ':',
		minutesText	: ':',
		displayZeroDays : false,
		textAfterCount: 'Fin del tiempo',
		warnSeconds : 8,
		warnClass   : 'red',
		callback  : function() {
			alert("EL tiempo se ha agotado, la prueba se finalizo automaticamente")
			window.location.reload();
			
		},
	});	
}
	
<?php  		
$seleccionados = consultaSql(" select * from resultado where pruid = $pruid and usuid = $aprendiz and opcid is not null; ");	 
					
		while($sel=$seleccionados->fetch_object()){ ?> 
		// esta funcion llena los checked que ya esten selecionados
		 var seleccionado = $("input[type=radio][value=<?php echo $sel->opcId ?>]");
			seleccionado.attr('checked', 'checked');
			seleccionado.parent().parent().children().first().children(":last-child").html("Guardado");			
		<?php }?>

$("input[type=radio]").change(function() {	
	var elemento = $(this);
	var opcid = $(this).val();
	var resid = $(this).parent().attr("id");
	var cajaOK = $(this).parent().parent().children().first().children(":last-child");
	cajaOK.html("enviando...");
		$.ajax({
			url: "controlador/procesaOpcion.php", 
			type: "POST", 
			data: {proceso:"establecer",opcid:opcid,resid:resid}, 
			success: function(datos){
				//alert(datos);
				cajaOK.html("Guardado");
				elemento.parent().parent().css("background-color","White")
				//selector.css("background-color", "red");
							
			}
		});	// fin ajax				
	}); // fin change

$("#btnFinalizar").click(function() {

	var sinResponder = 0;
	
	$('div.preContenedor > div:nth-child(1) div:last-child').each(function(indice, e) {

	  var elemento = $(e);
	  
	  if (elemento.text() != "Guardado") {
		  sinResponder ++;
		  elemento.parent().parent().css("background-color","#FEFFE4");
	  }
	    
	});

	var msj = "¿Desea Terminar y enviar la prueba?";
	
	if(sinResponder > 0){
		msj = "Tiene Preguntas sin responder, desea enviar de todas formas?";
	}	

	if(confirm(msj)){
		var usuario = <?php echo $aprendiz  ?>;
		var prueba = <?php echo $pruid  ?>;
		
		$.ajax({
			url: "controlador/procesaPresentando.php", 
			type: "POST", 
			data: {proceso:"terminar",pruid:prueba,usuid:usuario}, 
			success: function(datos){
				if(datos == "Prueba Terminada"){
					alert(datos);
					window.location.reload();
				}else{
					alert(datos);
				}											
			}
		});	// fin ajax				
	}
});

$("div[data-contexto]").hide();

$("a[data-conid]").click(function(e){	
//console.log($(this).data('estado'));
		
	e.preventDefault();
	var conid = $(this).data('conid');
	var contenedor = $(this).parent().parent().parent().children(":nth-child(3)");
	var boton = $(this).find("button");
	
	var aux = $(this).data('estado');
	if(aux == "open"){
		contenedor.slideUp(300);
		boton.html("Ver Contexto " + conid);
		$(this).data('estado', 'close');	
		
	}else{		
		$.ajax({
			url: "controlador/bloqueContexto.php", 
			type: "POST", 
			data: {conid:conid}, 
			success: function(datos){
				contenedor.html(datos);
				contenedor.slideDown(300);							
			}
		});	// fin ajax	
		boton.html("Ocultar");
		$(this).data('estado', 'open');
	}	
});



$("#creaPregunta").click(function () {
		var aux = $("#creaPregunta").val();
		if(aux == "open"){
			$("#crearPregunta").slideUp();
			$("#creaPregunta").html("<h4> &nbsp;&nbsp;Anadir Nueva Pregunta&nbsp;&nbsp; </h4>");
			$("#creaPregunta").attr("value", "close");	
		}else{
			$("#crearPregunta").slideDown();
			$("#creaPregunta").html("<h4> &nbsp;&nbsp;Ocultar&nbsp;&nbsp; </h4>");
			$("#creaPregunta").attr("value", "open");
		}	
	});



 	$(function () {
	  $('[data-toggle="tooltip"]').tooltip( {html:"true"})
	})

}); //fin del ready

</script>
</body>
</html>