<?php 
// ajustar estas consultas
$id = $_GET['id'];
$tab = $_GET['tab'];
$idtab = substr($tab,0,3)."Id";
$resultado = consultaSql("select count(*) existe from $tab where $idtab =$id;");
$resultado = $resultado->fetch_object()->existe;
if($resultado){
	
$resultado = consultaSql("select * from auxiliar where auxid = $id;");

$auxiliar = htmlDecode($resultado->fetch_object());
//$auxiliar = $resultado->fetch_object();


?>

<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
<? // esta linea es para que me reconosoca las funciones ?>

<div class="row">
  <div class="col-xs-12">
    <form action="controlador/procesaAuxiliar.php" method="post" id="formDel">
      <input type="hidden" name="proceso" value="eliminar">
      <input type="hidden" name="id" value="<?php echo $auxiliar->auxId;?>">
      <button type="submit" class="botonStandar2" style="position: absolute; right:0px">
      <h4> &nbsp; <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> &nbsp;Eliminar&nbsp;&nbsp; </h4>
      </button>
    </form>
    
    <h2 class="text-center">Editar Nuevos Datos Auxiliares</h2>    
      <br>  
    <form action="controlador/procesaAuxiliar.php" method="post">
    <input type="hidden" name="proceso" value="modificar">
    <input type="hidden" name="auxId" value="">
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
        <h4> &nbsp;<span class="glyphicon glyphicon-share-alt invertirH" aria-hidden="true"></span>
        &nbsp;Cancelar&nbsp;&nbsp;&nbsp;&nbsp; </h4>
        </button>
        </a> </div>
      <div class="col-xs-6">
        <button type="submit" class="botonStandar">
        <h4>&nbsp;<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        &nbsp;Editar&nbsp;&nbsp;&nbsp;&nbsp; </h4>
        </button>
        <br>
      </div>
    </form>
  </div>
</div>

<script>
$(document).ready(function() {

 document.title = 'Editar Datos Auxiliares';
 
		//llenar los campos con los datos anteriores
		$("input[name=auxId]").val("<?php echo $auxiliar->auxId; ?>");
		$("input[name=clase]").val("<?php echo $auxiliar->auxClase; ?>");
		$("input[name=valor1]").val("<?php echo $auxiliar->auxValor1; ?>");
		$("input[name=valor2]").val("<?php echo $auxiliar->auxValor2; ?>");
		$("input[name=valor3]").val("<?php echo $auxiliar->auxValor3; ?>");
		
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