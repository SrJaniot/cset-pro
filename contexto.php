<?php 
session_start();
extract ($_REQUEST);
include ("modelo/conexion.php");
/*esta linea valida que exista una sesion, si no existe me manda al index, ademas valida
que el rol seal el indicado para la pagina si no es asi igualmente me manda a index*/
if(!isset($_SESSION['usuId']) or $_SESSION['rol']!='instructor'){ header('location:index.php'); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include 'inc/head.php'; ?>
<title>Contexto de Preguntas</title>
</head>

<body >
<?php 
include 'inc/header.php'; // cabecera de la pagina
$nav=22 ; // esta variable indica la pasteña a la que se le modifica el css en el nav
include 'inc/nav.php'; //barra de navegacion
?>
<section id="section2" class="colorfondo" >
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <button id="creaContexto" type="button" class="botonStandar" style="position: absolute; right:0px">
        <h4> &nbsp;&nbsp;Anadir Contexto Nuevo&nbsp;&nbsp; </h4>
        </button>
        <h1 class="text-center" >Contextos de Preguntas</h1>
        <br>
        <div class="bloque" id="crearContexto">
          <h4 class="text-center"><b>Crear Nuevo Contexto</b></h4>
          <form action="controlador/procesaContexto.php" method="post" enctype="multipart/form-data" id="formContexto">
            <input type="hidden" name="proceso" value="agregar">
            <input type="hidden" name="usuId" value="<?php echo $_SESSION['usuId'] ?>">
            <div class="col-xs-12 col-sm-10 col-sm-push-1">
              <label>
              <h4>Contexto</h4>
              </label>
              <div class="form-group has-feedback mb">
                <textarea rows="1" class="form-control input-lg has-error" placeholder="Digite aqui el contexto a crear" name="contexto1"></textarea>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <label class="control-label mb">
                <h4 class="mb"></h4>
                </label>
              </div>
              <h4></h4>
            </div>
            <div class="col-xs-12 col-sm-10 col-sm-push-1">
              <label>
              <h4>Agregar una imagen (Opcional)</h4>
              </label>
              <h4 style="color:#787878;">
                <input type="file" name="imagen">
              </h4>
              <br>
            </div>
            <div class="col-xs-12 col-sm-10 col-sm-push-1">
              <label>
              <h4>Contexto posterior a la imagen (Opcional) </h4>
              </label>
              <div class="form-group has-feedback mb">
                <textarea rows="1" class="form-control input-lg has-error" placeholder="Digite aqui la segunda parte del contexto (aparecera despues de la imagen)" name="contexto2"></textarea>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <label class="control-label mb">
                <h4 class="mb"></h4>
                </label>
              </div>
              <h4></h4>
            </div>
            <div class="col-xs-12 col-sm-10 col-sm-push-1">
                <label>
                    <h4>Fuente</h4>
                </label>
                <div class="form-group has-feedback mb">
                    <input type="text"  class="form-control input-lg has-error" placeholder="De donde fue sacado este contexto" name="fuente">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    <label class="control-label mb">
                        <h4 class="mb"></h4>
                    </label>
                </div>
                <h4></h4>
            </div>
            
            <div class="clearfix"></div>
            <br>
            <div class="col-xs-12"> <img  id="load" class="loading" src= 'img/load.gif'>
              <button type="button" class="botonStandar center-block" id="enviaContexto">
              <h4> &nbsp;&nbsp;&nbsp;&nbsp;Crear Contexto&nbsp;&nbsp;&nbsp;&nbsp; </h4>
              </button>
            </div>
            <div class="clearfix"></div>
            <br>
          </form>
        </div>
        <!-- fin bloque contexto --> 
        <br>
        <table id="example" class="display" cellspacing="0" width="100%">
          <thead>
            <tr id ="filaTabla">
              <?php $resultado = consultaColumnasth('contexto1');?>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <?php $resultado = consultaColumnasth('contexto1');?>
            </tr>
          </tfoot>
        </table>
        <br>
        <div class="bloque col-xs-12" id="verContexto" >

        </div>
      </div>
    </div>
  </div>
</section>
<?php  include 'inc/footer.php'; //pie de pagina de la pagina?>
<script>
$(document).ready(function() {
	
	$("#crearContexto").hide();
	$("#load").hide();
	$("#verContexto").hide();

$("#creaContexto").attr("value", "close");
$("#creaContexto").click(function () {
		var aux = $("#creaContexto").val();
		if(aux == "open"){
			$("#crearContexto").slideUp();
			$("#creaContexto").html("<h4> &nbsp;&nbsp;Anadir Nuevo Contexto&nbsp;&nbsp; </h4>");
			$("#creaContexto").attr("value", "close");	
		}else{
			$("#crearContexto").slideDown();
			$("#creaContexto").html("<h4> &nbsp;&nbsp;Ocultar&nbsp;&nbsp; </h4>");
			$("#creaContexto").attr("value", "open");
		}	
	});
		
	
	$('#example').dataTable( {
		//"destroy": true,
		//configuraciones para conectar al server
		"processing": true,
		"serverSide": true,
		"ajax": "modelo/server_processing.php?t=contexto1",
		
		//longitud de la consulta "-1 para mostrar todos los registros"
		"lengthMenu": [[5,15, 30, 50, 100], [5,15, 30, 50, 100]],
		//paga que hacer visibles los botones "primero" y "ultimo"
		 "pagingType": "full_numbers",
		 // mostrar el scroll horizontal
		"scrollX": true,
		
		//configuraciones para cambiar idioma de etiquetas
		"language":  idiomaDT, 
	} );//datatable
	

	
	var table = $('#example').DataTable();
   
	$('#example tbody').on( 'click', 'tr', function () {

	 if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
				var id = $( this ).children(":first").text() 
				$('#conId').text(id);	
			$.ajax({
				url: "controlador/procesaContexto.php", 
				type: "POST", 
				data: {proceso:"consultar",id:id}, 
				success: function(datos){
						$("#verContexto").slideDown();
						$("#verContexto").html(datos);
						    $("html,body").animate({
							scrollTop: $("#verContexto").offset().top
						}, 250);
						
						$("#eliminaContexto").click(function () {						
							if(confirm("¿Desea eliminar este Contexto?")){
								$.ajax({
									url: "controlador/procesaContexto.php", 
									type: "POST", 
									data: {proceso:"eliminar",id:id}, 
									success: function(datos){
										if(datos){
											$("#verContexto").slideUp();
											
										}else{
											alert("Ocurrio un error al intentar eliminar")
										}												
									}
								});									
							}
						});			
				}
			});									
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
			

        }	
	}); // fin if hasclass
		
	$("textarea[name=contexto1]").keyup(function (){validar(this,0,0,0,1,3500,0,0)});			
	$("textarea[name=contexto2]").keyup(function (){validar(this,0,0,0,0,3500,0,0)});			
	$("input[name=fuente]").keyup(function (){validar(this,0,0,0,0,200,0,0)});			
		
	$("#enviaContexto").click(function () {

	var v1= validar("textarea[name=contexto1]",0,0,0,1,3500,0,0);	
	var v2= validar("textarea[name=contexto2]",0,0,0,0,3500,0,0);	
	var v3= validar("input[name=fuente]",0,0,0,0,200,0,0);	
	var ext = $('input[name=imagen]').val().split('.').pop().toLowerCase(); 

	if ( v1 ==false || v2==false || v3==false) {
		
		alert("Hay campos con errores por favor verifique")	
			
	}else if($("input[name=imagen]").val()!='' && 
	$.inArray(ext, ['png','jpg','jpeg']) == -1){
				
		alert('La imagen debe ser en formato jpg o png');
		
	}else if($("input[name=imagen]").val()!='' && 
	$('input[name=imagen]')[0].files[0].size > 2100000){
				
		alert('La imagen debe pesar menos de 2 MegaBytes');
					
	}else{
		var formData = new FormData ($("#formContexto")[0]) ;			 			

		$("#load").show()
		$.ajax({
			url: "controlador/procesaContexto.php", 
			type: "POST", 
			data: formData, 
			contentType: false, 
			processData: false, 
			success: function(datos){
					$("#load").hide()
					alert(datos);			
			if(datos == "insercion ejecutada correctamente"){
					$("#crearContexto").slideUp();	
					$("textarea[name=contexto1]").val("");			
					$("textarea[name=contexto2]").val("");						
					$("input[name=fuente]").val("");						
					$("input[name=imagen]").val("");	
		$("#creaContexto").html("<h4> &nbsp;&nbsp;Anadir Nuevo Contexto&nbsp;&nbsp; </h4>");
			$("#creaContexto").attr("value", "close");				
			$('#filaTabla > th:nth-child(2)').trigger('click');
			$('#filaTabla > th:nth-child(1)').trigger('click');
			$('#filaTabla > th:nth-child(1)').trigger('click');
				} // fin if			
			}
		});			
	}
		
	}); // fin envio contexto
}); // fin ready
</script>
</body>
</html>