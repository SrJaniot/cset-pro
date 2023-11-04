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
<form action="controlador/procesaFicha.php" method="post" id="formDel">
  <input type="hidden" name="proceso" value="eliminar">
  <input type="hidden" name="id" value="<?php echo $oResultado->ficId;?>">
  <button type="submit" class="botonStandar2" style="position: absolute; right:0px">
  <h4> &nbsp; <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> &nbsp;Eliminar&nbsp;&nbsp; </h4>
  </button>
</form> 
    <h2 class="text-center">Modificar Ficha</h2>
    <br>
    <form action="controlador/procesaFicha.php" method="post" id="#formEnviar">
      <input type="hidden" name="proceso" value="modificar">
      <input type="hidden" name="codigox">
      <div class="col-xs-12 col-sm-3">
        <label>
        <h4>Codigo</h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="Numero de ficha" name="codigo">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>
      <div class="col-xs-12 col-sm-9">
        <label>
        <h4>Nombre del programa</h4>
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
      <div class="clearfix"></div>
      <div class="col-xs-12 col-sm-9">
        <label >
        <h4>Centro al que pertenece</h4>
        </label>
        <select id=""  class="form-control" name="centro">
          <?php $resultado = consultaSql("select cenId, cenNombre from centroformacion order by cenNombre;");
		 while($res=$resultado->fetch_object()){?>
          <option value="<?php echo $res->cenId ?>"><?php echo $res->cenNombre ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-xs-12 col-sm-3">
        <label>
        <h4>Sede</h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="Principal u otra" name="sede">
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
        <h4>Jornada</h4>
        </label>
        <select id=""  class="form-control" name="jornada">
          <?php $resultado = consultaSql("select auxvalor1 'jornada' from auxiliar where auxclase = 'jornada'  order by auxvalor1;");
		 while($res=$resultado->fetch_object()){?>
          <option value="<?php echo $res->jornada ?>">
          <?php  echo $res->jornada ?>
          </option>
          <?php } ?>
        </select>
      </div>
      <div class="col-xs-12 col-sm-3">
        <label >
        <h4>Nivel</h4>
        </label>
        <select id=""  class="form-control" name="nivel">
          <?php $resultado = consultaSql("select auxvalor1 'nivel' from auxiliar where auxclase = 'nivel' order by auxvalor1;");
		 while($res=$resultado->fetch_object()){?>
          <option value="<?php echo $res->nivel ?>"><?php echo $res->nivel ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-xs-12 col-sm-3">
        <label>
        <h4>Fecha Inicio</h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="AAAA/MM/DD" name="inicio">
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
      <div class="col-xs-6"> <a href="cruds.php?tab=ficha">
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
	
 document.title = 'Modificar Ficha';
 
 	$( '#formDel').submit(function( event ) {	
		var r = confirm("¿Esta seguro que desea eliminar este Registro?");
		if (r == true) {
			return;						
		}else {
			event.preventDefault();
		}
	}); // formdel
 
$("input[name=codigo]").val("<?php echo $oResultado->ficId; ?>");
$("input[name=codigox]").val("<?php echo $oResultado->ficId; ?>");
$("input[name=nombre]").val("<?php echo $oResultado->ficNombre; ?>");
$("input[name=sede]").val("<?php echo $oResultado->ficSede; ?>");
$("input[name=inicio]").val("<?php echo $oResultado->ficInicio; ?>");
$("select[name=centro]").val("<?php echo $oResultado->cenId;?>")
$("select[name=nivel]").val("<?php echo $oResultado->ficNivelTec;?>")
$("select[name=estado]").val("<?php echo $oResultado->ficEstado;?>")

$("input[name=codigo]").prop('disabled', 'disabled');

// ********************** funcion validar selector,numeros,letras,decimales,min,max,valormax,especial
	$("input[name=codigo]").keyup(function (){validar(this,1,0,0,1, 7,0,0)});			
	$("input[name=nombre]").keyup(function (){validar(this,0,1,0,1,49,0,0)});			
	$("input[name=sede]"  ).keyup(function (){validar(this,0,1,0,0,40,0,0)});						
	$("input[name=inicio]").keyup(function (){validar(this,0,0,0,1,10,0,3)});						
	
	$( "#formEnviar" ).submit(function( event ) {
		
	v1 = validar("input[name=codigo]",1,0,0,1, 7,0,0);			
	v2 = validar("input[name=nombre]",0,1,0,1,49,0,0);			
	v3 = validar("input[name=sede]"  ,0,1,0,0,40,0,0);						
	v4 = validar("input[name=inicio]",0,0,0,1,10,0,3);
		
		var campo = $("input[name=codigo]").val();
		var tabla = "<?php echo $_GET['tab'] ?>";
		v7= validarId(campo,tabla);

		if ( v1 && v2 && v3 && v4) {
				return;				
		
		}else {
			alert("Hay campos con errores por favor verifique")
			event.preventDefault();
		}
	});
 
 	
 
 
});

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
