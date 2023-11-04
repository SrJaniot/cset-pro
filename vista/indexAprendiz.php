<?php 
include ("modelo/conexion.php");
if(!isset($_SESSION['usuId']) or $_SESSION['rol']!='aprendiz'){ header('location:index.php'); }
?>

<section id="section2" class="colorfondo" >
  <div class="container">
    <div class="row">
    
    
      <div class="col-xs-12">
        <h1 class="text-center" >PRUEBAS HABILITADAS</h1>
        <br>
        <?php 
		$aprendiz = $_SESSION['usuId'];
		$contPru = consultaSql("select COUNT(*) 'existe' from pruebausuario where usuid = $aprendiz");
		$contPru = $contPru->fetch_object()->existe;
		if($contPru > 0){ 
              
    $pruebas = consultaSql("select aprendiz, pruebasaprendiz.pruid, pruebasaprendiz.prunombre, 
pruebasaprendiz.prudescripcion, prucreador, creador, pruebasaprendiz.prutiempo, 
pruebasaprendiz.prufechainicio, pruebasaprendiz.prufechafin, preguntas, 
pruusuhorainicio, pruusuhorafin, pruusupuntaje, horainicio, horafin, habilitada
from pruebasaprendiz 
left join pruebahabilitada on pruebasaprendiz.pruid = pruebahabilitada.pruid
where aprendiz = $aprendiz order by prufechainicio desc, pruid asc;");

		 while($pru=$pruebas->fetch_object()){?>
            <article class="prueba" > <!-- principal de cada prueba ***-->
              <div class="row top">
                <div class="col-xs-9">
                  <h3><?php echo $pru->prunombre ?></h3>
                  <h4><?php echo $pru->prudescripcion ?> </h4>
                  <h4>creada por: <b><?php echo $pru->creador ?></b>  </h4>
                </div>
                <div class="col-xs-3">
                  <h5>Preguntas</h5>
                  <h1><?php echo $pru->preguntas ?></h1>
                  <h5>tiempo para presentar</h5>
                  <h1><?php echo substr($pru->prutiempo,0,5) ?> h</h1>
                </div>
              </div>
              <div class="bot columna col-xs-9 ">
                <div>
                  <h5>habilitada desde <b><?php echo $pru->prufechainicio ?></b>
                   hasta el <b><?php echo $pru->prufechafin ?></b></h5>
                </div>
              </div>
              <?php if($pru->habilitada != "si"){ 
						$boton = "No habilitada";
					} else{
						$boton = "INICIAR >>";
					} 
				   ?>
              
              <button class="col-xs-3 columna" name="btnIniciar" value="<?php echo $pru->pruid ?>"> 
                          
             <?php echo $boton ?>
              
              </button>
               
            </article> 
	<?php }// fin ciclo    
   
		}else{?> <br>
        <h4 style="text-align:center">No dispone de pruebas habilitadas en este momento, recuerde mantener sus datos personales actualizados</h4>
              <?php  } ?>
        
      </div>
           
    </div>
  </div>
</section>
<script>
$(document).ready(function() {
	
	$("button[name=btnIniciar]").click(function (){
		var pruid = $(this).val();
		
		if(confirm("Desea presentar esta prueba?")){
			window.open("presentando.php?prueba=" + pruid,"_self")
			}
	});
	
} ); // document
</script>