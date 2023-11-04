<?php 
session_start();
extract ($_REQUEST);
include ("modelo/conexion.php");
/*esta linea valida que exista una sesion, si no existe me manda al index, ademas valida
que el rol seal el indicado para la pagina si no es asi igualmente me manda a index*/
if(!isset($_SESSION['usuId'])){ header('location:index.php'); }
if(!isset($_GET['contexto'])){ header('location:index.php'); }

$conid = $_GET["contexto"];
$contexto = consultaSql(" select * from contexto where conid = $conid;");
$contexto = $contexto->fetch_object();
?>  

<!DOCTYPE html>
<html lang="es">
<head>
<?php include 'inc/head.php'; ?>
<title>Contexto No. <?php echo $contexto->conId; ?></title>
</head>

<body>
<section id="section2" class="colorfondo" >
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        
	 <h1 class="text-center" >Contexto No. <?php echo $contexto->conId; ?></h1>
     <h4><?php echo str_replace("\n", "<br>", $contexto->conTexto) ?></h4>
     
	 <?php      if ($contexto->conImagen != ""){ ?> 
    <div><img  class="img-responsive center-block" src="img/contexto/<?php echo $contexto->conImagen ?>" alt="imagen"></div>
	 <?php  }	?> 
      <h4><?php echo str_replace("\n", "<br>", $contexto->conTexto2); ?></h4>
      
       <?php      if ($contexto->conFuente != ""){?> 
     
      <h5 style="color:rgba(104,104,104,1.00)"><i><b>Fuente: </b><?php echo $contexto->conFuente; ?></i></h5>
       <?php }	?> 
               
      </div>
    </div>
  </div>
</section>
<?php  include 'inc/footer.php'; //pie de pagina de la pagina?>
<script>

</script>
</body>
</html>

