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

// para saber el municipio y departamento  
$resultado = consultaSql("select mundepartamento 'dep', munnombre 'mun'  from centroformacion 
inner join municipio on centroformacion.munId = municipio.munId where cenid = $id;");
$oResultado2 = htmlDecode($resultado->fetch_object());
?>

<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
<? // esta linea es para que me reconosoca las funciones ?>
<div class="row">
  <div class="col-xs-12">
      <form action="controlador/procesaCentro.php" method="post" id="formDel">
      <input type="hidden" name="proceso" value="eliminar">
      <input type="hidden" name="id" value="<?php echo $oResultado->cenId;?>">
      <button type="submit" class="botonStandar2" style="position: absolute; right:0px">
      <h4> &nbsp; <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> &nbsp;Eliminar&nbsp;&nbsp; </h4>
      </button>
    </form>
    <h2 class="text-center">Editar Centro de Formacion</h2>
    <br>
    <form action="controlador/procesaCentro.php" method="post" id="formEnviar">
      <input type="hidden" name="proceso" value="modificar">
      <input type="hidden" name="codigox">
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
        </select>
      </div>
      <div class="col-xs-12 col-sm-3">
        <label >
        <h4>Municipio </h4>
        </label>
        <select id=""  class="form-control" name="municipio">         
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
        <h4> &nbsp;&nbsp;&nbsp;&nbsp;Editar&nbsp;&nbsp;&nbsp;&nbsp; </h4>
        </button>
        <br>
      </div>
    </form>
  </div>
</div>
<script>
$(document).ready(function() {

	$( '#formDel').submit(function( event ) {	
		var r = confirm("¿Esta seguro que desea eliminar este Registro?");
		if (r == true) {
			return;						
		}else {
			event.preventDefault();
		}
	}); // formdel
	
 document.title = 'Editar Centro de Formacion';
 
$("input[name=codigox]").val("<?php echo $oResultado->cenId; ?>");
$("input[name=codigo]").val("<?php echo $oResultado->cenId; ?>");
$("input[name=codigo]").prop('disabled', 'disabled');
$("input[name=nombre]").val("<?php echo $oResultado->cenNombre; ?>");
$("input[name=sigla]").val("<?php echo $oResultado->cenSigla; ?>");
$("select[name=departamento]").append("<option> <?php echo $oResultado2->dep; ?> </option>");
$("select[name=departamento]").prop('disabled', 'disabled');
$("select[name=municipio]").append("<option> <?php echo $oResultado2->mun; ?> </option>");
$("select[name=municipio]").prop('disabled', 'disabled');
$("input[name=direccion]").val("<?php echo $oResultado->cenDireccion; ?>");
$("input[name=telefono]").val("<?php echo $oResultado->cenTelefono; ?>");
$("input[name=blog]").val("<?php echo $oResultado->cenBlog; ?>");

// ********************** funcion validar selector,numeros,letras,decimales,min,max,valormax,especial
	$("input[name=codigo]"   ).keyup(function (){validar(this,1,0,0,1,4,0,0)});			
	$("input[name=nombre]"   ).keyup(function (){validar(this,0,1,0,1,99,0,0)});			
	$("input[name=sigla]"    ).keyup(function (){validar(this,0,1,0,0,20,0,0)});						
	$("input[name=direccion]").keyup(function (){validar(this,0,0,0,0,99,0,0)});			
	$("input[name=telefono]" ).keyup(function (){validar(this,0,0,0,0,40,0,0)});			
	$("input[name=blog]"     ).keyup(function (){validar(this,0,0,0,0,99,0,0)});			
		
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
			
	
	$( "#formEnviar" ).submit(function( event ) {
		
	v1= validar("input[name=codigo]"   ,1,0,0,1,4,0,0);			
	v2= validar("input[name=nombre]"   ,0,1,0,1,99,0,0);			
	v3= validar("input[name=sigla]"    ,0,1,0,0,20,0,0);						
	v4= validar("input[name=direccion]",0,0,0,0,99,0,0);			
	v5= validar("input[name=telefono]" ,0,0,0,0,40,0,0);			
	v6= validar("input[name=blog]"     ,0,0,0,0,99,0,0);
		
		if ( v1 && v2 && v3 && v4 && v5 && v6 && v7) {
				return;				
			
		}else {
			alert("Hay campos con errores por favor verifique")
			event.preventDefault();
		}
	}); // fin submin
	
});
	
</script>
<?php 
}else{
echo"<br><h2 class='text-center'>El ID no existe en la tabla ".$_GET['tab']."</h2> <br>";
 ?> 
    <a href="cruds.php?tab=<?php echo $_GET['tab'] ?>">
    <button class="botonStandar center-block" type="button"><h4> &nbsp;&nbsp; Regresar &nbsp;&nbsp; </h4></button><br>
    </a> 
  <?php  		
	}	
 ?>