<div class="row">
  <div class="col-xs-12">
    <h2 class="text-center">Agregar Nuevo Centro de Formacion</h2>
    <br>
    <form action="controlador/procesaCentro.php" method="post">
      <input type="hidden" name="proceso" value="agregar">
      <div class="col-xs-12 col-sm-3">
        <label>
        <h4>Codigo </h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="" name="codigo">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>
      <div class="col-xs-12 col-sm-6">
        <label>
        <h4>Nombre del Centro </h4>
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
      <div class="col-xs-12 col-sm-3">
        <label>
        <h4>Sigla </h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="" name="sigla">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>
      <div class="clearfix"></div>
      <div class="col-xs-12 col-sm-3">
        <label >
        <h4>Departamento </h4>
        </label>
        <select id=""  class="form-control" name="departamento">
          <?php $resultado = consultaSql("select DISTINCT(mundepartamento) dep from municipio");
		 while($res=$resultado->fetch_object()){?>
          <option value=""><?php echo $res->dep?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-xs-12 col-sm-3">
        <label >
        <h4>Municipio </h4>
        </label>
        <select id=""  class="form-control" name="municipio">
          <?php $resultado = consultaSql("select munid, munnombre from municipio where mundepartamento = 'antioquia';");
		 while($res=$resultado->fetch_object()){?>
          <option value="<?php echo $res->munid ?>"><?php echo $res->munnombre ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-xs-12 col-sm-6">
        <label>
        <h4>Direccion </h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="" name="direccion">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>
      <div class="col-xs-12 col-sm-4">
        <label>
        <h4>Telefono </h4>
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
      <div class="col-xs-12 col-sm-8">
        <label>
        <h4>Blog / Web Site</h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="" name="blog">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>
      <div class="clearfix"></div>
      <br>
      <div class="col-xs-6"> <a href="cruds.php?tab=centroFormacion">
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
	
 document.title = 'Agregar Centro de Formacion';

// ********************** funcion validar selector,numeros,letras,decimales,min,max,valormax,especial
	$("input[name=codigo]"   ).keyup(function (){validar(this,1,0,0,4,4,0,0)});			
	$("input[name=nombre]"   ).keyup(function (){validar(this,0,1,0,1,99,0,0)});			
	$("input[name=sigla]"    ).keyup(function (){validar(this,0,1,0,0,20,0,0)});						
	$("input[name=direccion]").keyup(function (){validar(this,0,0,0,0,99,0,0)});			
	$("input[name=telefono]" ).keyup(function (){validar(this,0,0,0,0,40,0,0)});			
	$("input[name=blog]"     ).keyup(function (){validar(this,0,0,0,0,40,0,0)});			
		
    $("select[name=departamento]").change(function() {		
        	// obtenemos el valor seleccionado			
        var combo1 = $(this).find('option:selected').text();		
			// creamos el sting de JSON CON ajax	
		var jmun = $.ajax({
			type: "GET",
			url: "controlador/municipios.php",
			data: {departamento:combo1},
			async: false,
		}).responseText
			//convertirmos el string JSON en un JSON array
		var jmun = $.parseJSON(jmun);
			//selecionamos el segundo combo y lo vacioamos al tiempo
		var $combo2 = $("select[name=municipio]").empty();
			//recorremos con un ciclo el JSON 
		$.each(jmun, function(index, m) {		
			// agregamos opciones al combo
			$($combo2).append("<option value =" + m.munid + ">" + m.munnombre + "</option>");	
		});					
	});
			
	
	$( "form" ).submit(function( event ) {
		
	v1= validar("input[name=codigo]"   ,1,0,0,4,4,0,0);			
	v2= validar("input[name=nombre]"   ,0,1,0,1,99,0,0);			
	v3= validar("input[name=sigla]"    ,0,1,0,0,20,0,0);						
	v4= validar("input[name=direccion]",0,0,0,0,99,0,0);			
	v5= validar("input[name=telefono]" ,0,0,0,0,40,0,0);			
	v6= validar("input[name=blog]"     ,0,0,0,0,40,0,0);
		
		var campo = $("input[name=codigo]").val();
		var tabla = "<?php echo $_GET['tab'] ?>";
		v7= validarId(campo,tabla);

		if ( v1 && v2 && v3 && v4 && v5 && v6 && v7) {
			if(v7==0){
				//alert("se envio");
				//event.preventDefault();	
				return;				
			}else{
				alert("Ya existe un centro con el codigo "+ $("input[name=codigo]").val());
				event.preventDefault();			
			}			
		}else {
			alert("Hay campos con errores por favor verifique")
			event.preventDefault();
		}
	});
});
	
</script>