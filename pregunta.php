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
	<title>Preguntas</title>
</head>

<body>
	<?php 
include 'inc/header.php'; // cabecera de la pagina
$nav=21 ; // esta variable indica la pasteña a la que se le modifica el css en el nav
include 'inc/nav.php'; //barra de navegacion
?>
<section id="section2" class="colorfondo" >
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<button id="creaPregunta" type="button" class="botonStandar" style="position: absolute; right:0px">
					<h4> &nbsp;&nbsp;Anadir Pregunta Nueva&nbsp;&nbsp; </h4>
				</button>
				<h1 class="text-center" >Preguntas</h1>
				<br>
				<div class="bloque" id="crearPregunta">
					<h4 class="text-center"><b>Crear Nueva Pregunta</b></h4>
					<form action="controlador/procesaPregunta.php" method="post" enctype="multipart/form-data" id="formPregunta">
						<input type="hidden" name="proceso" value="agregar">
						<input type="hidden" name="usuId" value="<?php echo $_SESSION['usuId'] ?>">
						<div class="col-xs-12 col-sm-4">
							<label >
								<h4>Clase</h4>
							</label>
							<select id=""  class="form-control" name="clase">
								<?php $resultado = consultaSql("select DISTINCT(auxValor1) from auxiliar WHERE auxclase = 'tipoPrueba';");
								while($res=$resultado->fetch_object()){?>
								<option value="<?php echo $res->auxValor1 ?>"><?php echo $res->auxValor1 ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-xs-12 col-sm-4">
							<label >
								<h4>Area</h4>
							</label>
							<select id=""  class="form-control" name="area">
								<?php $resultado = consultaSql("select DISTINCT(auxValor2) from auxiliar WHERE auxclase = 'tipoPrueba' and auxvalor1 = 'general';");
								while($res=$resultado->fetch_object()){?>
								<option value="<?php echo $res->auxValor2 ?>"><?php echo $res->auxValor2 ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-xs-12 col-sm-4">
							<label >
								<h4>Competencia</h4>
							</label>
							<select id=""  class="form-control" name="competencia">
								<?php $resultado = consultaSql("select DISTINCT(auxValor3) from auxiliar WHERE auxclase = 'tipoPrueba' and auxvalor1 = 'general' and auxValor2 = 'contabilidad';");
								while($res=$resultado->fetch_object()){?>
								<option value="<?php echo $res->auxValor3 ?>"><?php echo $res->auxValor3 ?></option>
								<?php } ?>
							</select>
							<br>              
						</div>     
						<div class="col-xs-12">
							<label>
								<h4>Pregunta</h4>
							</label>
							<div class="form-group has-feedback mb">
								<textarea rows="2" class="form-control input-lg has-error" placeholder="Digite aqui la preguta" name="pregunta1"></textarea>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
								<label class="control-label mb">
									<h4 class="mb"></h4>
								</label>
							</div>
							<h4></h4>
						</div>
						<div class="col-xs-12 col-md-8">
							<label>
								<h4>Agregar una imagen:&nbsp; </h4>
							</label>
							<h4 style="color:#787878; display: inline-block;">
								<input type="file" name="imagen">
							</h4>
							<br>
                            <label>
								<h4>Agregar un Contexto: </h4>
							</label> 
							<input type="hidden" name="contexto" value="">
                            
							<button type="button"  id="filtrar" 
                            style="display: inline-block; font-size:1.15em; font-weight:bold ">
								&nbsp;Examinar...&nbsp;
							</button>
							<label style="color: #7F7F7F">
								<h4 id="contexto">Ningun contexto selecionado.</h4>
							</label>  
						</div>
						<div class="col-xs-12 col-md-4">
							<label >
								<h4>Nivel</h4>
							</label>
							<select id=""  class="form-control" name="nivel">
								<option value="">Ninguno</option>
								<option value="basico">Basico</option>
								<option value="medio">Medio</option>
								<option value="avanzado">Avanzado</option>
							</select>
							<br>
						</div>    
						<div class="clearfix"></div>

						<div class="col-xs-12" id="divTabla"> <br>
							<br>
							<table id="example1" class="display" cellspacing="0" width="100%">
								<thead>
									<tr>
										<?php $resultado = consultaColumnasth("contexto1");?>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<?php $resultado = consultaColumnasth("contexto1");?>
									</tr>
								</tfoot>
							</table>
						</div>
						<br>          
						<div class="col-xs-12">
							<label>
								<h4>Texto posterior a la imagen (Opcional) </h4>
							</label>
							<div class="form-group has-feedback mb">
								<textarea rows="1" class="form-control input-lg has-error" placeholder="Digite aqui la segunda parte de la pregunta (aparecera despues de la imagen)" name="pregunta2"></textarea>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
								<label class="control-label mb">
									<h4 class="mb"></h4>
								</label>
							</div>
							<h4></h4>
						</div>
						<div class="col-xs-12">
							<label>
								<h4>Afirmacion</h4>
							</label>
							<div class="form-group has-feedback mb">
								<input type="text"  class="form-control input-lg has-error" placeholder="" name="afirmacion">
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
								<label class="control-label mb">
									<h4 class="mb"></h4>
								</label>
							</div>
							<h4></h4>
						</div>
              <div class="col-xs-12">
                <label>
                    <h4>Fuente</h4>
                </label>
                <div class="form-group has-feedback mb">
                    <input type="text"  class="form-control input-lg has-error" placeholder="De donde fue sacado esta pregunta" name="fuente">
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
							<button type="button" class="botonStandar center-block" id="enviaPregunta">
								<h4> &nbsp;&nbsp;&nbsp;&nbsp;Crear Pregunta&nbsp;&nbsp;&nbsp;&nbsp; </h4>
							</button>
						</div>
						<div class="clearfix"></div>
						<br>
					</form>
				</div>
				<!-- fin bloque pregunta --> 
				<br>
				<table id="example2" class="display" cellspacing="0" width="100%">
					<thead>
						<tr id="filaTabla">
							<?php $resultado = consultaColumnasth('pregunta2');?>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<?php $resultado = consultaColumnasth('pregunta2');?>
						</tr>
					</tfoot>
				</table>
				<br>
				<div class="bloque col-xs-12" id="verPregunta" > </div>
			</div>
		</div>
	</div>
</section>
<?php  include 'inc/footer.php'; //pie de pagina de la pagina?>
<script>
$(document).ready(function() {

		$('#divTabla').hide();
		$('#load').hide();
		$("#crearPregunta").hide();
		$("#verPregunta").hide();
		$("textarea[name=pregunta1]").keyup(function (){validar(this,0,0,0,1,1800,0,0)});			
		$("textarea[name=pregunta2]").keyup(function (){validar(this,0,0,0,0,900,0,0)});	
		$("input[name=afirmacion]").keyup(function (){validar(this,0,0,0,0,200,0,0)});	
		$("input[name=fuente]").keyup(function (){validar(this,0,0,0,0,200,0,0)});
		
$("#creaPregunta").attr("value", "close");
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

// funcion que actualiza los combos al ser cambiados
$("select[name=clase]").change(function() {		
        	// obtenemos el valor seleccionado	
        	console.log("cambio");		
        	var combo1 = $(this).find('option:selected').val();		
			// creamos el sting de JSON CON ajax	
			console.log(combo1);
			var jmun = $.ajax({
				type: "GET",
				url: "controlador/comboPregunta.php",
				data: {valor1:combo1},
				async: false,
			}).responseText

	//convertirmos el string JSON en un JSON array
	var jaux = $.parseJSON(jmun);
	//selecionamos el segundo combo y lo vacioamos al tiempo	
	var $combo2 = $("select[name=area]").empty();
	// crear un arreglo vacio
	var jar = new Array() 
	//recorrer el objeto de json		
	$.each(jaux, function(index, m) {	
	//comprobar si el valor de el json existe en el arreglo, si no entonces añadirlo al combo	
	if(jQuery.inArray(m.auxValor2,jar) == -1){
		$($combo2).append("<option value ='" + m.auxValor2 + "'>" + m.auxValor2 + "</option>");
	//añadir al arreglo el valor para que no se repita			
	jar.push(m.auxValor2); 				
};		
});	

	var jar2 = new Array() 		
	var $combo3 = $("select[name=competencia]").empty();

	$.each(jaux, function(index, m) {		
		if(jQuery.inArray(m.auxValor3,jar2) == -1){
			if(m.auxValor2 == $( "select[name=area] option:selected" ).text()){
				$($combo3).append("<option value ='" + m.auxValor3 + "'>" + m.auxValor3 + "</option>");
				jar2.push(m.auxValor3 ); 					
			};								
		};
	});					
});

$("select[name=area]").change(function() {		
	
	var combo1 = $("select[name=clase]").find('option:selected').val();		
	var jmun = $.ajax({
		type: "GET",
		url: "controlador/comboPregunta.php",
		data: {valor1:combo1},
		async: false,
	}).responseText
	console.log(jmun);
	var jaux = $.parseJSON(jmun);

	var jar2 = new Array() 		
	var $combo3 = $("select[name=competencia]").empty();

	$.each(jaux, function(index, m) {		
		if(jQuery.inArray(m.auxValor3,jar2) == -1){
			if(m.auxValor2 == $( "select[name=area] option:selected" ).text()){
				$($combo3).append("<option value ='" + m.auxValor3 + "'>" + m.auxValor3 + "</option>");
				jar2.push(m.auxValor3 ); 					
			};								
		};
	});					
});

$('#filtrar').click(function () {
	$('#divTabla').show(); 			

	var table = $('#example1').dataTable({
		"destroy": true,
		//configuraciones para conectar al server
		"processing": true,
		"serverSide": true,
		"ajax": "modelo/server_processing.php?t=contexto1",
		
		//longitud de la consulta "-1 para mostrar todos los registros"
		"lengthMenu": [[5, 30, 50, 100], [5, 30, 50, 100]],
		//paga que hacer visibles los botones "primero" y "ultimo"
		"pagingType": "full_numbers",
		 // mostrar el scroll horizontal
		 "scrollX": true,

		//configuraciones para cambiar idioma de etiquetas
		"language":  idiomaDT, 
	} );//datatable

$('#example1 tbody').on( 'click', 'tr', function () {
	if ( $(this).hasClass('selected') == false ) {
		var id = $( this ).children(":nth-child(1)").text()			 
		$("input[name=contexto]").val(id);
		$("#contexto").text("Id: " + id);	
		$('#divTabla').hide(1000);		
	}		
		});	// fin de example table t body		

	}); // fin click enviar

$("#enviaPregunta").click(function () {
	
	var v1= validar("textarea[name=pregunta1]",0,0,0,1,1800,0,0);			
	var v2= validar("textarea[name=pregunta2]",0,0,0,0, 900,0,0);	
	var v3= validar("input[name=afirmacion]  ",0,0,0,0, 200,0,0);	
	var v4= validar("input[name=fuente]",0,0,0,0,200,0,0);	

	
	
	var ext = $('input[name=imagen]').val().split('.').pop().toLowerCase(); 

	if ( v1 ==false || v2==false || v3==false || v4==false) {
		
		alert("Hay campos con errores por favor verifique")	

	}else if($("input[name=imagen]").val()!='' && 
		$.inArray(ext, ['png','jpg','jpeg']) == -1){

		alert('La imagen debe ser en formato jpg o png');
		
	}else if($("input[name=imagen]").val()!='' && 
		$('input[name=imagen]')[0].files[0].size > 2100000){

		alert('La imagen debe pesar menos de 2 MegaBytes');

	}else{
		var formData = new FormData ($("#formPregunta")[0]) ;			 			

		$("#load").show()
		$.ajax({
			url: "controlador/procesaPregunta.php", 
			type: "POST", 
			data: formData, 
			contentType: false, 
			processData: false, 
			success: function(datos){
				$("#load").hide()
				alert(datos);	

				if(datos == "insercion ejecutada correctamente"){
					console.log(datos);
					$("#crearPregunta").slideUp();	
					$("textarea[name=pregunta1]").val("");		
					$("textarea[name=pregunta2]").val("");			
					$("input[name=afirmacion]").val("");						
					$("input[name=imagen]").val("");
					$("input[name=fuente]").val("");
					
					$("input[name=contexto]").val("");
					$("#contexto").text("Ningun contexto selecionado");	
			
			//lineas para el boton de ocultar y mostrar el añadir		
			$("#creaPregunta").html("<h4> &nbsp;&nbsp;Anadir Nueva Pregunta&nbsp;&nbsp; </h4>");
			$("#creaPregunta").attr("value", "close");	
			
			$('#filaTabla > th:nth-child(2)').trigger('click');
			$('#filaTabla > th:nth-child(1)').trigger('click');
			$('#filaTabla > th:nth-child(1)').trigger('click');
									
				}			
			}
		});			
	}

}); // fin envio pregunta

$('#example2').dataTable( {

		//configuraciones para conectar al server
		"processing": true,
		"serverSide": true,
		"ajax": "modelo/server_processing.php?t=pregunta2",
		
		//longitud de la consulta "-1 para mostrar todos los registros"
		"lengthMenu": [[5, 15,30, 50, 100], [5, 15,30, 50, 100]],
		//paga que hacer visibles los botones "primero" y "ultimo"
		"pagingType": "full_numbers",
		 // mostrar el scroll horizontal
		 "scrollX": true,

		//configuraciones para cambiar idioma de etiquetas
		"language":  idiomaDT, 
	} );//datatable

var table = $('#example2').DataTable();

$('#example2 tbody').on( 'click', 'tr', function () {

	if ( $(this).hasClass('selected') ) {
		$(this).removeClass('selected');
		var id = $( this ).children(":first").text() 
		//$('#conId').text(id);	
		$.ajax({
			url: "controlador/procesaPregunta.php", 
			type: "POST", 
			data: {proceso:"consultar",id:id}, 
			success: function(datos){
				
				$("#verPregunta").slideDown();
				$("#verPregunta").html(datos);
				$("html,body").animate({
					scrollTop: $("#verPregunta").offset().top
				}, 250);

				$("#eliminaPregunta").click(function () {						
					if(confirm("¿Desea eliminar esta Pregunta?")){
						$.ajax({
							url: "controlador/procesaPregunta.php", 
							type: "POST", 
							data: {proceso:"eliminar",id:id}, 
							success: function(datos){
								if(datos){
									$("#verPregunta").slideUp();
									
									$('.dataTables_scrollHeadInner > table:nth-child(1) > thead:nth-child(1) > tr:nth-child(1) > th:nth-child(1)').trigger('click');											
								}else{
									alert("Ocurrio un error al intentar eliminar")
								}												
							}
						});									
					}

				});		
				// fin eliminaPregunta	
				$("textArea[name=opcion]").keyup(function (){validar(this,0,0,0,1,250,0,0)});			
				$("#enviarOpcion").click(function () {	
				var v1= validar("textarea[name=opcion]",0,0,0,1,250,0,0);	
					
					if(v1){
						var formData = new FormData ($("#formOpcion")[0]) ;

						$.ajax({
							url: "controlador/procesaOpcion.php", 
							type: "POST", 
							data: formData, 
							processData: false,
							contentType: false,
							success: function(datos){
								
								if(datos){
									//alert("Se inserto la opcion correctamente")	
									var aux1 = $("select[name=estado]").val();
									
									if(aux1 == 1){
										aux1 = '<span class="glyphicon glyphicon-ok"></span>';
									}else{
										aux1 = '<span class="glyphicon glyphicon-remove" ></span>';
									}
									
									var aux2 = $("textArea[name=opcion]").val();
									
									$("#consultaOpcion").append('<h4> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + aux1 + ' - ' + aux2 + '</h4>');
									$("textArea[name=opcion]").val(''
									);
								}else{
									alert("Ocurrio un error al intentar insertar")
								}												
							}
						});		
					}else{
						alert("Hay campos con errores por favor verifique")	
					}			
				});		
				// fin enviarOpcion
				
				$("button[name=eliminaOpcion]").click(function () {	
					if(confirm("¿Desea eliminar esta Opcion?")){
						var id = $(this).val();				
						var obj = $(this);			

						$.ajax({
							url: "controlador/procesaOpcion.php", 
							type: "POST", 
							data: {proceso:"eliminar",id:id}, 
							//processData: false,
							//contentType: false,
							success: function(datos){
								
								if(datos){
									//alert("Se elimino la opcion correctamente")	
									obj.parent().remove();
									//obj.parent().css("background-color","#CD09B4")
								}else{
									alert("Ocurrio un error al intentar eliminar")
								}												
							}
						});	 //ajax					
					} // if
				});		
				// fin enviarOpcion				
				
				
			}
		});									
	}
	else {
		table.$('tr.selected').removeClass('selected');
		$(this).addClass('selected');
	}	
}); 
	// fin if hasclass

});

</script>
</body>
</html>