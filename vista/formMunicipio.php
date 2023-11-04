<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"><? // esta linea es para que me reconosoca las funciones ?>
<div class="row">
  <div class="col-xs-12">

    <h2 class="text-center">Agregar Nuevo municipio</h2>
    <br>

    <form action="controlador/procesaMunicipio.php" method="post">
     <input type="hidden" name="proceso" value="agregar">
      <div class="col-xs-12 col-sm-5">
        <label >
        <h4>Departamento </h4>
        </label>
        <select id=""  class="form-control" name="departamento">
          <?php $resultado = consultaSql("select  SUBSTRING(munid,1,2) id, mundepartamento 'departamento' from municipio group by mundepartamento;");
		 while($res=$resultado->fetch_object()){?>
          <option value="<?php echo $res->id ?>"><?php echo $res->departamento ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-xs-4 col-sm-7">
        <label>
        <h4>Ciudad capital </h4>
        </label>
        <br>
        <div>
          <label class="radio-on">
            <input type="radio" name="capital" value="0" class="radio-hidden"  checked >
            NO </label>
          <label  class="radio-off">
            <input type="radio" name="capital" value="1" class="radio-hidden">
            SI </label>
        </div>
      </div>
      <div class="clearfix"></div>
      <br>
      
      <div class="col-xs-12 col-sm-4">
        <label>
        <h4>Codigo Municipal </h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="3 digitos numericos..." name="codigo">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>
      
      <div class="col-xs-12 col-sm-8">
        <label>
        <h4>Nombre del muncipio </h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="Ingrese el nombre" name="nombre">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
      </div>
      
      <div class="clearfix"></div>
      <div class="col-xs-6 col-sm-3">
        <label>
        <h4>Categoria</h4>
        </label>
        <select id=""  class="form-control" name="categoriaLey">
          <option value="">Ninguno...</option>
          <?php $resultado = consultaSql("select DISTINCT(munCategoriaLey) as 'categoria' from municipio where munCategoriaLey != '' order by categoria;");
		 while($res=$resultado->fetch_object()){?>
          <option value="<?php echo $res->categoria ?>"><?php echo $res->categoria ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-xs-6 col-sm-3">
        <label>
        <h4>Desarrollo </h4>
        </label>
        <select id=""  class="form-control" name="desarrollo">
          <option value="">Ninguno...</option>
          <?php $resultado = consultaSql("select DISTINCT(municipio.munDesarrollo) as 'desarrollo' from municipio where mundesarrollo != '' order by desarrollo;");
		 while($res=$resultado->fetch_object()){?>
          <option value="<?php echo $res->desarrollo ?>"><?php echo $res->desarrollo ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-xs-6 col-sm-3">
        <label>
        <h4>Desempeño </h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="De 0.00 a 100.00 " name="desempeno">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>      </div>
      <div class="col-xs-6 col-sm-3">
        <label >
        <h4>Calificacion</h4>
        </label>
        <select id=""  class="form-control" name="calificacion">
          <option value="">Ninguno...</option>
          <?php $resultado = consultaSql("select DISTINCT(municipio.munCalificacion) as 'calificacion' from municipio where muncalificacion != '' order by calificacion;");
		 while($res=$resultado->fetch_object()){?>
          <option value="<?php echo $res->calificacion ?>"><?php echo $res->calificacion ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="clearfix"></div>
      <br>
      
      <div class="col-xs-6">
      <a href="cruds.php?tab=municipio">
         <button type="button" class="botonStandar2" style="float:right">
        <h4> &nbsp;&nbsp;&nbsp;&nbsp;Cancelar&nbsp;&nbsp;&nbsp;&nbsp; </h4>
        </button> 
       </a>       
      </div>
      
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
$(document).ready(function() {1
	
 document.title = 'Agregar Municipio';

	$("input[name=capital]").change(function (){radioOn(this)});

	$("input[name=nombre]"   ).keyup(function (){validar(this,0,1,0,3,40,0,0)});			
	$("input[name=codigo]"   ).keyup(function (){validar(this,1,0,0,3,3,0,0)});	
	$("input[name=desempeno]").keyup(function (){validar(this,1,0,1,0,5,100,0)});
		

	$( "form" ).submit(function( event ) {
		v1= validar("input[name=nombre]",0,1,0,3,40,0,0);
		v2= validar("input[name=codigo]",1,0,0,3,3,0,0);
		v3= validar("input[name=desempeno]",1,0,1,0,5,100,0);
		var campo = $("select[name=departamento]").val() + $("input[name=codigo]").val();
		var tabla = "<?php echo $_GET['tab'] ?>";
		v4= validarId(campo,tabla);
		//console.log(v1 +v2 +v3);
		if ( v1 && v2 && v3) {
			if(v4==0){
				//alert("se envio");
				//event.preventDefault();	
				return;				
			}else{
				alert("Ya existe un municipio con el codigo "+ $("input[name=codigo]").val() 
				+" en el departamento de "+ $("select[name=departamento] option:selected").text());
				event.preventDefault();			
			}			
		}else {
			alert("Hay campos con errores por favor verifique")
			event.preventDefault();
		}
	});
});
	
</script>