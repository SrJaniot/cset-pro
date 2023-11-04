<?php 
$id = $_GET['id'];
$tab = $_GET['tab'];
$idtab = substr($tab,0,3)."Id";
$resultado = consultaSql("select count(*) existe from $tab where $idtab = $id; ");
$resultado = $resultado->fetch_object()->existe;
if($resultado){
	
$resultado = consultaSql("select * from municipio where munId = $id;");
$municipio = $resultado->fetch_object();
?>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
<div class="row">
  <div class="col-xs-12">
 
    <form action="controlador/procesaMunicipio.php" method="post" id="formDel">
      <input type="hidden" name="proceso" value="eliminar">
      <input type="hidden" name="id" value="<?php echo $municipio->munId;?>">
      <button type="submit" class="botonStandar2" style="position: absolute; right:0px">
      <h4> &nbsp; <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> &nbsp;Eliminar&nbsp;&nbsp; </h4>
      </button>
    </form>
     
    <h2 class="text-center">Editar municipio</h2>
    <br>
    <form action="controlador/procesaMunicipio.php" method="post"  id="formEdit">
      <input type="hidden" name="proceso" value="modificar">
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
          <label>
            <input type="radio" name="capital" value="0" class="radio-hidden">
            NO </label>
          <label>
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
          <input type="text"  class="form-control input-lg has-error" placeholder="3 digitos numericos..." name="codigo" >
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4 id="codigoE"></h4>
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
          <option value="NULL">Ninguno...</option>
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
        </div>
      </div>
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
        <h4> &nbsp;<span class="glyphicon glyphicon-share-alt invertirH" aria-hidden="true"></span>
        &nbsp;Cancelar&nbsp;&nbsp;&nbsp;&nbsp; </h4>
        </button> 
       </a>       
      </div>
      
      <div class="col-xs-6">
        <button type="submit" class="botonStandar">
        <h4> &nbsp;&nbsp;<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;&nbsp;Editar&nbsp;&nbsp;&nbsp;&nbsp; </h4>
        </button>
        <br>
      </div>
      <input type="hidden" name="departamentox">
      <input type="hidden" name="codigox">
    </form>
  </div>
</div>
<script>

$(document).ready(function() {

	$('input[name=capital][value=<?php echo $municipio->munCapital;?>]').attr('checked', true); 	
	$("input[name=capital][type=radio][checked=checked]").parent().addClass("radio-on");
	$("input[name=capital][type=radio][checked=checked]").parent().siblings().addClass("radio-off"); 	
	$("input[name=capital]").change(function (){radioOn(this)});	
					
	$("select[name=departamento]").val("<?php echo substr($municipio->munId,0,2);?>")
	$("input[name=departamentox]").val($("select[name=departamento]").val())
	$("select[name=departamento]").prop('disabled', 'disabled');	
	$("select[name=departamento]").attr('name', '');
	$("input[name=departamentox]").attr('name', 'departamento');
	
	$("input[name=codigo]").val("<?php echo substr($municipio->munId,2,3);?>");
	$("input[name=codigox]").val($("input[name=codigo]").val());
	$("input[name=codigo]").prop('disabled', 'disabled');
	$("input[name=codigo]").attr('name', '');
	$("input[name=codigox]").attr('name', 'codigo');
	
	
	$("input[name=nombre]").val("<?php echo $municipio->munNombre ?>");
	
	$("select[name=categoriaLey]").val("<?php echo $municipio->munCategoriaLey ?>");
	$("select[name=desarrollo]").val("<?php echo $municipio->munDesarrollo ?>");
	$("input[name=desempeno]").val("<?php echo $municipio->munDesempeño ?>");
	$("select[name=calificacion]").val("<?php echo $municipio->munCalificacion ?>");

	$("input[name=nombre]"   ).keyup(function (){validar(this,0,1,0,3,40,0,0)});			
	$("input[name=codigo]"   ).keyup(function (){validar(this,1,0,0,3,3,0,0)});	
	$("input[name=desempeno]").keyup(function (){validar(this,1,0,1,0,5,100,0)});
		
	$( "#formEdit" ).submit(function( event ) {
		v1= validar("input[name=nombre]",0,1,0,3,40,0,0);
		v2= validar("input[name=codigo]",1,0,0,3,3,0,0);
		v3= validar("input[name=desempeno]",1,0,1,0,5,100,0);

		if ( v1 && v2 && v3) {
/* 	$("select[name=departamento]").prop('disabled', false); */
/* 	$("input[name=codigo]").prop('disabled', false); */
			
		return;						
		}else {
		alert("Hay campos con errores por favor verifique")
		event.preventDefault();
		}
	}); //form
		
	$( '#formDel').submit(function( event ) {
		
		var r = confirm("¿Esta seguro que desea eliminar este Registro?");
		if (r == true) {
			//alert("se elimino para siempre")
			//event.preventDefault();	
			return;						
		}else {
			event.preventDefault();
		}
	}); // formdel

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
