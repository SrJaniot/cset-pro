<?php
session_start();
// ESTA PAGINA ES PARA PROCESAR LOS AJAX DE VENTANAS MODALES
//imprime las variables con su contenido	
//foreach ($_POST as $key => $value){ echo "{$key} = {$value}\r\n<br>";}
//print_r($_FILES)."<br>"; print_r($_POST)."<br>";
//sleep(1);

if(isset($_POST['proceso'])){
	
	include ("../modelo/conexion.php");
	$proceso = $_POST['proceso'];


	if($proceso == "aprendiz"){ // sentencias para AGREGAR un nuevo registro
	
		$usuId = $_POST['id'];
		$resultado = consultaSql("select * from usuario where usuNumeroDoc=$usuId");
		$res = $resultado->fetch_object();
		
		$resultado = consultaSql("select * from institucion2 where usuid=$res->usuId");
		$colegio = $resultado->fetch_object();
		
		 ?>

 
         <div class="row">
      <div class="col-xs-12">

        <div class="col-xs-6 col-xs-push-3 col-sm-5 col-sm-push-0"> <img  style="width:100%" class="img-thumbnail" src="img/fperfil/<?php echo $res->usuFoto; ?>" alt="foto"> </div>
        <div class="col-xs-12 col-sm-7">
          <h4><?php echo 
			$res->usuNombre1." ".$res->usuNombre2." ".
			$res->usuApellido1." ".$res->usuApellido2; ?> </h4>
          <h4><?php echo $res->usuTipoDoc." ".$res->usuNumeroDoc?> (Id:<?php echo $res->usuId ?>)</h4>
          <?php if($res->ficId != ""){
			$resultado = consultaSql("select * from ficha where ficid = $res->ficId;");
			$ficha = $resultado->fetch_object();?>
          <h4>Ficha: <b><?php echo $ficha->ficId ." - ".$ficha->ficNombre." (".$ficha->ficJornada.")"; ?></b></h4>
          <?php }?>
          <div style="border-bottom: solid 1px #EEEEEE; "></div>
          <h5>Telefono: <b><?php echo $res->usuTelefono; ?></b></h5>
          <h5>Celular: <b><?php echo $res->usuCelular; ?></b></h5>
          <h5>Correo: <b><?php echo $res->usuCorreo; ?></b></h5>
          <h5>Nacimiento: <b><?php echo $res->usuFechaNacimiento; ?></b></h5>
          <h5>Genero: <b><?php echo $res->usuSexo; ?></b></h5>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12">
          <?php 
		 if($colegio){ ?>
           <div style="border-bottom: solid 1px #EEEEEE; "></div>
          <h5>Institucion: <b><?php echo $colegio->insnombre; ?></b></h5>
          <h5>Sede: <b><?php echo $colegio->sednombre; ?></b></h5>
          <h5>Titulo Obtenido: <b><?php echo $colegio->insusutipo; ?> - <?php echo $colegio->insusutitulo; ?></b></h5>
          <h5>Curso hasta: <b><?php 
		  if($colegio->graduado == "si"){$grado = "Graduado";}else {$grado = "";}
		  echo $colegio->insusucursado." (".$grado." ".$colegio->insusufin.")"; ?></b></h5>
          <?php }else { ?> 
          
           <?php } ?>
        </div>
        <div class="col-xs-12">
        <br>
        <?php 			
		$pruebasAsignadas = consultaSql("select *from consultor2 where usuId = $res->usuId order by pruid desc;");
		 ?>
<table class="table table-striped table-bordered">
        <thead>
           <tr>
             <th scope="col">Pruebas del Aprendiz</th>
             <th scope="col">Estado</th>
             <th scope="col">Correctas</th>
           </tr>
        </thead>

        <tbody>
        <?php  

		
		while ($pru = $pruebasAsignadas->fetch_object()){ 
		
		$ep = "normal"; //estado de la prueba
		$fi =$pru->fechaInicio;
		$ff =$pru->fechaFin;
		$hi =$pru->horaInicio;
		$hf =$pru->horaFin;
		$tt =$pru->tiempo;
		$ta =time();
		
		
		if ($fi > $ta){
			//asignada pero no ha llegado a la fecha de inicio
			$ep = "asignada";
			$ept = "Esta prueba podra ser presentada pronto.";			
		}else{			
			if ($ff > $ta){ 
				if($hf == 0){
					$ep = "activa";
					$ept = "Esta prueba esta lista para presentar en este momento.";	
					}		
				else if($hf > $ta){
						$ep = "presentando...";
						$ept = "Esta prueba esta siendo presentada en este momento.";
					}else{
						$ep = "presentada";
						$ept = "Esta prueba fue presentada.";
					};					
			}
			else{			
				if($hi != 0) {
					$ep = "presentada";
					$ept = "Esta prueba fue presentada en las fechas estipuladas.";
				}else{ 
					$ep = "no presento";
					$ept = "Esta prueba no se presento y esta inactiva.";
				}				
			}
		}
				
		?>  
           <tr>
             <td><a class="divpo" href="monitorPrueba.php?id=<?php echo $pru->pruid ?>">
			 <?php echo $pru->prunombre ?></a></td>
             <td>
            <?php 
		$tiempos ="";	
	  if ($hi != "0"){
	  $tiempos = "<div style='border-bottom: solid 1px #EEEEEE; margin: 0.3em;'></div>
	  <b class='text-center'>Tiempro de presentacion</b><br>Inicio: ".td($hi)."<br>Termino: ".td($hf);
	  }			
			 ?> 
      <div class="divpo" type="button" rel="popover" data-placement="top"  data-toggle="popover" title="<b style='text-transform: uppercase;'><?php echo $ep ?></b>" data-content="<?php echo $ept. "<div style='border-bottom: solid 1px #EEEEEE; margin: 0.3em;  '></div>Activa desde ".td($fi)." <br>hasta ".td($ff)."<br>Tiempo para presentar: ".($tt/60)." min. <br>".$tiempos ?>"><?php echo $ep ?></div>
             </td>
             <td class="text-center" style="font-size:1.2em"><b>
             <?php echo resPorcen($pru->correctas, $pru->cantidadPreguntas) ?></b></td>
           </tr>
         <?php } ?>  
        </tbody>
 </table>

        </div>
        <br>
        <hr>
      </div>
    </div>
    
   
    
    
      <?php 		  
	} else if ($proceso == "instructor"){ // sentencias para 
	
	$usuId = $_POST['id'];
	$resultado = consultaSql("select * from usuario where usuNumeroDoc=$usuId");
	$res = $resultado->fetch_object();	
	 ?>
         <div class="row">
      <div class="col-xs-12">

        <div class="col-xs-6 col-xs-push-3 col-sm-5 col-sm-push-0"> <img  style="width:100%" class="img-thumbnail" src="img/fperfil/<?php echo $res->usuFoto; ?>" alt="foto"> </div>
        <div class="col-xs-12 col-sm-7">
          <h4><?php echo 
			$res->usuNombre1." ".$res->usuNombre2." ".
			$res->usuApellido1." ".$res->usuApellido2; ?> </h4>
          <h4><?php echo $res->usuTipoDoc." ".$res->usuNumeroDoc?></h4>
          <?php if($res->ficId != ""){
			$resultado = consultaSql("select * from ficha where ficid = $res->ficId;");
			$ficha = $resultado->fetch_object();?>
          <h4>Ficha: <b><?php echo $ficha->ficId ." - ".$ficha->ficNombre." (".$ficha->ficJornada.")"; ?></b></h4>
          <?php }?>
          <div style="border-bottom: solid 1px #EEEEEE; "></div>
          <h5>Telefono: <b><?php echo $res->usuTelefono; ?></b></h5>
          <h5>Celular: <b><?php echo $res->usuCelular; ?></b></h5>
          <h5>Correo: <b><?php echo $res->usuCorreo; ?></b></h5>
          <h5>Nacimiento: <b><?php echo $res->usuFechaNacimiento; ?></b></h5>
          <h5>Genero: <b><?php echo $res->usuSexo; ?></b></h5>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12">
        <br>
        <?php 			
		$pruebas = consultaSql("select * from prueba3 where prucreador = $res->usuId;");
		 ?>
<table class="table table-striped table-bordered">
        <thead>
           <tr>
             <th >Id</th>
             <th >Nombre</th>
             <th >Tiempo</th>
             <th >Preguntas</th>
             <th >Aprendices</th>
           </tr>
        </thead>

        <tbody>
        <?php  		
		while ($pru = $pruebas->fetch_object()){ ?>  
       
          <tr>
             <td><?php echo $pru->pruid ?></td>
             <td><a class="divpo" href="monitorPrueba.php?id=<?php echo $pru->pruid ?>"
             type="button" rel="popover" data-placement="right"  data-toggle="popover"
             title="<b><?php echo $pru->nombre ?></b>" 
             data-content="<?php echo $pru->prudescripcion ?>
             <div style='border-bottom: solid 1px #EEEEEE; margin: 0.3em;  '></div> 
            <?php echo "Creada: ".$pru->creado."<br>" ?> 
            <?php echo "Inicio: ".$pru->inicio."<br>" ?> 
            <?php echo "Fin: ".$pru->fin."<br>" ?> 
             <div style='border-bottom: solid 1px #EEEEEE; margin: 0.3em;  '></div>
             <?php echo "Mezclar Preguntas: ".$pru->mezclarPreguntas."<br>" ?>
             <?php echo "Mezclar Opciones: ".$pru->mezclarOpciones."<br>" ?>
             <?php echo "Mostrar Resultados: ".$pru->mostrarResultados."<br>" ?>
             <div style='border-bottom: solid 1px #EEEEEE; margin: 0.3em;  '></div>" 
             >
			 <?php echo $pru->nombre ?></a></td>
             <td class="text-center"><?php echo $pru->tiempo ?></td>
             <td class="text-center"><?php echo $pru->preguntas ?></td>
             <td class="text-center"><?php echo $pru->aprendices ?></td>
           </tr>
         <?php } ?> 
         
        </tbody>
 </table>

        </div><div style='border-bottom: solid 1px #EEEEEE; margin: 0.3em;  '>
        <br>
        <hr>
      </div>
    </div>
	<?php  
	} else if ($proceso == "pregunta"){ // sentencias para ELIMINAR un registro
		
		$preid = $_POST['preid'];
		$pruid = $_POST['pruid'];
		$usuid = $_POST['usuid'];
				
		$res = consultaSql("select * from pregunta inner join usuario on pregunta.preCreador = usuario.usuId where preid = $preid");
		$oRes = $res->fetch_object();
		
		$res2 = consultaSql("select re.pruid, re.preId, sum(IFNULL(op.opcCorrecto,'0')) 'correctas' , sum(if(IFNULL(op.opcCorrecto,'1') = '0','1','0')) 'erradas' , sum(if(IFNULL(op.opcCorrecto,'2') = '2','1','0')) 'sinContestar', count(re.pruId) 'total' from resultado re left join opcion op on re.opcId = op.opcId where re.pruid = $pruid and re.preid = $preid;");
		$oRes2 = $res2->fetch_object();		
		
		$opcid = (isset($_POST['opcid']))?$_POST['opcid']:"0";
		
		if ($opcid != 0){
			$res3 = consultaSql("select resFecha from resultado where usuid = $usuid and pruid = $pruid and preid = $preid limit 1");
			$res3 = $res3->fetch_object();				
			$horaOpcion = $res3->resFecha;				
		}
			
		?>  
        
         
        <div>
        <?php if($oRes->conId != ""){ ?> 
        <a href="vercontexto.php?contexto=<?php echo $oRes->conId ?>" target="_blank">
        <button class="botonStandar" style="position: absolute; left:0px; margin-left:30px;">
        <h4> &nbsp;&nbsp;Contexto <?php echo $oRes->conId ?>&nbsp;&nbsp; </h4>
        </button>
        </a>        
         <?php } ?> 
         

         <?php 		if ($opcid != 0){ ?> 
         <div style="position: absolute; right:0px; margin-right:30px; color:#5F5F5F; font-size:1.2em">         
        	Contestada el: <br>
        	<?php echo $horaOpcion ?>
        </div>           
          <?php } ?>
      
         
        <center>
 <table border="1" bordercolor="#C7C7C7" data-toggle="tooltip" title="Cantidad de respuestas correctas, erradas y sin conestar de los aprendices en esta pregunta basada en el total de aprendices q ya han iniciado la prueba">
      
        <thead>
           <tr>
             <th style="padding:1px 5px" colspan="3" >Respuestas</th>
             <th style="padding:1px 5px" colspan="3">Total</th>

           </tr>
        </thead>

        <tbody>        
           <tr>
             <td style="padding:5px 5px 0px 5px;"><span <?php echo resOk(1) ?>></span>
			 <b style="font-size:1.4em"><?php echo $oRes2->correctas ?></b> </td>
             <td style="padding:5px 5px 0px 5px;"><span <?php echo resOk(0) ?>></span>
			 <b style="font-size:1.4em"><?php echo $oRes2->erradas ?></b></td>
             <td style="padding:5px 5px 0px 5px;"><span <?php echo resOk(2) ?>></span>
			 <b style="font-size:1.4em"><?php echo $oRes2->sinContestar ?></b></td>
             <td style="padding:5px 5px 0px 5px;">
             <center><b style="font-size:1.4em"><?php echo $oRes2->total ?></b></center></td>
			</tr>
        </tbody>
 </table>
       </center> </div>      
              
        <div class="col-xs-12">
          <h4> <?php echo str_replace("\n", "<br>", $oRes->prePregunta);  ?> </h4>
        </div>
        <?php if($oRes->preImagen != ""){ ?>  
        <div class="col-xs-12"> 
        <img class="img-responsive center-block" src="img/pregunta/<?php echo $oRes->preImagen; ?>" alt=""> 
        </div>
        <?php } ?>
            
        <div class="col-xs-12">
          <h4> <?php echo str_replace("\n", "<br>", $oRes->prePosPregunta); ?> </h4>

        </div> 
        
        <div class="col-xs-12 col-sm-10 col-sm-push-1" id="consultaOpcion">
 		<?php $resultado = consultaSql(" select * from opcion where preid = $preid;");

			while($res=$resultado->fetch_object()){?>
			  <h5 <?php if ($opcid == $res->opcId) echo "class = 'opcSelect'" ?> >
			  <?php if($res->opcCorrecto){
						echo '<span class="glyphicon glyphicon-ok" style="color:#08A82C"></span> ';
					}else{
						echo '<span class="glyphicon glyphicon-remove" style="color:#E0331F" ></span> ';		
					}
						echo " - ".$res->opcOpcion;
					?>
			  </h5>
			  <?php } ?>
              <br>
			</div>
      
        <div class="col-xs-12">
          <div style="border-bottom: solid 2px #EEEEEE; "></div>          
        <h5 class="text-center" >Pregunta No: <b>
		<?php echo $oRes->preId; ?></b> &nbsp;Insertada por: <b>
		<?php echo $oRes->usuNombre1." ".$oRes->usuNombre2." ".$oRes->usuApellido1; ?></b></h5>
        
		<h5  class="text-center">
		<?php echo $oRes->preClase." / ".$oRes->preArea." / ".$oRes->preCompetencia; ?></h5> 
         
		 <?php if($oRes->preAfirmacion != "") { ?> 
        <h5 class="text-center" ><b>Afirmacion:</b> <?php echo $oRes->preAfirmacion; ?> </h5>
        <?php } ?>
		<?php if($oRes->preFuente != "") { ?>        
        <h6 class="text-center" ><b>Fuente:</b> <i><?php echo $oRes->preFuente ?></i></h6>
        <?php } ?>

        </div> 
         <div class="clearfix"></div>
 
 <script>
 
 	$(function () {
	  $('[data-toggle="tooltip"]').tooltip( {html:"true"})
	})
	
 </script>
 
 
  <?php 
  ///////////////////////////////////////////////////////////////////////////////////////////////
  		
	}else if ($proceso == "informe"){  
	
	$pruid = $_POST['pruid'];
	?> 
    
        <i>Desde aqui puede generar informes de las pruebas, para obtener veracidad en los datos procure que los aprendices ya hayan termindado de presentar las pruebas, tenga presente que los informes pueden tardar en generarse.</i>
        <br>

		<a href="informe1.php?pruid=<?php echo $pruid ?>" target="_blank"><div  class="btnInforme">
		<span class="glyphicon glyphicon-stats" style="font-size:3em;float:left; padding:0.2em"></span>
            <h4>Informe General de Prueba</h4>
            Grafica de barras por areas comparando respuestas acertadas, erradas y no conestadas.
        </div></a>
		<a href="informe2.php?pruid=<?php echo $pruid ?>" target="_blank"><div  class="btnInforme">
		<span class="glyphicon glyphicon-list-alt" style="font-size:3em;float:left; padding:0.2em"></span>
            <h4>Informe Detallado de Aprendices</h4>
            Tabla con puntajes de los aprendices por area.
        </div></a>        
		<a href="informe3.php?pruid=<?php echo $pruid ?>" target="_blank"><div  class="btnInforme">
		<span class="glyphicon glyphicon-stats" style="font-size:3em;float:left; padding:0.2em"></span>
            <h4>Informe Desglosado Prueba</h4>
            Grafica de barras por competencias comparando respuestas acertadas, erradas y no conestadas.
        </div></a>
		<a href="informe4.php?pruid=<?php echo $pruid ?>" target="_blank"><div  class="btnInforme">
		<span class="glyphicon glyphicon-stats" style="font-size:3em;float:left; padding:0.2em"></span>
            <h4>Informe por Fichas</h4>
            Grafica comparando el desempeño por areas de cada una de las fichas.
        </div></a>
		<a href="informe5.php?pruid=<?php echo $pruid ?>" target="_blank"><div  class="btnInforme">
		<span class="glyphicon glyphicon-list-alt" style="font-size:3em;float:left; padding:0.2em"></span>
            <h4>Informe General por Preguntas</h4>
            Tabla de preguntas mostrando la cantidad de acetadas, erradas y no contestadas totales.
        </div></a>
        <!-- 
		<a href="informe6.php?pruid=<?php echo $pruid ?>" target="_blank"><div  class="btnInforme">
		<span class="glyphicon glyphicon-star" style="font-size:3em;float:left; padding:0.2em"></span>
            <h4>Cuadro de honor</h4>
            Aprendices con los puntajes mas altos de la prueba general y por areas.
        </div></a>	 -->		
        
		<a href="informe6.php?pruid=<?php echo $pruid ?>" target="_blank"><div  class="btnInforme">
		<span class="glyphicon glyphicon-education" style="font-size:3em;float:left; padding:0.2em"></span>
            <h4>Informe por Colegios</h4>
            Colegio de origen de aprencies que presentaron la prueba.
        </div></a>	  
        
        <a href="informe7.php?pruid=<?php echo $pruid ?>" target="_blank"><div  class="btnInforme">
		<span class="glyphicon glyphicon-floppy-save" style="font-size:3em;float:left; padding:0.2em"></span>
            <h4>Generar informes Indiviudales</h4>
            Ver y generar informes en archivos PDF's de cada aprendiz que presento la prueba.
        </div></a> 
             
     <?php 
/*-----------------------------------------------------------------------------------------*/	 
	 
	}else if ($proceso == "tiempoAprendiz"){
				
	$usuid = $_POST['usuid'];
	$pruid = $_POST['pruid'];
	
	$datos = consultaSql("select * from pruebausuario where pruid = $pruid and usuid = $usuid");
	$datos = $datos->fetch_object();
?> 
<span style="color:#3B46BB">Inici&oacute; = <?php echo $datos->pruUsuHoraInicio ?> - <b>Hora fin</b> = <?php echo $datos->pruUsuHoraFin ?></span>
<hr>
<h3>Resetear tiempo de este usuario</h3>
se perderan las respuestas guardadas y el tiempo empezara de nuevo
<button id="btnReset">Resetear</button>
<hr>
<h3>Dar mas tiempo</h3>
 
<input type="radio" name="tipoTiempo" value="1" id="radio1" checked>
<label for="radio1">Se adicionaran X minutos a partir este momento</label>
<br>
<input type="radio" name="tipoTiempo" value="2" id="radio2"> 
<label for="radio2">Se adicionaran X minutos a partir de la "Hora fin" actual</label>
<br>
Inserte minutos
<input id="numMinutos" type="number" size="100" style="width:50px;" value="1" min="0"> &nbsp;
<button id="btnAgregaTiempo">Adicionar</button>
<hr>
<script>
	 
	$(document).ready(function (){
		  
	   $("#numMinutos").keydown(function(event) {
	  		if(event.shiftKey){ event.preventDefault(); }
	  		if (event.keyCode == 46 || event.keyCode == 8)    { } else { if (event.keyCode < 95) {
	        if (event.keyCode < 48 || event.keyCode > 57) {event.preventDefault();}
	        } else {  if (event.keyCode < 96 || event.keyCode > 105) { event.preventDefault();} }}
	   });

		$("#btnReset").click(function(event) {
		if(confirm("¿Esta seguro que desea resetear la prueba de este usuario? ")){
			
				var usuid = "<?php  echo $usuid ?>"; var pruid = "<?php  echo $pruid ?>";
				
				$("#loadingText").text("Reiniciando Prueba");
				$("#loadingAjax").fadeIn(300);
				$.ajax({
					url: "controlador/procesaPrueba.php", 
					type: "POST", 
					data: {proceso:"reiniciaPrueba",usuid:usuid,pruid:pruid}, 
					success: function(datos){
						$("#loadingAjax").fadeOut(300);
						alert(datos);							
					}
				});	// fin ajax										
			}	// fin if confirm	
		});
	   
		$("#btnAgregaTiempo").click(function(event) {
						
				var usuid = "<?php  echo $usuid ?>";var pruid = "<?php  echo $pruid ?>";
				var minutos = $("#numMinutos").val();
				var tipo = $('input[name=tipoTiempo]:checked').val();
				
				if(tipo == 1){
					tipo = "NOW()";
				} else{
					tipo = "'<?php echo $datos->pruUsuHoraFin ?>'";
				}
				
				//alert(tipo);
				$("#loadingText").text("Añadiendo Tiempo");
				$("#loadingAjax").fadeIn(300);
				$.ajax({
					url: "controlador/procesaPrueba.php", 
					type: "POST", 
					data: {proceso:"agregaTiempo",usuid:usuid,pruid:pruid,minutos:minutos,tipo:tipo}, 
					success: function(datos){
						$("#loadingAjax").fadeOut(300);
						alert(datos);							
					}
				});	// fin ajax										
		});
	   
  });
       </script>
           
      <?php 	
	}else if ($proceso == "ficha"){ 
	
	$ficid = $_POST['id'];		
	$aprendices = consultaSql("select * from usuario where ficid = $ficid");
	//$aprendices = $aprendices->fetch_object();
	?>
 <div class="table-responsive">
<table class="table table-striped table-bordered">

        <thead>
           <tr>
             <th >Documento</th>
             <th >Nombres</th>
             <th >Apellidos</th>
             <th >Telefono</th>
             <th >Celular</th>
             <th >Correo</th>
             <th >Nacimiento</th>
           </tr>
        </thead>

        <tbody>
        <?php  		
		while ($ap = $aprendices->fetch_object()){ ?>  
       
          <tr>
              <td><?php echo $ap->usuNumeroDoc ?></td>       
             <td><?php echo $ap->usuNombre1." ".$ap->usuNombre2 ?></td>
             <td><?php echo $ap->usuApellido1." ".$ap->usuApellido2 ?></td>
             <td><?php echo $ap->usuTelefono ?></td>
             <td><?php echo $ap->usuCelular ?></td>
             <td><?php echo $ap->usuCorreo ?></td>
             <td><?php echo $ap->usuFechaNacimiento ?></td>
           </tr>
         <?php } ?> 
         
        </tbody>
 </table>	
 </div>  	
	<?php 
	
	}else if ($proceso == "otro"){ 
	
	}else { 
	 echo "todo bien hasta aqui, entro al else";
	}
	 

}else{
	echo "ingreso prohibido";
	header('Location:'.$pagHeader);	
	
}

?>
   <script>
   $('[rel="popover"]').popover({
	   trigger: "hover",
	   html:true,
	   delay:200,
	   });
   </script> 