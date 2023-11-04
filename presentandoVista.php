<?php 
session_start();
extract ($_REQUEST);
include ("modelo/conexion.php");
/*esta linea valida que exista una sesion, si no existe me manda al index, ademas valida
que el rol seal el indicado para la pagina si no es asi igualmente me manda a index*/
if(!isset($_SESSION['usuId']) or $_SESSION['rol']!='instructor' 
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
$pruid = $_GET['prueba'];

// datos de la prueba		
$datosPrueba = consultaSql("select * from prueba where pruid = $pruid");					
$datosPrueba = $datosPrueba->fetch_object();

// verifica si la prueba tiene preguntas
$cantPreguntas = consultaSql("select count(*) 'cantPreguntas' from pruebapregunta where pruid = $pruid");
$cantPreguntas = $cantPreguntas->fetch_object();


if(($cantPreguntas->cantPreguntas) == "0"){	
		
		echo "<h3>Esta prueba no tiene preguntas asignadas </h3>";

}else{	

		////////////////////////////////////////////////////
		// desde aqui va el codigo para mostrar la prueba //	
		
		$preguntasListas = consultaSql("select @num:=@num+1 'resPosicionPregunta', pr.preid,
		 pr.prearea, pr.precompetencia, pr.conid, pr.prepregunta, pr.preimagen, pr.prepospregunta
		  from pruebapregunta pp inner join pregunta pr on pp.preId = pr.preId, (SELECT @num:=0) r
		   where pp.pruId = $pruid order by prupreid ;");
								
	while($preLis=$preguntasListas->fetch_object()){
		 ?>
        <div class="preContenedor">
          <div class="preBarra">
            <div style="display:inline"><?php echo  $preLis->resPosicionPregunta; ?></div>
            <div style="display:inline"><?php echo  $preLis->prearea." / ".$preLis->precompetencia; ?> &nbsp;&nbsp;&nbsp;</div>
            <?php if($preLis->conid!= ""){?>
            <div style="display:inline"> 
            <a href="vercontexto.php?contexto=<?php echo $preLis->conid?>" target="_blank"
             data-conid="<?php echo  $preLis->conid ?>">
              <button>Contexto <?php echo  $preLis->conid; ?></button></a> 
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
 		$opciones = consultaSql(" select * from opcion where preid = $preLis->preid");
			 
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
<?php }	?>
      </div>
      
    </div>
  </div>
</section>

<?php  include 'inc/footer.php'; //pie de pagina de la pagina?>

<script>
$(document).ready(function() {

$("div[data-contexto]").hide();

$("a[data-conid]").click(function(e){
	e.preventDefault();
	 var conid = $(this).data('conid');
	 // aux = $(this);
	  var contenedor = $(this).parent().parent().parent().children(":nth-child(3)");
	  

		$.ajax({
			url: "controlador/bloqueContexto.php", 
			type: "POST", 
			data: {conid:conid}, 
			success: function(datos){
				console.log(conid);
				contenedor.html(datos);
				contenedor.slideDown(200);							
			}
		});	// fin ajax	
});
}); //fin del ready

</script>
</body>
</html>