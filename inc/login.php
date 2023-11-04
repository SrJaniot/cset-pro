<section id="section1" class="colorfondo">
  <div class="container colorfondo ">
    <div class="row">
      <div class="col-xs-6 col-xs-push-3"> <img src="img/logoCP2.png" alt="CSET PRO" class="img-responsive"> </div>
    </div>
    <div class="row">
      <div class="col-xs-10 col-xs-push-1 col-md-8 col-md-push-2" >
        <div class="iniciarSesion">
          <h4 style="text-align:center; color:#686868;">Bienvenido al software de evaluacion y diagnostico del CSET.</h4>
          <br>
          <form action="controlador/validarInicioSesion.php" method="post" id="formIndex">

          
            <h3>Usuario</h3>
			
            <div class="input-group input-group-lg"> <span class="input-group-addon glyphicon glyphicon-user" id="sizing-addon1"></span>
              <input name="login" type="text" class="form-control" placeholder="Ingrese el numero de documento" aria-describedby="sizing-addon1">
            </div>
            <br>
            <h3>Contraseña</h3>
            <div class="input-group input-group-lg"> <span class="input-group-addon glyphicon glyphicon-lock" id="sizing-addon1"></span>
              <input name="pass" type="password" class="form-control" placeholder="Ingrese su contraseña" aria-describedby="sizing-addon1">
            </div>
            <h4 style="color:#FF3135" class="text-center">&nbsp; <?php echo $errorSesion; ?></h4>        
            <button type="submit" class="botonStandar center-block">
            <h3> &nbsp;&nbsp;&nbsp;  Ingresar &nbsp;&nbsp;&nbsp; </h3>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
$(document).ready(function() {1		

	$( "#formIndex" ).submit(function( event ) {
		v1= validar("input[name=login] ",0,0,0,1,100,0,0);
		v2= validar("input[name=pass]",0,0,0,1,100,0,0);

		if ( v1 && v2) {
			return;									
		}else {
			alert("Hay campos vacios")
			event.preventDefault();
		}
	});
});
	
</script>
