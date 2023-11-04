<?php 
// ajustar estas consultas
$id = $_GET['id'];
$tab = $_GET['tab'];
$idtab = substr($tab,0,3)."Id";
$resultado = consultaSql("select count(*) existe from $tab where $idtab =$id;");
$resultado = $resultado->fetch_object()->existe;

if($resultado){	
$resultado = consultaSql("select * from $tab where $idtab = $id;");
$oResultado = htmlDecode($resultado->fetch_object());
?>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
<? // esta linea es para que me reconosoca las funciones ?>
<div class="row">
  <div class="col-xs-12">
    <form action="controlador/procesaUsuario.php" method="post" id="formDel">
      <input type="hidden" name="proceso" value="eliminar">
      <input type="hidden" name="idd" value="<?php echo $oResultado->usuId;?>">
      <button type="submit" class="botonStandar2" style="position: absolute; right:0px">
      <h4> &nbsp; <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> &nbsp;Eliminar&nbsp;&nbsp; </h4>
      </button>
    </form>
    <h2 class="text-center">Editar Usuario</h2>
    <br>
    <form action="controlador/procesaUsuario.php" method="post" id="formEnviar">
      <input type="hidden" name="proceso" value="modificar">
      <input type="hidden" name="idx">
      <div class="col-xs-12 col-sm-3">
        <label >
        <h4>Tipo Documento</h4>
        </label>
        <select id=""  class="form-control" name="tipoDoc">
          <?php $resultado = consultaSql("select * from auxiliar where auxclase = 'documento';");
		 while($res=$resultado->fetch_object()){?>
          <option value="<?php echo $res->auxValor2 ?>"><?php echo $res->auxValor1 ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-xs-12 col-sm-3">
        <label>
        <h4>Numero</h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="" name="numeroDocumento">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>
      <div class="col-xs-12 col-sm-3">
        <label >
        <h4>Rol</h4>
        </label>
        <select id=""  class="form-control" name="rol">
          <?php $resultado = consultaSql("select * from auxiliar where auxclase = 'roles';");
		 while($res=$resultado->fetch_object()){?>
          <option value="<?php echo $res->auxValor1 ?>"><?php echo $res->auxValor1 ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-xs-12 col-sm-3">
        <label>
        <h4>ID Unico</h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="" name="id">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>
      <div class="clearfix"></div>
      <div class="col-xs-12 col-sm-3">
        <label>
        <h4>Primer Nombre</h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="" name="nombre1">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>
      <div class="col-xs-12 col-sm-3">
        <label>
        <h4>Segundo Nombre</h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="" name="nombre2">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>
      <div class="col-xs-12 col-sm-3">
        <label>
        <h4>Primer Apellido</h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="" name="apellido1">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>
      <div class="col-xs-12 col-sm-3">
        <label>
        <h4>Segundo Apellido</h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="" name="apellido2">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>
      <div class="clearfix"></div>
      <div class="col-xs-12 col-sm-3">
        <label>
        <h4>Telefono</h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="" name="telefono">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>
      <div class="col-xs-12 col-sm-3">
        <label>
        <h4>Celular</h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="" name="celular">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>
      <div class="col-xs-12 col-sm-6">
        <label>
        <h4>Correo</h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="" name="correo">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>
      <div class="clearfix"></div>
      <div class="col-xs-12 col-sm-3">
        <label>
        <h4>Nacimiento</h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="AAAA/MM/DD" name="fecha">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>
      <div class="col-xs-12 col-sm-3">
        <label >
        <h4>Sexo</h4>
        </label>
        <select id=""  class="form-control" name="sexo">
          <option value="masculino">Masculino</option>
          <option value="femenino">Femenino</option>
        </select>
      </div>
      <div class="col-xs-12 col-sm-3">
        <label>
        <h4>Ficha</h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="" name="ficha">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>
      <div class="col-xs-12 col-sm-3">
        <label >
        <h4>Estado</h4>
        </label>
        <select id=""  class="form-control" name="estado">
          <option value="1">Activo</option>
          <option value="0">Inactivo</option>
        </select>
      </div>
      <div class="clearfix"></div>
      <br>
      <div class="col-xs-6"> <a href="cruds.php?tab=usuario">
        <button type="button" class="botonStandar2" style="float:right">
        <h4> &nbsp;&nbsp;&nbsp;&nbsp;Cancelar&nbsp;&nbsp;&nbsp;&nbsp; </h4>
        </button>
        </a> </div>
      <div class="col-xs-6">
        <button type="submit" class="botonStandar">
        <h4> &nbsp;&nbsp;&nbsp;&nbsp;Editar&nbsp;&nbsp;&nbsp;&nbsp; </h4>
        </button>
        <br>
      </div>
    </form>
  </div>
  <div class="clearfix"></div>
  <br>
  <hr>
  <br>
  <div class="row">
  
    <div class="col-xs-3 col-sm-2">
       <div id="respuesta"></div>
      </div>   
       
    <div class="col-xs-9 col-sm-6">
      <form action="post" id="formFoto" enctype="multipart/form-data">
        <label><h3>Subir fotografia de usuario</h3></label>
        
        <h4 style="color:#787878;"><input type="file" name="archivo"></h4>
        <input type="hidden" name="nombreFoto" value="<?php echo $oResultado->usuId; ?>">
        <br>
        <button type="button" class="botonStandar" id="enviaFoto">
        <h4> &nbsp; <span class="glyphicon glyphicon-picture" aria-hidden="true"></span> &nbsp;enviar&nbsp;&nbsp; </h4>
        </button>
      </form>
     
    </div>
 
    <div class="col-xs-12 col-sm-4"> <br><br>
      <button type="submit" class="botonStandar2" id="reestablecerPass">
      <h4> &nbsp; <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> &nbsp;Reestablecer Contraseña&nbsp;&nbsp; </h4>
      </button>
    </div>
  </div>
  <div class="clearfix"></div>
</div>
<script>


	$ ("#reestablecerPass").click(function () {

		if (confirm("¿Desea reestablecer la contraseña a el numero de Documento actual?")) {

			$.ajax({
				type: "POST", 								
				url:"controlador/reestablecerPass.php", 
				data: {id:"<?php echo $oResultado->usuId; ?>",
				numero:"<?php echo $oResultado->usuNumeroDoc; ?>"},  
				success: function(datos){
				console.log(datos);	
					alert(datos)
				}
			});				
		}				
	});

	$ ("#enviaFoto").click(function () {

		if($("input[name=archivo]").val()!=''){		
			
			var ext = $('input[name=archivo]').val().split('.').pop().toLowerCase(); 
			
			if($.inArray(ext, ['png','jpg','jpeg']) == -1) { 
				alert('Solo se permiten imagenes en formato jpg o png'); 
			}else{
				var formData = new FormData ($("#formFoto")[0]) ;			 			
				var ruta = "controlador/subeFoto.php";
				$("#respuesta").html("<img src= img/load.gif>");
				$.ajax({
					url: ruta, 
					type: "POST", 
					data: formData, 
					contentType: false, 
					processData: false, 
					success: function(datos){
					$("#respuesta").html(datos);
					}
				});								
			}			
		}else{
			alert('Selecione un archivo de imagen en formato jpg o png')
		}
	});


$(document).ready(function() {
	
 	document.title = 'Editar Usuario';
	
	$("#respuesta").html("<img src=img/fperfil/<?php echo$oResultado->usuFoto; ?>  alt='foto Perfil' style='width: 100%';>");
	
	$( '#formDel').submit(function( event ) {	
		var r = confirm("¿Esta seguro que desea eliminar este Registro?");
		if (r == true) {
			return;						
		}else {
			event.preventDefault();
		}
	}); // formdel
	
	$("input[name=numeroDocumento]").val("<?php echo $oResultado->usuNumeroDoc; ?>");
	$("input[name=id]"             ).val("<?php echo $oResultado->usuId; ?>");						
	$("input[name=idx]"            ).val("<?php echo $oResultado->usuId; ?>");						
	$("input[name=nombre1]"        ).val("<?php echo $oResultado->usuNombre1; ?>");			
	$("input[name=nombre2]"        ).val("<?php echo $oResultado->usuNombre2; ?>");			
	$("input[name=apellido1]"      ).val("<?php echo $oResultado->usuApellido1; ?>");		
	$("input[name=apellido2]"      ).val("<?php echo $oResultado->usuApellido2; ?>");			
	$("input[name=telefono]"       ).val("<?php echo $oResultado->usuTelefono; ?>");		
	$("input[name=celular]"        ).val("<?php echo $oResultado->usuCelular; ?>");		
	$("input[name=correo]"         ).val("<?php echo $oResultado->usuCorreo; ?>");			
	$("input[name=fecha]"          ).val("<?php echo $oResultado->usuFechaNacimiento; ?>");			
	$("input[name=ficha]"          ).val("<?php echo $oResultado->ficId; ?>");	
	
	$("select[name=rol]").val("<?php echo $oResultado->usuRol; ?>")
	$("select[name=tipoDoc]").val("<?php echo $oResultado->usuTipoDoc; ?>")
	$("select[name=estado]").val("<?php echo $oResultado->usuEstado; ?>")
	$("select[name=sexo]").val("<?php echo $oResultado->usuSexo; ?>")

// ********************** funcion validar selector,numeros,letras,decimales,min,max,valormax,especial
	$("input[name=numeroDocumento]").keyup(function (){validar(this,1,0,0,1,18,0,0)});			
	$("input[name=nombre1]"        ).keyup(function (){validar(this,0,1,0,1,19,0,0)});			
	$("input[name=nombre2]"        ).keyup(function (){validar(this,0,1,0,0,19,0,0)});			
	$("input[name=apellido1]"      ).keyup(function (){validar(this,0,1,0,1,19,0,0)});			
	$("input[name=apellido2]"      ).keyup(function (){validar(this,0,1,0,0,19,0,0)});			
	$("input[name=telefono]"       ).keyup(function (){validar(this,1,0,0,0, 7,0,0)});			
	$("input[name=celular]"        ).keyup(function (){validar(this,1,0,0,0,10,0,0)});			
	$("input[name=correo]"         ).keyup(function (){validar(this,0,0,0,0,90,0,1)});			
	$("input[name=fecha]"          ).keyup(function (){validar(this,0,0,0,0,10,0,3)});			
	$("input[name=ficha]"          ).keyup(function (){validar(this,1,0,0,1,10,0,0)});	
			
	$("input[name=id]").prop('disabled', 'disabled');					
	//$("input[name=ficha]").prop('disabled', 'disabled');
	
	$("select[name=rol]").change(function() {
		if($("select[name=rol]").val() == "aprendiz"){
			$("input[name=ficha]").prop('disabled', false);
		}else{

			$("input[name=ficha]").prop('disabled', 'disabled');
			$("input[name=ficha]").val("");
			validar("input[name=ficha]"          ,1,0,0,0,10,0,0);
			
		}
	});	// fin select rol				
	
	$( "#formEnviar" ).submit(function( event ) {	
		v1 = validar("input[name=numeroDocumento]",1,0,0,1,18,0,0);			
		v2 = validar("input[name=nombre1]"        ,0,1,0,1,19,0,0);			
		v3 = validar("input[name=nombre2]"        ,0,1,0,0,19,0,0);			
		v4 = validar("input[name=apellido1]"      ,0,1,0,1,19,0,0);			
		v5 = validar("input[name=apellido2]"      ,0,1,0,0,19,0,0);			
		v6 = validar("input[name=telefono]"       ,1,0,0,0, 7,0,0);			
		v7 = validar("input[name=celular]"        ,1,0,0,0,10,0,0);			
		v8 = validar("input[name=correo]"         ,0,0,0,0,90,0,1);			
		v9 = validar("input[name=fecha]"          ,0,0,0,0,10,0,3);			
		
		if($("select[name=rol]").val() == "aprendiz"){
			v10 = validar("input[name=ficha]"          ,1,0,0,1,10,0,0);
			
			var campo = $("input[name=ficha]").val();
			var tabla = "ficha";
			v12= validarId(campo,tabla);
					
			}else{
			v10 = validar("input[name=ficha]"          ,1,0,0,0,10,0,0);
			v12 = true;			
			}
		
		//al presionar submit comprueba todos los campos y consultas ajax				
		if ( v1 && v2 && v3 && v4 && v5 && v6 && v7 && v8 && v9 && v10) {
			
			// estos doc1 y 2 con para poder cambiar el documento
			var doc1 = <?php echo $oResultado->usuNumeroDoc; ?>;
			var doc2 = $("input[name=numeroDocumento]").val();
			//console.log(doc1 + " - " + doc2)
			
			// si son iguales no comprueba nada				
			if (doc1 == doc2) {
				v11 = 0;
			} else {
				var campo = $("input[name=numeroDocumento]").val();						
				v11 = validarDoc(campo);				
			}
					
			if(v11==0){
				if(v12==0){
					alert("No existe este numero de ficha "+ 
					$("input[name=ficha]").val());
					event.preventDefault();									
				}else{
					//alert("se envio");
					//event.preventDefault();	
					return;				
				}				
			}else{
				alert("Ya existe un usuario con el numero de documento "+ 
				$("input[name=numeroDocumento]").val());
				event.preventDefault();			
			}			
		}else {
			alert("Hay campos con errores por favor verifique")
			event.preventDefault();
		}
	}); //fin form submit
}); // fin ready
	
</script>
<?php 
}else{
echo"<br><h2 class='text-center'>El ID no existe en la tabla ".$_GET['tab']."</h2> <br>";
 ?>
<a href="cruds.php?tab=<?php echo $_GET['tab'] ?>">
<button class="botonStandar center-block" type="button">
<h4> &nbsp;&nbsp; Regresar &nbsp;&nbsp; </h4>
</button>
<br>
</a>
<?php  		
	}	
 ?>
