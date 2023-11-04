<?php
session_start();
	//imprime las variables con su contenido	
	//foreach ($_POST as $key => $value){ echo "{$key} = {$value}\r\n<br>";}
	//imprime un arreglo de las variables existentes
	//print_r(array_keys($_GET));
include ("../modelo/conexion.php");

if(isset($_POST['conid'])){
	
$conid = $_POST["conid"];
$contexto = consultaSql(" select * from contexto where conid = $conid;");
$contexto = $contexto->fetch_object();

 ?> 
     <div class="row">
      <div class="col-xs-12">
        
     <h4><?php echo str_replace("\n", "<br>", $contexto->conTexto); ?></h4>  
        
	 <?php      if ($contexto->conImagen != ""){?> 
    <div><img  class="img-responsive center-block" src="img/contexto/<?php echo $contexto->conImagen ?>" alt="imagen"></div>
	 <?php }	?> 
     
      <h4><?php echo str_replace("\n", "<br>", $contexto->conTexto2); ?></h4>
     
       <?php      if ($contexto->conFuente != ""){?> 
       <hr> 
      <h5 style="color:rgba(104,104,104,1.00)"><i><b>Fuente: </b><?php echo $contexto->conFuente; ?></i></h5>
       <?php }	?> 
      <br>       
      </div>
    </div>
    
  <?php 		
}else{
	echo "ingreso prohibido";
	header('Location:'.$pagHeader);			
}

?>
