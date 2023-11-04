<?php 
session_start();
extract ($_REQUEST);
include ("modelo/conexion.php");
/*esta linea valida que exista una sesion, si no existe me manda al index, ademas valida
que el rol seal el indicado para la pagina si no es asi igualmente me manda a index*/
if(!isset($_SESSION['usuId'])){ header('location:index.php'); }
if($_SESSION['rol']!='instructor' and $_SESSION['rol']!='consultor'){ header('location:index.php'); }?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include 'inc/head.php'; ?>
<title>Aprendices</title>
</head>

<body>
<?php 
include 'inc/header.php'; // cabecera de la pagina
$nav=23 ; // esta variable indica la pasteña a la que se le modifica el css en el nav
include 'inc/nav.php'; //barra de navegacion
?>
<section id="section2" class="colorfondo" >
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        
        <h1 class="text-center" >Aprendices activos</h1>
        <table id="example" class="display" cellspacing="0" width="100%">
          <thead>
            <tr>
              <?php $resultado = consultaColumnasth('usuario2');?>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <?php $resultado = consultaColumnasth('usuario2');?>
            </tr>
          </tfoot>
        </table>

      </div>
    </div>

<div class="modal fade" id="mVentana" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Informacion del Aprendiz</h4>
      </div>
      <div class="modal-body" id="mContenido">
           <div class="container-fluid">
           
           </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
  </div>
</section>
<?php  include 'inc/footer.php'; //pie de pagina de la pagina?>
<script>

$(document).ready(function() {
	
	$('#example').dataTable( {
		"processing": true,
		"serverSide": true,
		"ajax": "modelo/server_processing.php?t=usuario2",
		"lengthMenu": [[15, 30, 50, 100], [15, 30, 50, 100]],
		 "pagingType": "full_numbers",
		"scrollX": true,
		"language":  idiomaDT,
	} );//datatable
	
	var table = $('#example').DataTable();
   
   	$('#example tbody').on( 'click', 'tr', function () {
		
		 if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				var id = (($( this ).children(":first").text()).split(" "))[0] 				
				//id = (id.split(" "))[0];
				//id = id[0];
				if(!isNaN(id)){

					$("#loadingAjax").fadeIn(300);
					$.ajax({
						url: "controlador/procesaModal.php", 
						type: "POST", 
						data: {proceso:"aprendiz",id:id}, 
						success: function(datos){
							$("#loadingAjax").fadeOut(300);
							$('#mContenido').html(datos)
							$('#mVentana').modal('show')		
						}
					});						
					
				} // if isnan
						
			}
			else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');			
			}	
	}); // fin if hasclass	
} ); // document

</script>
</body>
</html>