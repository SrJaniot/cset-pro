<?php 
session_start();
extract ($_REQUEST);
require "modelo/conexion.php";
		
/*esta linea valida que exista una sesion, si no existe me manda al index, ademas valida
que el rol seal el indicado para la pagina si no es asi igualmente me manda a index*/
if(!isset($_SESSION['usuId']) or $_SESSION['rol']!='instructor'){ header('location:index.php'); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include 'inc/head.php'; ?>
<title>Administrar Prueba</title>
</head>

<body>
<?php 
include 'inc/header.php'; // cabecera de la pagina
$nav=10 ; // esta variable indica la pasteña a la que se le modifica el css en el nav
include 'inc/nav.php'; //barra de navegacion
?>
<section id="section2" class="colorfondo" >
  <div class="container">
    <?php 
// ajustar estas consultas
$id = $_GET['id'];
$resultado = consultaSql("select count(*) existe from prueba where pruId =$id;");
$resultado = $resultado->fetch_object()->existe;
if($resultado){
$resultado = consultaSql("select * from prueba where pruId = $id;");
$oRes = htmlDecode($resultado->fetch_object());
?>
    <div class="row">
      <div class="col-xs-12">
      <a href="monitorPrueba.php?id=<?php echo $id  ?>">
        <button type="button" class="botonStandar3" style="position: absolute; right:0px">
            <h4>&nbsp;<span class="glyphicon glyphicon-book"></span> 
            &nbsp;Resultados y reportes&nbsp;&nbsp; </h4>
        </button>      
      </a>
        <h2 class="text-center">Administrar Prueba</h2>
        <br>
        <ul class="nav nav-tabs " style="font-size:1.3em;">
          <li role="presentation" id="b1" class="active"><a href="#">General</a></li>
        
          <?php if($oRes->pruCreador == $_SESSION['usuId']){ ?>  
          <li role="presentation" id="b2"><a href="#">Editar</a></li>                       
          <li role="presentation" id="b3"><a href="#">Vincular Preguntas</a></li>
          <?php } ?>
          <li role="presentation" id="b4"><a href="#">Vincular Aprendices</a></li>
         <!--  <li role="presentation" id="b5"><a href="#">Ver Prueba</a></li> -->
          <?php if($oRes->pruCreador == $_SESSION['usuId']){ ?>  
          <li role="presentation" id="b6"><a href="#">Eliminar</a></li>
          <?php } ?>
        </ul>
        <div class="bloque2" id="crearPrueba">
          <div id="pes1" class="row">
            <div class="col-xs-8">
              <h2><?php echo $oRes->pruNombre; ?></h2>
            </div>
            <div class="col-xs-4">
              <h2>ID: <?php echo $oRes->pruId; ?></h2>
            </div>
            <div class="clearfix"></div>
            <div class="col-xs-12">
              <h4 style="color:#636363">Descripcion:</h4>
              <h3> <?php echo $oRes->pruDescripcion; ?></h3>
              <br>
            </div>
            <div class="col-xs-4">
              <h4 style="color:#636363;">Tiempo para presentar:</h4>
              <h3> <?php echo substr($oRes->pruTiempo,0,2)*60+substr($oRes->pruTiempo,3,2) ?> min </h3>
            </div>
            <div class="col-xs-4">
              <h4 style="color:#636363; ">habilitada desde:</h4>
              <h3 style=""> <?php echo $oRes->pruFechaInicio; ?></h3>
            </div>
            <div class="col-xs-4">
              <h4 style="color:#636363; ">habilitada hasta:</h4>
              <h3 style=""> <?php echo $oRes->pruFechaFin; ?></h3>
            </div>
            <div class="clearfix"></div>
            <div class="col-xs-8">
              <h4 style="color:#636363; ">Creado por:</h4>
              <?php 
			  $creador = $oRes->pruCreador;
              $creador = consultaSql("select * from usuario where usuId = $creador;");
			  $creador = $creador->fetch_object();			  
			  ?>
              <h3 > <?php echo $creador->usuNombre1; ?> <?php echo $creador->usuNombre2; ?> <?php echo $creador->usuApellido1; ?> <?php echo $creador->usuApellido2; ?> </h3>
            </div>
            <div class="col-xs-4">
              <h4 style="color:#636363; ">Creado el:</h4>
              <h3 > <?php echo $oRes->pruFechaCreacion; ?></h3>
            </div>
            <div class="col-xs-4">
              <h4 style="color:#636363; ">Mostrar Resultados:</h4>
              <h3 > <?php echo nosi($oRes->pruMostrarResultados); ?></h3>
            </div>
            <div class="col-xs-4">
              <h4 style="color:#636363; ">Mezclar Preguntas:</h4>
              <h3 > <?php echo nosi($oRes->pruMezclarPreguntas); ?></h3>
            </div>
            <div class="col-xs-4">
              <h4 style="color:#636363; ">Mezclar Opciones:</h4>
              <h3 > <?php echo nosi($oRes->pruMezclarOpciones); ?></h3>
            </div>
            <div class="col-xs-4">
              <h4 style="color:#636363; ">Preguntas Vinculadas:</h4>
              <?php 
			  $canPre = $oRes->pruId;
              $canPre = consultaSql("select count(*) 'cant' from pruebapregunta where pruId = $canPre;");
			  $canPre = $canPre->fetch_object();			  
			  ?>
              <h3 id="numeroPreVin"> <?php echo $canPre->cant; ?></h3>
            </div>
            <div class="col-xs-4">
              <h4 style="color:#636363; ">Aprendices Vinculados:</h4>
              <?php 
			  $canApr = $oRes->pruId;
              $canApr = consultaSql("select count(*) 'cant' from pruebausuario where pruId = $canApr;");
			  $canApr = $canApr->fetch_object();			  
			  ?>
              <h3 id="numeroAprVin"> <?php echo $canApr->cant; ?></h3>
            </div>
            <div class="col-xs-12">
            <br>
            <center><a href="presentandoVista.php?prueba=<?php echo $id ?>" target="_blank"><button class="botonStandar3"> <h4>&nbsp;&nbsp;Ver prueba como un aprendiz&nbsp;&nbsp;</h4></button></a></center>
            </div>
            
          </div>
          <div id="pes2" class="row">
            <h4 class="text-center"><b>Editar Prueba</b></h4>
            <form action="controlador/procesaPrueba.php" method="post" enctype="multipart/form-data" id="formPrueba">
              <input type="hidden" name="proceso" value="modificar">
              <input type="hidden" name="pruId">
              <input type="hidden" name="usuId" value="<?php echo $_SESSION['usuId'] ?>">
              <div class="col-xs-9">
                <label>
                <h4>Nombre de la prueba</h4>
                </label>
                <div class="form-group has-feedback mb">
                  <input type="text"  class="form-control input-lg has-error" placeholder="" name="nombre">
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <label class="control-label mb">
                  <h4 class="mb"></h4>
                  </label>
                </div>
                <h4></h4>
              </div>
              <div class="col-xs-3">
                <label>
                <h4>ID</h4>
                </label>
                <div class="form-group has-feedback mb">
                  <input type="text"  class="form-control input-lg has-error" placeholder="" name="idx">
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <label class="control-label mb">
                  <h4 class="mb"></h4>
                  </label>
                </div>
                <h4></h4>
              </div>
              <div class="col-xs-12">
                <label>
                <h4>Descripcion</h4>
                </label>
                <div class="form-group has-feedback mb">
                  <textarea rows="1" class="form-control input-lg has-error" placeholder="Describa en que consiste la prueba" name="descripcion"></textarea>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <label class="control-label mb">
                  <h4 class="mb"></h4>
                  </label>
                </div>
                <h4></h4>
              </div>
              <div class="col-xs-12 col-lg-4">
                <label>
                <h4>Tiempo maximo para presentar</h4>
                </label>
                <div class="form-group has-feedback mb">
                  <input type="text"  class="form-control input-lg has-error" placeholder="numero de minutos" name="tiempo">
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <label class="control-label mb">
                  <h4 class="mb"></h4>
                  </label>
                </div>
                <h4></h4>
              </div>
              <div class="col-xs-6 col-lg-2">
                <label>
                <h4>Habilitada desde</h4>
                </label>
                <div class="form-group has-feedback mb">
                  <input type="text"  class="form-control input-lg has-error" placeholder="AAAA/MM/DD" name="fecha1">
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <label class="control-label mb">
                  <h4 class="mb"></h4>
                  </label>
                </div>
                <h4></h4>
              </div>
              <div class="col-xs-6 col-lg-2">
                <label>
                <h4>Hora</h4>
                </label>
                <div class="form-group has-feedback mb">
                  <input type="text"  class="form-control input-lg has-error" placeholder="HH:MM" name="hora1">
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <label class="control-label mb">
                  <h4 class="mb"></h4>
                  </label>
                </div>
                <h4></h4>
              </div>
              <div class="col-xs-6 col-lg-2">
                <label>
                <h4>habilitada hasta</h4>
                </label>
                <div class="form-group has-feedback mb">
                  <input type="text"  class="form-control input-lg has-error" placeholder="AAAA/MM/DD" name="fecha2">
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <label class="control-label mb">
                  <h4 class="mb"></h4>
                  </label>
                </div>
                <h4></h4>
              </div>
              <div class="col-xs-6 col-lg-2">
                <label>
                <h4>Hora</h4>
                </label>
                <div class="form-group has-feedback mb">
                  <input type="text"  class="form-control input-lg has-error" placeholder="HH:MM" name="hora2">
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <label class="control-label mb">
                  <h4 class="mb"></h4>
                  </label>
                </div>
                <h4></h4>
              </div>
              <div class="col-xs-12 col-sm-4">
                <label >
                <h4>Mostrar resultados</h4>
                </label>
                <select class="form-control" name="mostrarResultados">
                  <option value="0">NO</option>
                  <option value="1">SI</option>
                </select>
              </div>
              <div class="col-xs-12 col-sm-4">
                <label >
                <h4>Mezclar Preguntas</h4>
                </label>
                <select class="form-control" name="mezclarPreguntas">
                  <option value="0">NO</option>
                  <option value="1">SI</option>
                </select>
              </div>
              <div class="col-xs-12 col-sm-4">
                <label >
                <h4>Mezclar opciones</h4>
                </label>
                <select class="form-control" name="mezclarOpciones">
                  <option value="0">NO</option>
                  <option value="1">SI</option>
                </select>
              </div>
              <div class="clearfix"></div>
              <br>
              <div class="col-xs-6"> <a href="cruds.php?tab=auxiliar"> <img  id="loadCrearPrueba" class="loading" src= 'img/load.gif'>
                <button type="button" class="botonStandar2" style="float:right">
                <h4> &nbsp;<span class="glyphicon glyphicon-share-alt invertirH" aria-hidden="true"></span> &nbsp;Cancelar&nbsp;&nbsp;&nbsp;&nbsp; </h4>
                </button>
                </a> </div>
              <div class="col-xs-6">
                <button type="button" class="botonStandar" id="enviaPrueba">
                <h4> &nbsp;&nbsp;&nbsp;&nbsp;Editar Prueba&nbsp;&nbsp;&nbsp;&nbsp; </h4>
                </button>
                <br>
              </div>
              <div class="clearfix"></div>
              <br>
            </form>
          </div>
          <div id="pes3" class="row">
            <div class="col-xs-12">
              <h4>Agregue preguntas a esta prueba dando doble clic a las filas en la siguiente tabla, las preguntas selecionadas se enlistaran debajo de ella, desde alli puede eliminar la vinculacion.</h4>
              <hr>
              <div class="table-responsive">
              <table id="tablaPreguntas" class="display" cellspacing="0" width="100%" >
                <thead>
                  <tr>
                    <?php $resultado = consultaColumnasth('pregunta1');?>
                  </tr>
                </thead>
              </table>
              </div>
              <br>
              <div id="preguntasVinculadas"></div>
            </div>
          </div>
          <!-- pes 3-->
          
          <div id="pes4" class="row">
         
            <div class="col-xs-12">
              <h4>Vincule todos los aprendices de una ficha</h4>
              <div class="clearfix"></div>
              <div class="col-xs-8">
                <select class="form-control" name="ficid">
                  <?php $fichas = consultaSql("select `numero ficha` 'numero', `nombre del programa` 'nombre', aprendices from ficha1 where aprendices > 0 and estado = 'Activo';");
					 while($fic=$fichas->fetch_object()){?>
                  <option value="<?php echo $fic->numero ?>"><?php echo $fic->numero." - ".$fic->nombre." (".$fic->aprendices.")" ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-xs-4">
                <button class="botonStandar" type="button" id="btnVincular">
                <h4>&nbsp;&nbsp;Vincular&nbsp;&nbsp;</h4></button>
              </div>
              <div class="clearfix"></div>
              <hr>
              <h4>Agregue aprendices individualmente a esta prueba dando doble clic a las filas en la siguiente tabla, los aprendices selecionadas se enlistaran debajo de ella, desde alli puede eliminar la vinculacion.</h4>
              <div style="border-bottom: solid 1px #EEEEEE; "></div>
              <br>
              <div class="table-responsive">
              <table id="tablaUsuarios" class="display" cellspacing="0" width="100%" >
                <thead>
                  <tr>
                    <?php $resultado = consultaColumnasth('usuario3');?>
                  </tr>
              </table>
              </div>
              <br>
              
            </div>
            <div class="col-xs-12">
          	  <div id="usuariosVinculados"></div>
            </div>
          </div>
          
          <!-- pes 4-->
          <!--  <div id="pes5" class="row">Vista de la prueba igual al aprendiz</div>-->
          <!-- pes 5-->
          <div id="pes6" class="row">
            <div class="col-xs-12">
              <h3 class="text-center"> ¿Esta seguro que desea eliminar esta prueba? <br>
                <br>
                Se eliminaran las vinculaciones de esta prueba con las preguntas y los aprendices, 
                pero las preguntas y los aprendices seguiran existiendo en la base de datos</h3>
              <br>
            </div>
            <div class="col-xs-12">
              <form id="formEliminar">
                <input type="hidden" name="proceso" value="eliminar">
                <input type="hidden" name="id" value="<?php echo $oRes->pruId;?>">
                <button type="button" class="botonStandar2 center-block" id="btnEliminar">
                <h4> &nbsp; <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> &nbsp;Eliminar&nbsp;&nbsp; </h4>
                </button>
              </form>
            </div>
          </div>
          <!-- pes 6 --> 
        </div>
        <!-- fin bloque prueba --> 
        
      </div>
    </div>
    <script>
	
$(document).ready(function() {
	
<?php if($oRes->pruCreador != $_SESSION['usuId']){ ?>

	$("#b4 > a").text("Aprendices habilitados");
	$("#pes4 > div:nth-child(1)").hide();

 <?php } ?>
 
	function botonNav(seleccion){
		$(seleccion).addClass("active");
		$(seleccion).siblings().removeClass("active"); 
		$("#pes1").hide();
		$("#pes2").hide();
		$("#pes3").hide();
		$("#pes4").hide();
		//$("#pes5").hide();
		$("#pes6").hide();		
	}
		
	$("#pes2").hide();
	$("#pes3").hide();
	$("#pes4").hide();
	//$("#pes5").hide();
	$("#pes6").hide();		
	
	$("#b1").click(function (){botonNav(this);$("#pes1").show() });
	$("#b2").click(function (){botonNav(this);$("#pes2").show() });
	$("#b3").click(function (){botonNav(this);$("#pes3").show() });
	$("#b4").click(function (){botonNav(this);$("#pes4").show() });
	//$("#b5").click(function (){botonNav(this);$("#pes5").show() });
	$("#b6").click(function (){botonNav(this);$("#pes6").show() });

//funcion para eliminar una prueba
$("#btnEliminar").click(function (){	

		var formData = new FormData ($("#formEliminar")[0]) ;			 					
		
		$.ajax({
			url: "controlador/procesaPrueba.php", 
			type: "POST", 
			data: formData, 
			contentType: false, 
			processData: false, 
			success: function(datos){
				
				if(datos == "Eliminacion ejecutada correctamente")
				{
					alert(datos);
					window.location="index.php";			
				}	else {
					alert(datos);
					}							
			}
		});	// fin ajax		
	});


//funcion para recargar el numero de preguntas vinculadas
$("#b1").click(function (){	
	var cantidad = $("#preguntasVinculadas > table > tbody >tr").length;
	$("#numeroPreVin").text(cantidad);	
	var cantidad2 = $("#usuariosVinculados > table > tbody >tr").length;
	$("#numeroAprVin").text(cantidad2);		
	});	
	
	$("input[name=pruId]").val("<?php echo $oRes->pruId; ?>");
	$("input[name=idx]").val("<?php echo $oRes->pruId; ?>");
	$("input[name=idx]").prop('disabled', 'disabled');	
	$("input[name=nombre]").val("<?php echo $oRes->pruNombre; ?>");
	$("textarea[name=descripcion]").val("<?php echo $oRes->pruDescripcion; ?>");
	
	
	$("input[name=tiempo]").val("<?php echo substr($oRes->pruTiempo,0,2)*60+substr($oRes->pruTiempo,3,2) ?>");
	$("input[name=fecha1]").val("<?php echo substr($oRes->pruFechaInicio,0,10); ?>");
	$("input[name=hora1]").val("<?php echo substr($oRes->pruFechaInicio,11,5) ?>");
	$("input[name=fecha2]").val("<?php echo substr($oRes->pruFechaFin,0,10); ?>");
	$("input[name=hora2]").val("<?php echo substr($oRes->pruFechaFin,11,5); ?>");

	$("select[name=mostrarResultados]").val("<?php echo $oRes->pruMostrarResultados; ?>");
	$("select[name=mezclarPreguntas]").val("<?php echo $oRes->pruMezclarPreguntas ?>");
	$("select[name=mezclarOpciones]").val("<?php echo $oRes->pruMezclarOpciones; ?>");
	
// ********************** funcion validar selector,numeros,letras,decimales,min,max,valormax,especial
	$("input[name=nombre]").keyup(function (){validar(this,0,0,0,1, 90,0,0)});			
	$("textarea[name=descripcion]").keyup(function (){validar(this,0,0,0,0, 450,0,0)});			
	$("input[name=tiempo]").keyup(function (){validar(this,1,0,0,1, 3,240,0)});			
	$("input[name=fecha1]").keyup(function (){validar(this,0,0,0,1,10,0,3)});			
	$("input[name=fecha2]").keyup(function (){validar(this,0,0,0,1,10,0,3)});			
	$("input[name=hora1]").keyup(function (){validar(this,0,0,0,1,5,0,4)});			
	$("input[name=hora2]").keyup(function (){validar(this,0,0,0,1,5,0,4)});			

$("#loadCrearPrueba").hide()	
$("#enviaPrueba").click(function () {
	
	var v1 = validar("input[name=nombre]"        ,0,0,0,1, 90,0,0);			
	var v2 = validar("textarea[name=descripcion]",0,0,0,0,450,0,0);			
	var v3 = validar("input[name=tiempo]"        ,1,0,0,1,  3,240,0);			
	var v4 = validar("input[name=fecha1]"        ,0,0,0,0, 10,0,3);			
	var v5 = validar("input[name=fecha2]"        ,0,0,0,0, 10,0,3);			
	var v6 = validar("input[name=hora1]"         ,0,0,0,0,  5,0,4);			
	var v7 = validar("input[name=hora2]"         ,0,0,0,0,  5,0,4);			
	
	if ( v1 && v2 && v3 && v4 && v5 && v6 && v7 ) {
		
		var formData = new FormData ($("#formPrueba")[0]) ;			 			

		$("#loadCrearPrueba").show()

		$.ajax({
			url: "controlador/procesaPrueba.php", 
			type: "POST", 
			data: formData, 
			contentType: false, 
			processData: false, 
			success: function(datos){
				$("#loadCrearPrueba").hide()
				alert(datos);
				if (datos == "modificacion ejecutada correctamente") {
						window.open("editarPrueba.php?id=<?php echo $id ?>", "_self");
					}						
			}
		});	// fin ajax				

		}else{
			alert("Hay campos con errores por favor verifique")					
		}
	
	}); // fin envio prueba

	$('#tablaPreguntas').dataTable( {
		"processing": true,
		"serverSide": true,
		"ajax": "modelo/server_processing.php?t=pregunta1",		
		"lengthMenu": [[10, 30, 50, 100], [10, 30, 50, 100]],
		 "pagingType": "full_numbers",
		//"scrollX": true,		
		"language": idiomaDT, 
	} );//datatable
	
   var table = $('#tablaPreguntas').DataTable();   
	$('#tablaPreguntas tbody').on( 'click', 'tr', function () {
	 if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }	
	});
	
	$('#tablaPreguntas tbody').on( 'click', 'tr', function () {
		if ( $(this).hasClass('selected') == false ) {
		var id = $( this ).children(":first").text() ;
		var prueba = "<?php echo $oRes->pruId; ?>";
			if(!isNaN(id)){
				$("#loadingText").text("Vinculando...");
				$("#loadingAjax").fadeIn(300);
				$.ajax({
					url: "controlador/procesaPrueba.php", 
					type: "POST", 
					data: {proceso:"vinPregunta",prueba:prueba,id:id}, 
					success: function(datos){
						//$("#loadingText").text("Listo!");
						$("#loadingAjax").fadeOut(300);
						$("#preguntasVinculadas").html(datos);
									
					}
				});	// fin ajax		
			}		
		}		
	});	

	$('#tablaUsuarios').dataTable( {
		"processing": true,
		"serverSide": true,
		"ajax": "modelo/server_processing.php?t=usuario3",		
		"lengthMenu": [[10, 30, 50, 100], [10, 30, 50, 100]],
		 "pagingType": "full_numbers",
		//"scrollX": true,		
		"language": idiomaDT, 
	} );//datatable
	
   var table2 = $('#tablaUsuarios').DataTable();   
	$('#tablaUsuarios tbody').on( 'click', 'tr', function () {
	 if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table2.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }	
	});
	
	$('#tablaUsuarios tbody').on( 'click', 'tr', function () {
		if ( $(this).hasClass('selected') == false ) {
		var id = $( this ).children(":first").text() ;
		id = id.split(" ");
		id = id[0];
		$("#loadingText").text("Vinculando...");
		$("#loadingAjax").fadeIn(300);		
		var prueba = "<?php echo $oRes->pruId; ?>";
			if(!isNaN(id)){
				$.ajax({
					url: "controlador/procesaPrueba.php", 
					type: "POST", 
					data: {proceso:"vinUsuario",prueba:prueba,id:id}, 
					success: function(datos){
						$("#loadingAjax").fadeOut(300);
						$("#usuariosVinculados").html(datos);								
					}
				});	// fin ajax		
			}		
		}		
	});	
	
	var prueba = "<?php echo $oRes->pruId; ?>";
	$.ajax({
		url: "controlador/procesaPrueba.php", 
		type: "POST", 
		data: {proceso:"vinPregunta",prueba:prueba,id:"0"}, 
		success: function(datos){
			$("#preguntasVinculadas").html(datos);					
		}
	});	// fin ajax	

	$.ajax({
		url: "controlador/procesaPrueba.php", 
		type: "POST", 
		data: {proceso:"vinUsuario",prueba:prueba,id:"0"}, 
		success: function(datos){
			$("#usuariosVinculados").html(datos);
			
	<?php if($oRes->pruCreador != $_SESSION['usuId']){ ?>

	//$('button[name=desvinculaPregunta]').hide();
    $('#usuariosVinculados > table > thead > tr > th:nth-child(6)').hide();
	$('#usuariosVinculados > table > tbody > tr > td:nth-child(6)').hide();

 <?php } ?>
								
		}
	});	// fin ajax	

$("#btnVincular").click(function () {

	var ficid = $('select[name=ficid]').val();
	var pruid = "<?php echo $oRes->pruId; ?>";
	//alert('ok ' + prueba + ' - ' + ficid);	
		$("#loadingText").text("Vinculando Ficha...");
		$("#loadingAjax").fadeIn(300);
		$.ajax({
			url: "controlador/procesaPrueba.php", 
			type: "POST", 
			data: {proceso:"vinFicha",pruid:pruid,ficid:ficid}, 
			success: function(datos){					
				$("#loadingAjax").fadeOut(300);
			
				
			// esta nueva consulta ajax es para recargar la tabla de aprendices vinculados	
				$.ajax({
					url: "controlador/procesaPrueba.php", 
					type: "POST", 
					data: {proceso:"vinUsuario",prueba:prueba,id:"0"}, 
					success: function(datos){
						$("#usuariosVinculados").html(datos);					
					}
				});	// fin segundo ajax	
				
				console.log(datos);							
			}
		});	// fin ajax	/
	}); // fin click


});	
</script>
    <?php 
}else{
echo"<br><h2 class='text-center'>El ID no existe en la tabla Pruebas</h2> <br>";
 ?>
    <a href="index.php">
    <button class="botonStandar center-block" type="button">
    <h4> &nbsp;&nbsp; Regresar &nbsp;&nbsp; </h4>
    </button>
    <br>
    </a>
    <?php  		
	}	
 ?>
  </div>
</section >
<?php  include 'inc/footer.php'; //pie de pagina de la pagina?>
</body>
</html>