<? // esta linea es para que me reconosoca las funciones ?>

<div class="row">
  <div class="col-xs-12">
    <h2 class="text-center">Agregar Nuevos Datos Auxiliares</h2>
    <br>
    <form action="controlador/procesaAuxiliar.php" method="post">
    <input type="hidden" name="proceso" value="agregar">
      <div class="col-xs-12 col-sm-6">
        <label>
        <h4>Clase </h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="" name="clase">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>
      <div class="col-xs-12 col-sm-6">
        <label>
        <h4>Valor 1 </h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="" name="valor1">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>
      <div class="col-xs-12 col-sm-6">
        <label>
        <h4>Valor 2 </h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="" name="valor2">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4 ></h4>
      </div>
      <div class="col-xs-12 col-sm-6">
        <label>
        <h4>Valor 3 </h4>
        </label>
        <div class="form-group has-feedback mb">
          <input type="text"  class="form-control input-lg has-error" placeholder="" name="valor3">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>

<div class="clearfix"></div> <br>
      <div class="col-xs-6"> <a href="cruds.php?tab=auxiliar">
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
$(document).ready(function() {1
	
 document.title = 'Agregar Datos Auxiliares';

	$("input[name=clase]").keyup(function (){validar(this,0,0,0,1,100,0,0)});			
	$("input[name=valor1]").keyup(function (){validar(this,0,0,0,0,100,0,0)});			
	$("input[name=valor2]").keyup(function (){validar(this,0,0,0,0,100,0,0)});			
	$("input[name=valor3]").keyup(function (){validar(this,0,0,0,0,100,0,0)});			

	$( "form" ).submit(function( event ) {
		v1= validar("input[name=clase] ",0,0,0,1,100,0,0);
		v2= validar("input[name=valor1]",0,0,0,0,100,0,0);
		v3= validar("input[name=valor2]",0,0,0,0,100,0,0);
		v3= validar("input[name=valor3]",0,0,0,0,100,0,0);

		if ( v1 && v2 && v3) {
			return;									
		}else {
			alert("Hay campos con errores por favor verifique")
			event.preventDefault();
		}
	});
});
	
</script>