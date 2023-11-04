<?php 
session_start();
extract ($_REQUEST);
include ("modelo/conexion.php");
/*esta linea valida que exista una sesion, si no existe me manda al index, */
if(!isset($_SESSION['usuId'])){ header('location:index.php'); }
	$id = $_SESSION['usuId'];
	$resultado = consultaSql("select * from usuario where usuid=$id");
	$res = $resultado->fetch_object();
	
	$resultado = consultaSql("select * from institucion2 where usuid =$id");
	$colegio = $resultado->fetch_object();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include 'inc/head.php'; ?>
<title>Perfil</title>
</head>

<body>
<?php 
include 'inc/header.php'; // cabecera de la pagina
$nav=11 ; // esta variable indica la pasteña a la que se le modifica el css en el nav
include 'inc/nav.php'; //barra de navegacion
?>
<section id="section2" class="colorfondo" >
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1 class="text-center" >Perfil de usuario <?php echo $res->usuRol; ?></h1>
        <br>
        <div class="col-xs-6 col-xs-push-3 col-sm-4 col-sm-push-0"> <img  style="width:100%" class="img-thumbnail" src="img/fperfil/<?php echo $res->usuFoto; ?>" alt="foto"> </div>
        <div class="col-xs-12 col-sm-8">
          <h3><?php echo 
			$res->usuNombre1." ".$res->usuNombre2." ".
			$res->usuApellido1." ".$res->usuApellido2; ?> </h3>
          <h4><?php echo $res->usuTipoDoc." ".$res->usuNumeroDoc?></h4>
          <br>
          <?php if($res->ficId != ""){
			$resultado = consultaSql("select * from ficha where ficid = $res->ficId;");
			$ficha = $resultado->fetch_object();
		?>
          <h4>Ficha: <strong><?php echo $ficha->ficId; ?></strong></h4>
          <h4>Nombre: <strong><?php echo $ficha->ficNombre; ?></strong></h4>
          <h4>Jornada: <strong><?php echo $ficha->ficJornada; ?></strong></h4>
          <?php }?>
          <br>
          <h4>Telefono: <strong><?php echo $res->usuTelefono; ?></strong></h4>
          <h4>Celular: <strong><?php echo $res->usuCelular; ?></strong></h4>
          <h4>Correo: <strong><?php echo $res->usuCorreo; ?></strong></h4>
          <h4>Nacimiento: <strong><?php echo $res->usuFechaNacimiento; ?></strong></h3>
          <h4>Genero: <strong><?php echo $res->usuSexo; ?></strong></h4>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12">
          <?php 
		 if($colegio){ ?>
          <hr>
          <form action="controlador/procesaInsUsu.php" method="post" id="formEnviar3">
            <input type="hidden" name="proceso" value="eliminar">
            <input type="hidden" name="id" value="<?php echo $colegio->insusuid;?>">
            <button type="submit" class="botonStandar2" style="position: absolute; right:0px">
            <h4> &nbsp; <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
             &nbsp;Desvincular&nbsp;&nbsp; </h4>
            </button>
          </form>
          <h2 class="text-center">Datos de Institucion de usuario</h2>
          <h4>Institucion: <strong><?php echo $colegio->insnombre; ?></strong></h3>
          <h4>Sede: <strong><?php echo $colegio->sednombre; ?></strong></h3>
          <h4>Titulo Obtenido: <strong><?php echo $colegio->insusutipo; ?> - <?php echo $colegio->insusutitulo; ?></strong></h3>
          <h4>Curso hasta: <strong><?php echo $colegio->insusucursado; ?></strong></h4>
          <h4>Ultimo año: <strong><?php echo $colegio->insusufin; ?></strong></h4>
          <h4>Graduado: <strong><?php echo $colegio->graduado; ?></strong></h4>
          <?php }else { ?> 
          
           <?php } ?>
        </div>
        <br>
        <hr>
      </div>
    </div>
    <div class="row">
      <hr>
      <h1 class="text-center" >Cambiar contraseña</h1>
      <div class="col-xs-12 col-sm-4">
        <div class="form-group has-feedback mb">
          <input type="password" maxlength="20" class="form-control input-lg has-error" placeholder="Contraseña Actual" name="pass1">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>
      <div class="col-xs-12 col-sm-4">
        <div class="form-group has-feedback mb">
          <input type="password" maxlength="20"  class="form-control input-lg has-error" placeholder="Contraseña Nueva" name="pass2">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <label class="control-label mb">
          <h4 class="mb"></h4>
          </label>
        </div>
        <h4></h4>
      </div>
      <div class="col-xs-12 col-sm-4">
        <button type="button" class="botonStandar" id="pass">
        <h4> &nbsp; <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> &nbsp;Cambiar Contraseña&nbsp;&nbsp; </h4>
        </button>
      </div>
    </div>
    <div class="row"> <br>
      <hr>
      <h1 class="text-center" >Cambiar Datos personales</h1>
      <form action="controlador/cambiaDatosUsuario.php" method="post" id="formEnviar">
        <input type="hidden" name="id">
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
        <div class="col-xs-12 col-sm-4"> <br>
          <br>
          <button type="submit" class="botonStandar" id="enviar" style="float:right">
          <h4> &nbsp;&nbsp;Guardar los datos personales&nbsp;&nbsp; </h4>
          </button>
        </div>
      </form>
    </div>
    <!-- fin row -->
    
    <?php if( $res->usuRol == 'aprendiz'){ ?>
    <div class="row"> <br>
      <hr>
      <h1 class="text-center" >Seleccionar Institucion Educativa</h1>
      <div class="col-xs-12 col-sm-3">
        <label >
        <h4>Departamento </h4>
        </label>
        <select id=""  class="form-control" name="departamento">
          <?php $resultado = consultaSql("select DISTINCT(mundepartamento) dep from municipio order by mundepartamento");
		 while($resx=$resultado->fetch_object()){?>
          <option value="<?php echo $resx->dep?>"><?php echo $resx->dep?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-xs-12 col-sm-3">
        <label >
        <h4>Municipio </h4>
        </label>
        <select id=""  class="form-control" name="municipio">
          <?php $resultado = consultaSql("select munid, munnombre from municipio where mundepartamento = 'santander';");
		 while($resx=$resultado->fetch_object()){?>
          <option value="<?php echo $resx->munid ?>"><?php echo $resx->munnombre ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-xs-12 col-sm-4"> <br>
        <br>
        <button type="button" class="botonStandar3" id="filtrar" style="float:right">
        <h4> &nbsp;&nbsp;Buscar un colegio&nbsp;&nbsp; </h4>
        </button>
      </div>
      <div class="clearfix"></div>
      <div class="col-xs-12" id="divTabla"> <br>
        <br>
        <table id="example" class="display" cellspacing="0" width="100%">
          <thead>
            <tr>
              <?php $resultado = consultaColumnasth("sede2");?>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <?php $resultado = consultaColumnasth("sede2");?>
            </tr>
          </tfoot>
        </table>
      </div>
      <form method="post" action="controlador/procesaInsUsu.php" id="formEnviar2">
        <div class="col-xs-12">
          <hr>
          <br>
          <h3 id="fmun">Ciudad: </h3>
          <input type="hidden" name="fusuId" value="<?php echo $res->usuId; ?>">
          <input type="hidden" name="finsId">
          <input type="hidden" name="proceso" value="agregar">
          <h3 id="fins">Institucion: </h3>
          <input type="hidden" name="fsedId">
          <h3 id="fsed">Sede: </h3>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-4">
          <label >
          <h4>Clase de titulo</h4>
          </label>
          <select id=""  class="form-control" name="ftitulo">
            <?php $resultado = consultaSql("select * from auxiliar where auxclase = 'titulos' limit 1;");
		 while($resy=$resultado->fetch_object()){?>
            <option value="<?php echo $resy->auxValor1 ?>"><?php echo $resy->auxValor1 ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-xs-12 col-sm-4">
          <label>
          <h4>Titulo obtenido</h4>
          </label>
          <div class="form-group has-feedback mb">
            <input type="text"  class="form-control input-lg has-error" placeholder="Ej: Bachiller comercial, ing electronico..." name="fobtenido">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <label class="control-label mb">
            <h4 class="mb"></h4>
            </label>
          </div>
          <h4></h4>
        </div>
        <div class="col-xs-12 col-sm-4">
          <label >
          <h4>Nivel al que llego</h4>
          </label>
          <select id=""  class="form-control" name="fnivel">
            <option value="Grado once">Grado once</option>
            <option value="Grado Decimo">Grado Decimo</option>
            <option value="Grado Noveno">Grado Noveno</option>
            <!--
          <option value="">Primer semestre</option>
          <option value="">Segundo semestre</option>
          <option value="">Tercer semestre</option>
          <option value="">Cuarto semestre</option>
          <option value="">Quinto semestre</option>
          <option value="">Sexto semestre</option>
          <option value="">Octavo semestre</option>
          <option value="">Noveno semestre</option>
          <option value="">Decimo semestre</option>
            -->
          </select>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-4">
          <label >
          <h4>Graduado</h4>
          </label>
          <select id=""  class="form-control" name="fgraduado">
            <option value="1">Si</option>
            <option value="0">No</option>
          </select>
        </div>
        <div class="col-xs-12 col-sm-4">
          <label>
          <h4>Ultimo año cursado en esa institucion</h4>
          </label>
          <div class="form-group has-feedback mb">
            <input type="text"  class="form-control input-lg has-error" placeholder="" name="fultimo">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <label class="control-label mb">
            <h4 class="mb"></h4>
            </label>
          </div>
          <h4></h4>
        </div>
        <div class="col-xs-12 col-sm-4"> <br>
          <br>
          <button type="submit" class="botonStandar" id="filtrar" style="float:left">
          <h4> &nbsp;&nbsp;Guardar Colegio&nbsp;&nbsp; </h4>
          </button>
        </div>
      </form>
    </div>
    <!-- fin row -->
    <?php } // fin de la considicon usurol?>
  </div>
</section>
<?php  include 'inc/footer.php'; //pie de pagina de la pagina?>
<script>

$(document).ready(function() {

	$( '#formEnviar3').submit(function( event ) {
		
		var r = confirm("¿Esta seguro que desea Desvincular este Instituto?");
		if (r == true) {
			//alert("se elimino para siempre")
			//event.preventDefault();	
			return;						
		}else {
			event.preventDefault();
		}
	}); // formdel

$('#divTabla').hide();
  var uno = 1; // para condicionar que solo se ejecute algo la primera vez
$('#filtrar').click(function () {
	$('#divTabla').show(); 			
	var munid = $("select[name=municipio]").val()	
	var enlace = "modelo/server_processing2.php?t=sede2&munid=" + munid;
	//alert(enlace);
	var table = $('#example').dataTable( {
		"destroy": true,
		//configuraciones para conectar al server
		"processing": true,
		"serverSide": true,
		"ajax": enlace,
		
		//longitud de la consulta "-1 para mostrar todos los registros"
		"lengthMenu": [[5, 30, 50, 100], [5, 30, 50, 100]],
		//paga que hacer visibles los botones "primero" y "ultimo"
		 "pagingType": "full_numbers",
		 // mostrar el scroll horizontal
		"scrollX": true,
		
		//configuraciones para cambiar idioma de etiquetas
		"language": {
			  	"processing":     "Procesando...",
				"lengthMenu":     "Mostrar  _MENU_ registros",
				"zeroRecords":    "No se encontraron resultados",
				"emptyTable":     "Ningún dato disponible en esta tabla",
				"info":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				"infoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
				"infoFiltered":   "(filtrado de un total de _MAX_ registros)",
				"infoPostFix":    "",
				"search":         "Buscar:",
				"loadingRecords": "Cargando...",	
				"oPaginate": {
					"sFirst":    "Primero",
					"sLast":     "Último",
					"sNext":     "Siguiente",
					"sPrevious": "Anterior"
				},
				"oAria": {
					"sortAscending":  ": Activar para ordenar la columna de manera ascendente",
					"sortDescending": ": Activar para ordenar la columna de manera descendente"
				}
			} // language
	} );//datatable
	
  // var table = $('#example').DataTable();

   if(uno == 1){
	   uno = 0;
		$('#example tbody').on( 'click', 'tr', function () {
		//console.log("asdf");
		 if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}	
		});	
		
		$('#example tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') == false ) {
			var id1 = $( this ).children(":nth-child(1)").text()
			var na1 = $( this ).children(":nth-child(2)").text()
			var id2 = $( this ).children(":nth-child(3)").text()
			var na2 = $( this ).children(":nth-child(4)").text()
			 
			$("input[name=finsId]").val(id1);
			$("input[name=fsedId]").val(id2);
			$("#fmun").text("Ciudad: " + $("select[name=municipio] option:selected").text());
			$("#fins").text("Institucion: " + na1);
			$("#fsed").text("Sede: " + na2);	
			
			$('#divTabla').hide(1000);		
			}		
		});	// fin de example table t body		
			   
	  }//fin if
	
}); // fin click enviar
	
	
	$("select[name=departamento]").val("Santander")
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

// funciones aplicadas en el modulo de editar datos personales
	
    $("input[name=id]"             ).val("<?php echo $res->usuId; ?>");		
    $("input[name=telefono]"       ).val("<?php echo $res->usuTelefono; ?>");		
	$("input[name=celular]"        ).val("<?php echo $res->usuCelular; ?>");		
	$("input[name=correo]"         ).val("<?php echo $res->usuCorreo; ?>");			
	$("input[name=fecha]"          ).val("<?php echo $res->usuFechaNacimiento; ?>");	
	$("select[name=sexo]"          ).val("<?php echo $res->usuSexo; ?>")
	
	$("input[name=telefono]"       ).keyup(function (){validar(this,1,0,0,7, 7,0,0)});			
	$("input[name=celular]"        ).keyup(function (){validar(this,1,0,0,10,10,0,0)});			
	$("input[name=correo]"         ).keyup(function (){validar(this,0,0,0,0,90,0,1)});			
	$("input[name=fecha]"          ).keyup(function (){validar(this,0,0,0,0,10,0,3)});	
	
	$( "#formEnviar" ).submit(function( event ) {	
		
		v6 = validar("input[name=telefono]"       ,1,0,0,7, 7,0,0);			
		v7 = validar("input[name=celular]"        ,1,0,0,10,10,0,0);			
		v8 = validar("input[name=correo]"         ,0,0,0,0,90,0,1);			
		v9 = validar("input[name=fecha]"          ,0,0,0,0,10,0,3);			
				
		//al presionar submit comprueba todos los campos y consultas ajax				
		if ( v6 && v7 && v8 && v9) {

			return;	
													
		}else {
			alert("Hay campos con errores por favor verifique")
			event.preventDefault();
		}
	}); //fin form submit


	$("input[name=fobtenido]"        ).keyup(function (){validar(this,0,1,0,1,40,0,0)});
	$("input[name=fultimo]"          ).keyup(function (){validar(this,1,0,0,4,4,0,0)});

	$( "#formEnviar2" ).submit(function( event ) {	
									
		if($("input[name=finsId]").val()== '')	{
			alert("selecione un colegio")
			event.preventDefault();
		} else {
		
			v6 = validar("input[name=fobtenido]"      ,0,1,0,1,40,0,0);			
			v7 = validar("input[name=fultimo]"        ,1,0,0,4,4,0,0);	
						
			//al presionar submit comprueba todos los campos y consultas ajax				
			if ( v6 && v7) {
	
				return;	
														
			}else {
				alert("Hay campos con errores por favor verifique")
				event.preventDefault();
			}					
		}			
	}); //fin form submit	
		
		
// funciones aplicadas en el modulo de contraseñas	
	
	$("input[name=pass1]").keyup(function (){validar(this,0,0,0,1,20,0,2)});	
	$("input[name=pass2]").keyup(function (){validar(this,0,0,0,1,20,0,2)});	

	$ ("#pass").click(function () {
		
		v1 = validar("input[name=pass1]",0,0,0,1,20,0,2);			
		v2 = validar("input[name=pass2]",0,0,0,1,20,0,2);	
		if(v1 && v2){
			
			var pass1 = $("input[name=pass1]").val();
			var pass2 = $("input[name=pass2]").val();
			var id    = "<?php echo $res->usuId; ?>";
			
			$.ajax({
				type: "POST", 								
				url:"controlador/cambiarPass.php", 
				data: {id:id,pass1:pass1,pass2:pass2},  
				success: function(datos){
				alert(datos);
				}
			});				
		}// fin if							
	}); // fin click pass
	
	<?php 
if(isset($_GET['res'])) {
switch ($_GET['res']) {
		case "1":
		echo "alert('Se modificaron los datos exitosamente');";
		break;

		case "2":
		echo "alert('ocurrio un error al ingresar los datos, vuelva a intentarlo');";
		break;
	}
}
	 ?>		
});// fin ready

	
</script>
</body>
</html>