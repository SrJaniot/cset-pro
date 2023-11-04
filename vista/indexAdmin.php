<?php 
require "modelo/conexion.php";
 ?>

<section id="section2" class="colorfondo" >
  <div class="container">
    <div class="row">
    
    
      <div class="col-xs-12">
        <h1 class="text-center" >Solicitudes de usuarios</h1> 
	        <table align="center" class="table table-bordered" >
          <thead>
            <tr>
              <th >Usuario</th>
              <th style="width:35%">Mensaje</th>
              <th>Fecha</th>
              <th style="width:35%">Respuesta</th>

            </tr>
          </thead>
          <tbody>
          
         <?php 
         $resultado = consultaSql("select * from reporte1 order by fecha desc");
			
		 while($res=$resultado->fetch_object()){?>        
            <tr>
              <td><?php echo $res->nombre ?><br><?php echo $res->usuid ?></td>
              <td><?php echo $res->reporte ?></td>
              <td ><?php echo $res->fecha ?></td>
              <td id="<?php  echo $res->repid; ?>">
			  <?php
			   if($res->nota == ""){?>
                	<textarea rows="1" style="width:100%"></textarea>
                    <button class="botonStandar" style="float:right" name="responder">
                    <h4>&nbsp;&nbsp;Responder&nbsp;&nbsp;</h4></button> 
                    <label></label>				
					<?php 					
				   }else{
				   	echo $res->nota;
				   }		  
			  ?></td>
            </tr>               
          <?php } ?>
           
          </tbody>
        </table>		
      </div>
   
    </div>
  </div>
</section>

<script>


	$ ("button[name=responder]").click(function () {
		
		var obj  = $(this).parent();
		var id   = obj.attr("id");		
		var text = obj.children().val();
	obj.find("label").html("<img style='width:20px;' src=img/load.gif>");
		if(text != ""){

			$.ajax({
				type: "POST", 								
				url:"controlador/respondeReporte.php", 
				data: {id:id,text:text},  
				success: function(datos){
				if(datos == "1"){
					obj.html(text);
					}else{
				obj.find("label").text(datos);						
						}


				}
			});							
		}

			
	});
    
</script>