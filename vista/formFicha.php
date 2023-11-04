<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
<? // esta linea es para que me reconosoca las funciones ?>
<div class="row">
  <div class="col-xs-12">
    <h2 class="text-center">Agregar Nueva Ficha</h2>
    <br>
    <form action="controlador/procesaFicha.php" method="post">
      <input type="hidden" name="proceso" value="agregar">
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
          <input type="text"  class="form-control input-lg has-error" placeholder="" name="nombre" value="">
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
          <?php $resultado = consultaSql("select codigo, centroformacion1.`Nombre del Centro` 'Centro', departamento from centroformacion1 order by Departamento, `Nombre del Centro`;;");
		 while($res=$resultado->fetch_object()){?>
          <option value="<?php echo $res->Codigo ?>"><?php echo $res->Departamento." - ".$res->Centro ?></option>
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
          <option value="<?php echo $res->jornada ?>"><?php  echo $res->jornada ?></option>
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
          <input type="text"  class="form-control input-lg has-error" placeholder="AAAA/MM/DD" name="inicio" value="">
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
        <h4> &nbsp;&nbsp;&nbsp;&nbsp;Anadir&nbsp;&nbsp;&nbsp;&nbsp; </h4>
        </button>
        <br>
      </div>
    </form>
  </div>
</div>
<script>
$(document).ready(function() {
	
 document.title = 'Agregar Ficha del Centro';

// ********************** funcion validar selector,numeros,letras,decimales,min,max,valormax,especial
	$("input[name=codigo]").keyup(function (){validar(this,1,0,0,1, 7,0,0)});			
	$("input[name=nombre]").keyup(function (){validar(this,0,1,0,1,49,0,0)});			
	$("input[name=sede]"  ).keyup(function (){validar(this,0,1,0,0,40,0,0)});						
	$("input[name=inicio]").keyup(function (){validar(this,0,0,0,1,10,0,3)});						
	
	$("select[name=centro]").val("9309")
	$("select[name=nivel]").val("tecnologo")
	
	$( "form" ).submit(function( event ) {
		
	v1 = validar("input[name=codigo]",1,0,0,1, 7,0,0);			
	v2 = validar("input[name=nombre]",0,1,0,1,49,0,0);			
	v3 = validar("input[name=sede]"  ,0,1,0,0,40,0,0);						
	v4 = validar("input[name=inicio]",0,0,0,1,10,0,3);
		
		var campo = $("input[name=codigo]").val();
		var tabla = "<?php echo $_GET['tab'] ?>";
		v7= validarId(campo,tabla);

		if ( v1 && v2 && v3 && v4) {
			if(v7==0){
				//alert("se envio");
				//event.preventDefault();	
				return;				
			}else{
				alert("Ya existe una ficha con el codigo "+ $("input[name=codigo]").val());
				event.preventDefault();			
			}			
		}else {
			alert("Hay campos con errores por favor verifique")
			event.preventDefault();
		}
	});
});
	
</script>