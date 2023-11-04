<?php 
session_start();
extract ($_REQUEST);
include ("modelo/conexion.php");
/*esta linea valida que exista una sesion, si no existe me manda al index, ademas valida
que el rol seal el indicado para la pagina si no es asi igualmente me manda a index*/
if(!isset($_SESSION['usuId']) or $_SESSION['rol']!='instructor'){ header('location:index.php'); }

$preid = $_GET['preid'];
$pregunta = consultaSQL(" select * from pregunta where preid = $preid;");
$pregunta = htmlDecode($pregunta->fetch_object());

?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include 'inc/head.php'; ?>
<title>Editar Pregunta</title>
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
        <h1 class="text-center" >Editar Pregunta</h1>
        <br>
        <div class="bloque" id="crearPregunta">
          <h4 class="text-center"><b>Crear Nueva Pregunta</b></h4>
          <form action="controlador/procesaPregunta.php" method="post" enctype="multipart/form-data" id="formPregunta">
            <input type="hidden" name="proceso" value="modificar">
            <input type="hidden" name="preId" value="<?php echo $pregunta->preId ?>">
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
                <?php $resultado = consultaSql("select DISTINCT(auxValor2) from auxiliar WHERE auxclase = 'tipoPrueba' and auxvalor1 = '$pregunta->preClase';");
								while($res=$resultado->fetch_object()){?>
                <option value="<?php echo $res->auxValor2; ?>" ><?php echo $res->auxValor2 ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-xs-12 col-sm-4">
              <label >
              <h4>Competencia</h4>
              </label>
              <select id=""  class="form-control" name="competencia">
                <?php $resultado = consultaSql("select DISTINCT(auxValor3) from auxiliar WHERE auxclase = 'tipoPrueba' and auxvalor1 = '$pregunta->preClase' and auxValor2 = '$pregunta->preArea';");

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
                <textarea rows="2" class="form-control input-lg has-error" placeholder="Digite aqui la preguta" name="pregunta1"><?php echo $pregunta->prePregunta; ?></textarea>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <label class="control-label mb">
                <h4 class="mb"></h4>
                </label>
              </div>
              <h4></h4>
            </div>
            <div class="col-xs-10 col-md-7">
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
                            style="display: inline-block; font-size:1.15em; font-weight:bold "> &nbsp;Examinar...&nbsp; </button>
              <label style="color: #7F7F7F">
              <h4 id="contexto">Ningun contexto selecionado.</h4>
              </label>
            </div>
            <div class="col-xs-2 col-md-1"> <img class="img-responsive" src="img/pregunta/<?php echo $pregunta->preImagen ?>" alt="no"> </div>
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
                <textarea rows="1" class="form-control input-lg has-error" placeholder="Digite aqui la segunda parte de la pregunta (aparecera despues de la imagen)" name="pregunta2"><?php echo $pregunta->prePosPregunta; ?></textarea>
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
            
              <div class="col-xs-12 col-sm-4">
                <label >
                <h4>Activa</h4>
                </label>
                <select class="form-control" name="activa">
                  <option value="0">NO</option>
                  <option value="1">SI</option>
                </select>
              </div>
            
            <div class="clearfix"></div>
            <br>
            <div class="col-xs-12"> <img  id="load" class="loading" src= 'img/load.gif'>
              <button type="button" class="botonStandar center-block" id="enviaPregunta">
              <h4> &nbsp;&nbsp;&nbsp;&nbsp;Editar Pregunta&nbsp;&nbsp;&nbsp;&nbsp; </h4>
              </button>
            </div>
            <div class="clearfix"></div>
            <br>
          </form>
        </div>
        <!-- fin bloque pregunta --> 
      </div>
    </div>
  </div>
</section>
<?php  include 'inc/footer.php'; //pie de pagina de la pagina?>
<script>
$(document).ready(function() {
	
	$('select[name=clase]').val("<?php echo $pregunta->preClase ?>");
	$('select[name=area]').val("<?php echo $pregunta->preArea ?>");
	$('select[name=competencia]').val("<?php echo $pregunta->preCompetencia?>");
	$('select[name=nivel]').val("<?php echo $pregunta->preNivel?>");
	$('input[name=afirmacion]').val("<?php echo $pregunta->preAfirmacion?>");
	$('input[name=contexto]').val("<?php echo $pregunta->conId?>");
	$('input[name=fuente]').val("<?php echo $pregunta->preFuente?>");
	$('select[name=activa]').val("<?php echo $pregunta->preEstado?>");

	$('#contexto').text("<?php echo $pregunta->conId?>");
	$('#load').hide();
	$('#divTabla').hide(); 
	$("textarea[name=pregunta1]").keyup(function (){validar(this,0,0,0,1,1800,0,0)});			
	$("textarea[name=pregunta2]").keyup(function (){validar(this,0,0,0,0,900,0,0)});	
	$("input[name=afirmacion]").keyup(function (){validar(this,0,0,0,0,200,0,0)});
	$("input[name=fuente]").keyup(function (){validar(this,0,0,0,0,200,0,0)});			
	// funcion que actualiza los combos al ser cambiados
$("select[name=clase]").change(function() {		
	console.log("cambio");		
	var combo1 = $(this).find('option:selected').val();			
	console.log(combo1);
	var jmun = $.ajax({
		type: "GET",
		url: "controlador/comboPregunta.php",
		data: {valor1:combo1},
		async: false,
	}).responseText

	var jaux = $.parseJSON(jmun);	
	var $combo2 = $("select[name=area]").empty();
	var jar = new Array() 	
	$.each(jaux, function(index, m) {	
	if(jQuery.inArray(m.auxValor2,jar) == -1){
		$($combo2).append("<option value ='" + m.auxValor2 + "'>" + m.auxValor2 + "</option>");		
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
					//console.log(datos);
					$("#crearPregunta").slideUp();	
					$("textarea[name=pregunta1]").val("");		
					$("textarea[name=pregunta2]").val("");			
					$("input[name=afirmacion]").val("");						
					$("input[name=imagen]").val("");
					
					$("input[name=contexto]").val("");
					$("#contexto").text("Ningun contexto selecionado");	

				}			
			}
		});			
	}

}); // fin envio pregunta
	
});	// fin ready
</script>
</body>
</html>