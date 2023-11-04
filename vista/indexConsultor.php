<?php 
require "modelo/conexion.php";
 ?>

<section id="section2" class="colorfondo" >
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        
        <h1 class="text-center" >Pruebas Existentes</h1>
        <table id="example" class="display" cellspacing="0" width="100%">
          <thead>
            <tr>
              <?php $resultado = consultaColumnasth('prueba2');?>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <?php $resultado = consultaColumnasth('prueba2');?>
            </tr>
          </tfoot>
        </table>

      </div>
    </div>
  </div>
</section>

<script>

$(document).ready(function() {
	
	$('#example').dataTable( {
		"processing": true,
		"serverSide": true,
		"ajax": "modelo/server_processing.php?t=prueba2",
		"lengthMenu": [[15, 30, 50, 100], [15, 30, 50, 100]],
		 "pagingType": "full_numbers",
		  "order": [[ 0, "desc" ]],
		"scrollX": true,
		"language":  idiomaDT,
	} );//datatable
	
	var table = $('#example').DataTable();
   
   	$('#example tbody').on( 'click', 'tr', function () {
		
		 if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				var id = $( this ).children(":first").text();					
				if(!isNaN(id)){
				window.open("monitorPrueba.php?id="+ id, "_self");			
					}															
			}
			else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');			
			}	
	}); // fin if hasclass	
} ); // document

</script>