<?php 
session_start();
extract ($_REQUEST);
include ("modelo/conexion.php");
/*esta linea valida que exista una sesion, si no existe me manda al index, ademas valida
que el rol seal el indicado para la pagina si no es asi igualmente me manda a index*/
if(!isset($_SESSION['usuId']) or $_SESSION['rol']!='admin'){ header('location:index.php'); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include 'inc/head.php'; ?>
<title>LOG</title>
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
        <h1 class="text-center" >LOG</h1>
        <table align="center" class="table table-bordered ">
          <thead>
            <tr>
              <th>Documento</th>
              <th>Usuario</th>
              <th>Rol</th>
              <th>Accion</th>
              <th>Fecha</th>
            </tr>
          </thead>
          <tbody>
          
         <?php 
         $resultado = consultaSql("select * from log1");
			
		 while($res=$resultado->fetch_object()){?>        
            <tr>
              <td><?php echo $res->Documento ?></td>
              <td><?php echo $res->Usuario ?></td>
              <td><?php echo $res->Rol ?></td>
              <td><strong><?php echo $res->Accion ?></strong></td>
              <td><?php echo $res->Fecha ?></td>

            </tr>               
          <?php } ?>
           
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<?php  include 'inc/footer.php'; //pie de pagina de la pagina?>
<script>

</script>
</body>
</html>