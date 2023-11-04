<?php 
session_start();
extract ($_REQUEST);
include ("modelo/conexion.php");
/*esta linea valida que exista una sesion, si no existe me manda al index, ademas valida
que el rol seal el indicado para la pagina si no es asi igualmente me manda a index*/
if(!isset($_SESSION['usuId'])){ header('location:index.php'); }
if(!isset($_GET['id'])){ header('location:index.php'); }
if($_SESSION['rol']!='instructor' and $_SESSION['rol']!='consultor'){ header('location:index.php'); }?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include 'inc/head.php'; ?>


<title>Monitor de pruebas</title>
</head>

<body>
<?php 
include 'inc/header.php'; // cabecera de la pagina
$nav=10 ; // esta variable indica la pasteña a la que se le modifica el css en el nav
include 'inc/nav.php'; //barra de navegacion

$pruid = $_GET['id'];
?>
<section id="section2" class="colorfondo" >
  <div class="container" style="min-height: 600px;">
  

  
    <div class="row">
      <div class="col-xs-12">
        <?php $pru = consultaSql("select * from prueba3 inner join usuario on prueba3.prucreador = usuario.usuId where pruid = $pruid limit 1");
		if($pru->num_rows == 0){ header('location:index.php'); }		
			  $pru = $pru->fetch_object();

		 ?>
         
        <button id="btnInforme"  class="botonStandar3" style="position: absolute; right:0px">
        <h4>
        &nbsp; <span class="glyphicon glyphicon-book"></span> &nbsp;
        <span class="hidden-xs  visible-lg-inline ">Generar</span> 
        <span class="hidden-xs visible-md-inline visible-lg-inline "> Informes&nbsp;&nbsp;</span> </h4>
        </button>
                        
        <div class="text-center "> 
        <a href="monitorPrueba.php?id=<?php echo $pruid ?>" class="divpo"></a>
        <span id="cambiaMonitor" class="divpo"  style="font-size:0.9em;" data-toggle="tooltip" title="Click para cambiar al modo Normal">Monitor General de Prueba Extendido</span>
        
        </div>
        
        <div class="text-center" style="padding:0em 5em;"> 
        <span style="font-size:1.7em"><?php echo $pru->nombre ?>&nbsp;</span>
          <button id="mostrarPrueba" type="button" class="botonStandar" 
            style="padding: 2px;font-size: 1em;" > &nbsp;&nbsp;<span class="glyphiucon">+</span>&nbsp;&nbsp; </button>
        </div>
        <div class="bloque" id="infoPrueba" >
          <div class="col-xs-12"> <b>Descripcion: </b><?php echo $pru->prudescripcion." ( Id:".$pru->pruid.")" ?> <br>
          </div>
          <div class="col-xs-12"> <b>Creador: </b>
            <spam class="divpo" id="creador" data-usuid="<?php echo $pru->usuNumeroDoc ?>"><?php echo $pru->usuNombre1." ".$pru->usuNombre2.
		  " ".$pru->usuApellido1." ".$pru->usuApellido2." ( ".$pru->usuTipoDoc." ".$pru->usuNumeroDoc.")" ?></spam>
            <br>
            <br>
          </div>
          <div class="col-xs-4"> <?php echo "Creada: <b>".$pru->creado."</b><br>" ?> <?php echo "Inicio: <b>".$pru->inicio."</b><br>" ?> <?php echo "Fin: <b>".$pru->fin."</b><br>" ?> </div>
          <div class="col-xs-4"> <?php echo "Mezclar Preguntas: <b>".$pru->mezclarPreguntas."</b><br>" ?> <?php echo "Mezclar Opciones: <b>".$pru->mezclarOpciones."</b><br>" ?> <?php echo "Mostrar Resultados: <b>".$pru->mostrarResultados."</b><br>" ?> </div>
          <div class="col-xs-4"> <?php echo "Duracion: <b>".$pru->tiempo."</b><br>" ?> <?php echo "Preguntas: <b>".$pru->preguntas."</b><br>" ?> <?php echo "Aprendices: <b>".$pru->aprendices."</b><br>" ?> </div>
          <div class="clearfix"></div>
        </div>
        <br>
        <div class="table-responsive">
          <table id="example" class="table table-striped table-bordered table-hover table-condensed ">
            <thead>
              <tr>
                <th style="vertical-align:middle;" class="text-center" rowspan="2" colspan="3"> 
               <nobr> Filtrar por ficha    
        <select id="selFicha">
        <option value="todas">Todas</option>
          <?php $fichas = consultaSql("select DISTINCT(ficid) from pruebausuario pr inner join usuario us on pr.usuId = us.usuId where pr.pruId = $pruid order by ficid;");
		 while($res=$fichas->fetch_object()){?>
          <option value="<?php echo $res->ficid ?>"><?php echo $res->ficid ?></option>
          <?php } ?>
        </select> &nbsp; <span id="cantAprendices" style="color:#494949"></span> </nobr>
</th>
                <?php 
		 $preguntas = consultaSql("select pruid, prearea, if(precompetencia != '', precompetencia, 'general') 'competencia', pregunta.preid from pruebapregunta inner join pregunta on pruebapregunta.preId = pregunta.preId where pruebapregunta.pruId = $pruid order by prearea, competencia, preid;");
				?>
                <th style=" padding:0px" class="text-center" colspan="<?php echo $preguntas->num_rows; ?>">Preguntas</th>
                <th style="vertical-align:middle;" class="text-center" rowspan="3" colspan="4">
                Correctas /Erradas <br> /Sin contestar   % Efectividad</th>
              </tr>
              <tr>
             
              
                <?php 				
			$col1 = consultaSql("select pruebapregunta.pruId, prearea, count(prearea) 'colspan' from pruebapregunta
									inner join pregunta on pruebapregunta.preId = pregunta.preId 
									where pruebapregunta.pruId = $pruid GROUP BY prearea order by prearea;");	 
			 while($col=$col1->fetch_object()){?>
                <th style=" padding:0px" class="text-center" colspan="<?php echo $col->colspan ?>" > <?php echo $col->prearea ?></th>
                <?php }?>
              </tr>
              <tr>             
               <th style="vertical-align:middle;" class="text-center" rowspan="2"> 
                <span class="glyphicon glyphicon-chevron-down divpo" id="ascHora"  
                data-toggle="tooltip" title="Ordenar por hora de Fin de la prueba"></span></th>
                <th style="vertical-align:middle;" class="text-center" rowspan="2">USUARIO 
                <span class="glyphicon glyphicon-chevron-down divpo" id="ascUsuario"></span></th>
                <th style="vertical-align:middle;" class="text-center" rowspan="2"><nobr>Ficha
                <span class="glyphicon glyphicon-chevron-down divpo" id="ascFicha"></span></nobr></th>
              
                <?php 				
			$col2 = consultaSql("select pruebapregunta.pruId, prearea, if(precompetencia != '', precompetencia, 'general') 'competencia', count(precompetencia) 'colspan' from pruebapregunta inner join pregunta on pruebapregunta.preId = pregunta.preId where pruebapregunta.pruId = $pruid GROUP BY competencia order by prearea, competencia;");	 
			 while($col=$col2->fetch_object()){?>
                <th style=" padding:0px" class="text-center" colspan="<?php echo $col->colspan ?>" > <?php echo $col->competencia ?></th>
                <?php }?>
              </tr>
              <tr>
                <?php 		 
		 while($pre=$preguntas->fetch_object()){?>
                <th style=" padding:0px" class="text-center divpo" data-preid ="<?php echo $pre->preid ?>" > <?php echo $pre->preid ?></th>
                <?php }?>
                 <th style="padding:0px" class="text-center"><nobr>CO
                 <span class="glyphicon glyphicon-chevron-down divpo" id="ascCorrectas"></span></nobr></th>               
                 <th style="padding:0px" class="text-center"><nobr>ER
                 <span class="glyphicon glyphicon-chevron-down divpo" id="ascErradas"></span></nobr></th></th>               
                 <th style="padding:0px" class="text-center"><nobr>SC
                 <span class="glyphicon glyphicon-chevron-down divpo" id="ascSinContestar"></span></nobr></th></th>               
                               
                 <th style="padding:0px" class="text-center">EF</th>               
              </tr>
            </thead>
            <tbody id="tableScroll">
              <?php  
			$order = "order by Nombres asc";  
			if(isset($_GET['order'])){				  
				if($_GET['order'] == "ficha"){$order = "order by ficha, Nombres asc";
				}elseif($_GET['order'] == "horaFin"){$order = "order by horaFin desc, ficha, Nombres";
				}elseif($_GET['order'] == "correctas"){$order = "order by correctas desc, ficha, Nombres";
				}elseif($_GET['order'] == "erradas"){$order = "order by erradas desc, ficha, Nombres";
				}elseif($_GET['order'] == "sinContestar"){$order = "order by sinContestar desc, ficha, Nombres";
				}				  
			  }
			
			$filtro = " and ficha != '' ";
			if(isset($_GET['filtro'])){
				if($_GET['filtro'] != "todas")
					$filtro = " and ficha = '".$_GET['filtro']."' ";					
				}
			//echo "select * from consultor1 where pruId = $pruid $filtro $order;";
          $resultados = consultaSql("select * from consultor1 where pruId = $pruid $filtro $order;");
		  $cantAprendices = $resultados->num_rows;
		 
		 while($res=$resultados->fetch_object()){?>
              <tr>
                <?php 
			if($res->uFin < $res->uAhora and $res->uFin != 0) { 
				if($pru->usuId == $_SESSION['usuId'] or $_SESSION['rol'] == "consultor"){
					$color = "color:#0983F9; cursor:pointer";	 
				}else{
					$color = "color:#0983F9; cursor:default";	 
				}				
				$titulo = "Prueba terminada<br>Iniciado: $res->horaInicio<br>Finalizado: $res->horaFin";
			}elseif ($res->uInicio > 0) {
				if($pru->usuId == $_SESSION['usuId'] or $_SESSION['rol'] == "consultor"){
					$color = "color:#37D119; cursor:pointer";	 
				}else{
					$color = "color:#37D119; cursor:default";	 
				}	
				$titulo = "Presentando prueba... <br>Iniciado: $res->horaInicio";
			} else{
				$color = "color:Black; cursor:default;";	
				$titulo = "No ha iniciado la prueba";
			}?>
                <td data-usuidOpc ="<?php echo $res->usuId ?>">
                <span class="glyphicon glyphicon-list-alt" style="font-size:1.3em;<?php echo $color ?>" title="<?php echo $titulo ?>" data-toggle="tooltip" data-usuid = "<?php echo $res->usuId ?>"></span> </td>
                
                <td><nobr>
                 <span class="divpo" data-usuid = "<?php echo $res->usuNumeroDoc ?>"> <?php echo $res->Nombres." ".$res->Apellidos ?></span></nobr></td>
                
                <td><span style="color:rgba(126,126,126,1.00);"><?php echo $res->ficha ?></span></td>
                <?php 
			  // crear un array por cada grupo separado por comas	  
			  $areArray = explode(',',$res->area);
			  $comArray = explode(',',$res->competencia);
			  $preArray = explode(',',$res->pregunta);
			  $opcArray = explode(',',$res->opcion);
			  $resArray = explode(',',$res->respuesta);
			  
			  //definir el array bidimencional vario
			  $fullArray = array();
			  
			  //alimenar el arraybi con los otros array
			  for ($i = 0; $i < count($preArray); $i++) {
				$aux = array($areArray[$i],$comArray[$i],$preArray[$i],$opcArray[$i],$resArray[$i]);	
				array_push($fullArray, $aux);
				}
				// ordenar el arraybi asc por las preguntas

			  	array_multisort( array_column($fullArray, 2),SORT_ASC,SORT_NATURAL, $fullArray);
			  	array_multisort( array_column($fullArray, 1),SORT_ASC,SORT_NATURAL, $fullArray);
			  	array_multisort( array_column($fullArray, 0),SORT_ASC,SORT_NATURAL, $fullArray);
			
				
				// recorrer el arraybi y crear un td por cada iteracion						  
			   foreach($fullArray as $valor) {
					 ?>
                <td >
                <span 
                data-preid = "<?php echo $valor[2] ?>" 
                data-opcid = "<?php echo $valor[3] ?>"
				<?php echo resOk($valor[4]) ?> 
                data-toggle="tooltip"
                title="<?php echo $valor[0]." <br>".$valor[1]." <br> Id pregunta: ".$valor[2]."<br><b>". resOk2($valor[4])."</b>" ?>">
              
                  <div class="bajoDiv"><?php echo $valor[4] ?></div>
                  </span>
                  </td>
                <?php }?>
                
                
                <td class="text-center" style="font-size:1.3em; color:#00AB1E"><b>
				<?php echo $res->correctas ?></b></td>
                <td class="text-center" style="font-size:1.3em; color:#FF2124">
				<?php echo $res->erradas ?></td>
                <td class="text-center" style="font-size:1.3em; color:#6B6B6B">
				<?php echo $res->sinContestar ?></td>
                <td class="text-center" style="font-size:1.3em; color:#4B4B4B">
				<?php echo resPorcen($res->correctas, $res->cantidadPreguntas) ?></td                
              ></tr>
              <?php }?>
            </tbody>
          </table>
        </div>
       
      </div>
     <!-- <div class="clearfix"></div> --> 
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

$("#cambiaMonitor").click(function(){
	window.open("monitorPrueba.php" + location.search, "_self");
});

$("body").css('background-color','#FFFFFF');

$("#selFicha").val('<?php  if(isset($_GET['filtro'])) echo $_GET['filtro'] ?>');
console.log($("#selFicha").val());
if($("#selFicha").val() == null){$("#selFicha").val('todas');}

if("<?php echo $cantAprendices ?>" == 1){
	$("#cantAprendices").text("<?php echo $cantAprendices ?> Aprendiz");	
}else {
	$("#cantAprendices").text("<?php echo $cantAprendices ?> Aprendices");	
}



console.log("<?php echo $cantAprendices ?>");

$("#infoPrueba").hide();

$("#mostrarPrueba").attr("value", "close");

var url = ((location.pathname).split("/")).pop();

$("#ascHora").click(function () {
	var id = "<?php echo $pruid ?>";
	var sel = $("#selFicha").val();
	window.open(url + "?id="+ id + "&order=horaFin&filtro=" + sel, "_self");	
	});

$("#ascUsuario").click(function () {
	var id = "<?php echo $pruid ?>";
	var sel = $("#selFicha").val();
		window.open(url + "?id="+ id + "&order=usuario&filtro=" + sel, "_self");	
	});



$("#ascFicha").click(function () {
	var id = "<?php echo $pruid ?>";
	var sel = $("#selFicha").val();
		window.open(url + "?id="+ id + "&order=ficha&filtro=" + sel, "_self");	
	});
	
$("#ascCorrectas").click(function () {
	var id = "<?php echo $pruid ?>";
	var sel = $("#selFicha").val();
		window.open(url + "?id="+ id + "&order=correctas&filtro=" + sel, "_self");	
	});

$("#ascErradas").click(function () {
	var id = "<?php echo $pruid ?>";
	var sel = $("#selFicha").val();
		window.open(url + "?id="+ id + "&order=erradas&filtro=" + sel, "_self");	
	});

$("#ascSinContestar").click(function () {
	var id = "<?php echo $pruid ?>";
	var sel = $("#selFicha").val();
		window.open(url + "?id="+ id + "&order=sinContestar&filtro=" + sel, "_self");	
	});	

$("#selFicha").change(function () {
	var id = "<?php echo $pruid ?>";
	var order = "<?php  if(isset($_GET['filtro'])) echo $_GET['order']; else echo "usuario"; ?>";
	var sel = $("#selFicha").val();
	window.open(url + "?id="+ id + "&order=" + order + "&filtro=" + sel, "_self");
	});
	
$("#mostrarPrueba").click(function () {
		var aux = $("#mostrarPrueba").val();
		if(aux == "open"){
			$("#infoPrueba").slideUp();
			$("#mostrarPrueba").html("&nbsp;&nbsp;+&nbsp;&nbsp;");
			$("#mostrarPrueba").attr("value", "close");	
		}else{
			$("#infoPrueba").slideDown();
			$("#mostrarPrueba").html("&nbsp;&nbsp;-&nbsp;&nbsp;");
			$("#mostrarPrueba").attr("value", "open");
		}	
	});
	
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip( {html:"true"})
	})

	$('th[data-preid]').click(function (){
	
		
		var usuid =  <?php echo $_SESSION['usuId'] ?>;
		var pruid = "<?php echo $pruid ?>";
		var preid = $(this).data('preid');
		$("#loadingText").text("Cargando...");
		$("#loadingAjax").fadeIn(300);
		$.ajax({
			url: "controlador/procesaModal.php", 
			type: "POST", 
			data: {proceso:"pregunta",usuid:usuid,pruid:pruid,preid:preid}, 
			success: function(datos){
				$('#mContenido').html(datos)
				$('.modal-title').text("Informacion de la Pregunta")
				$("#loadingAjax").fadeOut(300);	
				$('#mVentana').modal('show')					
			}
		});	
	});
	
	$('span[data-preid]').click(function (){
	
		var usuid =  $(this).parent().parent().children("td:nth-child(1)").data("usuidopc");
		var pruid = "<?php echo $pruid ?>";
		var preid = $(this).data('preid');
		var opcid = $(this).data('opcid');

		if (opcid != 0) {
			$("#loadingText").text("Cargando...");
			$("#loadingAjax").fadeIn(300);
			$.ajax({
				url: "controlador/procesaModal.php", 
				type: "POST", 
				data: {proceso:"pregunta",usuid:usuid,pruid:pruid,preid:preid,opcid:opcid}, 
				success: function(datos){
					$('#mContenido').html(datos)
					$('.modal-title').text("Informacion de la Pregunta")
					$("#loadingAjax").fadeOut(300);	
					$('#mVentana').modal('show')					
				}
			});
		 }	
	});	
	
	$('#creador').click(function (){
	
		var id = $(this).data('usuid');
		$("#loadingText").text("Cargando...");
		$("#loadingAjax").fadeIn(300);
		$.ajax({
			url: "controlador/procesaModal.php", 
			type: "POST", 
			data: {proceso:"instructor",id:id}, 
			success: function(datos){
				$('#mContenido').html(datos)
				$('.modal-title').text("Informacion del Instructor")
				$("#loadingAjax").fadeOut(300);
				$('#mVentana').modal('show')		
			}
		});	
	});

	$('#btnInforme').click(function (){
	
		var id = '<?php echo $pruid ?>';
		$("#loadingText").text("Cargando...");
		$("#loadingAjax").fadeIn(300);
		$.ajax({
			url: "controlador/procesaModal.php", 
			type: "POST", 
			data: {proceso:"informe",pruid:id}, 
			success: function(datos){
				$('#mContenido').html(datos)
				$('.modal-title').text("Informes Disponibles")
				$("#loadingAjax").fadeOut(300);
				$('#mVentana').modal('show')		
			}
		});	
	});
	
	$('#example > tbody:nth-child(2) > tr > td:nth-child(2) > nobr> span:nth-child(1)').click(function (){

		var id = $(this).data('usuid');
		$("#loadingText").text("Cargando...");
		$("#loadingAjax").fadeIn(300);
			$.ajax({
				url: "controlador/procesaModal.php", 
				type: "POST", 
				data: {proceso:"aprendiz",id:id}, 
				success: function(datos){
					$('#mContenido').html(datos)
					$('.modal-title').text("Informacion del Aprendiz")
					$("#loadingAjax").fadeOut(300);
					$('#mVentana').modal('show')								
				}
			});	
		
		});
		
<?php if($pru->usuId == $_SESSION['usuId'] or $_SESSION['rol'] == "consultor"){ ?>

// selector q agraga modal al icono de la hora		
	$('.glyphicon-list-alt').click(function (){
				
		var puntero = $(this).css("cursor")
			
		if ( puntero == "pointer"){

				var usuid = $(this).data('usuid');
				var pruid = "<?php echo $pruid ?>";
				$("#loadingText").text("Cargando...");
				$("#loadingAjax").fadeIn(300);
				$.ajax({
					url: "controlador/procesaModal.php", 
					type: "POST", 
					data: {proceso:"tiempoAprendiz",usuid:usuid,pruid:pruid}, 
					success: function(datos){
						$('#mContenido').html(datos)
						$('.modal-title').text("Informacion de tiempos del Aprendiz")
						$("#loadingAjax").fadeOut(300);
						$('#mVentana').modal('show')													
					}
				});	// fin ajax										
				
		}	// fin if puntero
	}); // fin click list alt
<?php } ?>	
	
}); // document

</script>
</body>
</html>