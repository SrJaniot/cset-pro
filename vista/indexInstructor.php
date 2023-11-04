
<?php include ("modelo/conexion.php");?>

<section id="section2" class="colorfondo" >
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <button id="creaPrueba" type="button" class="botonStandar" style="position: absolute; right:0px">
        <h4> &nbsp;&nbsp;Anadir Nueva Prueba&nbsp;&nbsp; </h4>
        </button>
        <h1 class="text-center" >Pruebas</h1>
        <br>
        <div class="bloque" id="crearPrueba">
          <h4 class="text-center"><b>Crear Nueva Prueba</b></h4>
          <form action="controlador/procesaPrueba.php" method="post" enctype="multipart/form-data" id="formPrueba">
            <input type="hidden" name="proceso" value="agregar">
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
              <h4>Mostrar resultados al final de la prueba</h4>
              </label>
              <select class="form-control" name="mostrarResultados">
                <option value="0">NO</option>
                <option value="1">SI</option>
              </select>
            </div>
            <div class="col-xs-12 col-sm-4">
              <label >
              <h4>Preguntas desordenadas</h4>
              </label>
              <select class="form-control" name="mezclarPreguntas">
                <option value="0">NO</option>
                <option value="1">SI</option>
              </select>
            </div>
            <div class="col-xs-12 col-sm-4">
              <label >
              <h4>Opciones desordenadas</h4>
              </label>
              <select class="form-control" name="mezclarOpciones">
                <option value="0">NO</option>
                <option value="1">SI</option>                
              </select>
            </div>
            <div class="col-xs-12"> <br>
              <br>
              <img  id="loadCrearPrueba" class="loading" src= 'img/load.gif'>
              <button type="button" class="botonStandar center-block" id="enviaPrueba">
              <h4> &nbsp;&nbsp;&nbsp;&nbsp;Crear Prueba&nbsp;&nbsp;&nbsp;&nbsp; </h4>
              </button>
            </div>
            <div class="clearfix"></div>
            <br>
          </form>
        </div>
        <!-- fin bloque prueba --> 
        
         <table id="example" class="display" cellspacing="0" width="100%">
          <thead>
            <tr id="filaTabla">
              <?php $resultado = consultaColumnasth('prueba2');?>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <?php $resultado = consultaColumnasth('prueba2');?>
            </tr>
          </tfoot>
        </table>
        
      </div>
    </div>
  </div>
</section>
<script>

$(document).ready(function() {

$("#loadCrearPrueba").hide()
$("#crearPrueba").hide()

$("#creaPrueba").attr("value", "close");
$("#creaPrueba").click(function () {
		var aux = $("#creaPrueba").val();
		if(aux == "open"){
			$("#crearPrueba").slideUp();
			$("#creaPrueba").html("<h4> &nbsp;&nbsp;Anadir Nueva Prueba&nbsp;&nbsp; </h4>");
			$("#creaPrueba").attr("value", "close");	
		}else{
			$("#crearPrueba").slideDown();
			$("#creaPrueba").html("<h4> &nbsp;&nbsp;Ocultar&nbsp;&nbsp; </h4>");
			$("#creaPrueba").attr("value", "open");
		}	
	});

$("input[name=idx]").prop('disabled', 'disabled');

// ********************** funcion validar selector,numeros,letras,decimales,min,max,valormax,especial
	$("input[name=nombre]").keyup(function (){validar(this,0,0,0,1, 90,0,0)});			
	$("textarea[name=descripcion]").keyup(function (){validar(this,0,0,0,0, 450,0,0)});			
	$("input[name=tiempo]").keyup(function (){validar(this,1,0,0,1, 3,600,0)});			
	$("input[name=fecha1]").keyup(function (){validar(this,0,0,0,1,10,0,3)});			
	$("input[name=fecha2]").keyup(function (){validar(this,0,0,0,1,10,0,3)});			
	$("input[name=hora1]").keyup(function (){validar(this,0,0,0,1,5,0,4)});			
	$("input[name=hora2]").keyup(function (){validar(this,0,0,0,1,5,0,4)});			
	$("input[name=fecha1]").val(fecha())
	$("input[name=fecha2]").val(fecha())
	$("input[name=hora1]").val("06:00")
	$("input[name=hora2]").val("22:00")
$("#enviaPrueba").click(function () {
	
	var v1 = validar("input[name=nombre]"        ,0,0,0,1, 90,0,0);			
	var v2 = validar("textarea[name=descripcion]",0,0,0,0,450,0,0);			
	var v3 = validar("input[name=tiempo]"        ,1,0,0,1,  3,600,0);			
	var v4 = validar("input[name=fecha1]"        ,0,0,0,0, 10,0,3);			
	var v5 = validar("input[name=fecha2]"        ,0,0,0,0, 10,0,3);			
	var v6 = validar("input[name=hora1]"         ,0,0,0,0,  5,0,4);			
	var v7 = validar("input[name=hora2]"         ,0,0,0,0,  5,0,4);			
	
	if ( v1 && v2 && v3 && v4 && v5 && v6 && v7 ) {
		
		var formData = new FormData ($("#formPrueba")[0]) ;			 			

		$("#loadCrearPrueba").show()
		console.log("bn");
		$.ajax({
			url: "controlador/procesaPrueba.php", 
			type: "POST", 
			data: formData, 
			contentType: false, 
			processData: false, 
			success: function(datos){
				$("#loadCrearPrueba").hide()

				alert(datos);	
				if(datos == "insercion ejecutada correctamente"){
					$("#crearPrueba").slideUp();
											
					$("input[name=nombre]").val("");				
					$("textarea[name=descripcion]").val("");		
					$("input[name=tiempo]").val("");						
					
			//lineas para el boton de ocultar y mostrar el añadir
			$("#creaPrueba").html("<h4> &nbsp;&nbsp;Anadir Nueva Prueba&nbsp;&nbsp; </h4>");
			$("#creaPrueba").attr("value", "close");
			
			$('#filaTabla > th:nth-child(2)').trigger('click');
			$('#filaTabla > th:nth-child(1)').trigger('click');
			$('#filaTabla > th:nth-child(1)').trigger('click');
				}	
			}
		});	// fin ajax				


	}else{
		alert("Hay campos con errores por favor verifique")					
	}

}); // fin envio prueba
		
	$('#example').dataTable( {
		"processing": true,
		"serverSide": true,
		"ajax": "modelo/server_processing.php?t=prueba2",		
		"lengthMenu": [[10, 30, 50, 100], [10, 30, 50, 100]],
		 "pagingType": "full_numbers",
		"scrollX": true,		
		"language": idiomaDT, 
	} );//datatable
	
   var table = $('#example').DataTable();   
	$('#example tbody').on( 'click', 'tr', function () {
	 if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }	
	});
	
	$('#example tbody').on( 'click', 'tr', function () {
		if ( $(this).hasClass('selected') == false ) {
		var id = $( this ).children(":first").text() 
			if(!isNaN(id)){
				window.open("editarPrueba.php?id="+ id, "_self");	
			}		
		}		
	});	
	 
});

</script>