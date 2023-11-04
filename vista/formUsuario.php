<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
<? // esta linea es para que me reconosoca las funciones ?>
<div class="row">
  <div class="col-xs-12">
    <h2 class="text-center">Agregar Nuevo Usuario</h2>
    <br>
    <form action="controlador/procesaUsuario.php" method="post">
      <input type="hidden" name="proceso" value="agregar">
      

      <div class="col-xs-12 col-sm-3">
        <label >
        <h4>Tipo Documento</h4>
        </label>
        <select id=""  class="form-control" name="tipoDocumento">
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
        </div><h4></h4>
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
        </div><h4></h4>
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
        </div><h4></h4>
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
        </div><h4></h4>
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
        </div><h4></h4>
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
        </div><h4></h4>
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
        </div><h4></h4>
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
        </div><h4></h4>
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
        </div><h4></h4>
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
        </div><h4></h4>
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
        </div><h4></h4>
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
        <h4> &nbsp;&nbsp;&nbsp;&nbsp;Anadir&nbsp;&nbsp;&nbsp;&nbsp; </h4>
        </button>
        <br>
      </div>
    </form>
  </div>
</div>
<script>
$(document).ready(function() {
	
 	document.title = 'Agregar nuevo Usuario';

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
	$("input[name=ficha]").prop('disabled', 'disabled');
	
	$("select[name=rol]").change(function() {
		if($("select[name=rol]").val() == "aprendiz"){
			$("input[name=ficha]").prop('disabled', false);
		}else{

			$("input[name=ficha]").prop('disabled', 'disabled');
			$("input[name=ficha]").val("");
			validar("input[name=ficha]"          ,1,0,0,0,10,0,0);
			
		}
	});	// fin select rol				
	
	$( "form" ).submit(function( event ) {	
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
		
		var campo = $("input[name=numeroDocumento]").val();		
		v11= validarDoc(campo);

		if ( v1 && v2 && v3 && v4 && v5 && v6 && v7 && v8 && v9 && v10) {
			
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