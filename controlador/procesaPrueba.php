<?php
session_start();
	//imprime las variables con su contenido	
	//foreach ($_POST as $key => $value){ echo "{$key} = {$value}\r\n<br>";}
	//imprime un arreglo de las variables existentes
	//print_r(array_keys($_GET));

if(isset($_POST['proceso'])){
	
	include ("../modelo/conexion.php");
	$tabla = "prueba";	
	$proceso = $_POST['proceso'];
	
	if($proceso == "agregar"){ // sentencias para AGREGAR un nuevo registro

		$usuId             = nulo($_POST['usuId']);
		$nombre            = nulo($_POST['nombre']);
		$descripcion       = nulo($_POST['descripcion']);
		$tiempo            = nulo(segundosFecha($_POST['tiempo']*60));
		$fecha1            = nulo($_POST['fecha1']." ".$_POST['hora1']);
		$fecha2            = nulo($_POST['fecha2']." ".$_POST['hora2']);
		$mostrarResultados = nulo($_POST['mostrarResultados']);
		$mezclarPreguntas  = nulo($_POST['mezclarPreguntas']);
		$mezclarOpciones   = nulo($_POST['mezclarOpciones']);

		$sql ="INSERT INTO prueba  VALUES (NULL, $nombre, $descripcion,  $now , $usuId, $tiempo, $fecha1, $fecha2, $mostrarResultados, '0', $mezclarPreguntas, $mezclarOpciones);";
		//echo $sql;
		
		$insercion = consultaSql($sql);
		
		if($insercion) {
				echo "insercion ejecutada correctamente";
				
			}else{
				echo "error en la insercion de los datos, verifique el contenido";
			}	
		
	} else if ($proceso == "modificar"){ // sentencias para MODIFICAR 

		$pruId             = nulo($_POST['pruId']);
		$nombre            = nulo($_POST['nombre']);
		$descripcion       = nulo($_POST['descripcion']);
		$tiempo            = nulo(segundosFecha($_POST['tiempo']*60));
		$fecha1            = nulo($_POST['fecha1']." ".$_POST['hora1']);
		$fecha2            = nulo($_POST['fecha2']." ".$_POST['hora2']);
		$mostrarResultados = nulo($_POST['mostrarResultados']);
		$mezclarPreguntas  = nulo($_POST['mezclarPreguntas']);
		$mezclarOpciones   = nulo($_POST['mezclarOpciones']);


		$sql = " UPDATE prueba SET 
				`pruNombre` = $nombre,
				`pruDescripcion` = $descripcion,
				`pruTiempo` = $tiempo,
				`pruFechaInicio` = $fecha1,
				`pruFechaFin` = $fecha2,
				`pruMostrarResultados` = $mostrarResultados,
				`pruMezclarPreguntas` = $mezclarPreguntas ,
				`pruMezclarOpciones` = $mezclarOpciones 
				WHERE `pruId` = $pruId;";
								
		//echo $sql;
		
		$insercion = consultaSql($sql);
				
			if($insercion) {
				echo "modificacion ejecutada correctamente";
			}else{
				echo "error en la modificacion de los datos, verifique el contenido";
			}	

	} else if ($proceso == "eliminar"){ // sentencias para ELIMINAR un registro
	
	//foreach ($_POST as $key => $value){ echo "{$key} = {$value}\r\n<br>";}
	
	
		$pruid = $_POST["id"];

$consulta = consultaSql("select count(*) 'total' from resultado where pruid = $pruid");
$consulta = $consulta->fetch_object();


if($consulta->total >= 1){
	echo "Esta prueba no se puede eliminar por que ya se ha presentado por aprendices";
	}else{
		consultaSql("DELETE from pruebausuario WHERE  pruId=$pruid; ");
		consultaSql("DELETE from pruebapregunta WHERE  pruId=$pruid;");
		$insercion = consultaSql("DELETE FROM prueba WHERE pruId=$pruid; ");
			
			if($insercion) {
				echo "Eliminacion ejecutada correctamente";
			}else{
				echo "Error en la eliminacion de los datos";
			}			
	}
			
	} else if ($proceso == "vinPregunta"){ // sentencias para VINCULAR PREGUNTAS

		//foreach ($_POST as $key => $value){ echo "{$key} = {$value}\r\n<br>";}

		$preid     = $_POST["id"];
		$pruid = $_POST["prueba"];
		
		$sql = "select count(*) 'existe' from pruebapregunta where pruid = $pruid and preid = $preid";
		//echo $sql; 
		$existe = consultaSql($sql);
		$existe = $existe->fetch_object();
		if($preid != 0){
			if($existe->existe){
				echo "<script>alert('Esta pregunta ya esta vinculada');	</script>";
			}else{
				$sql = "INSERT INTO pruebapregunta VALUES (null, $pruid, $preid);";
				//echo $sql; 			
				$insercion = consultaSql($sql);		
				if($insercion) {
					/*echo "<script>alert('vinculado');</script>";*/
												
				}else{
					echo "<script>alert('Error al crear el vinculo');</script>";
				}
			}
		}				
			$sql = "select pregunta.preid, preclase, prearea, precompetencia, 
			prepregunta from pruebapregunta 
			inner join pregunta on pruebapregunta.preId = pregunta.preId
			where pruebapregunta.pruId = $pruid;";
			//echo $sql; 
			$resultado = consultaSql($sql);
			$numero1 = $resultado->num_rows; 
			 ?>  
			 <hr>
			 <h3 >Preguntas vinculadas a la prueba( <span id="conVinPre">
			 <?php echo $numero1 ?></span> )</h3>
                     
        <table align="center" class="table table-bordered ">
              <thead style="background-color:#5FCBF8">
                <tr>
                  <th>ID</th><th>Clase</th><th>Area</th>
                  <th>Competencia</th><th>Contenido de la Pregunta</th><th>Del</th>
                </tr>
              </thead>
              <tbody>
              
             <?php                         
             while($res=$resultado->fetch_object()){?>        
                <tr>
                  <td><?php echo $res->preid ?></td>
                  <td><?php echo $res->preclase ?></td>
                  <td><?php echo $res->prearea ?></td>
                  <td><?php echo $res->precompetencia ?></td>
                  <td><?php echo $res->prepregunta ?></td>
                  <td>
                    <button class="botonStandar2"  name="desvinculaPregunta" 
                    value="<?php echo $res->preid;?>">
                    <span class="glyphicon glyphicon-remove-sign" >
                    </button>
                  </td>
                </tr>               
              <?php } ?>
               
              </tbody>
            </table>
            <script>
			$('button[name=desvinculaPregunta]').click(function () {
				
				var boton = $(this);
				var preid = $(this).val();
				var pruid = "<?php echo $pruid; ?>";

				$.ajax({
					url: "controlador/procesaPrueba.php", 
					type: "POST", 
					data: {proceso:"desPregunta",prueba:pruid,id:preid}, 
					success: function(datos){

						if(datos == 1){
							$("#conVinPre").text($("#conVinPre").text()-1)
							boton.parent().parent().remove();
						}else{
							alert("Error la desvincular");
						}
						//$("#preguntasVinculadas").html(datos);
									
					}
				});	// fin ajax			
			});	
            </script>
        <?php 	
                        

				
	}else if ($proceso == "desPregunta"){ // sentencias para ELIMINAR un registro
	
		$preid     = $_POST["id"];
		$pruid = $_POST["prueba"];
		
		$sql =  "delete from pruebapregunta where pruid = $pruid and preid = $preid"; 
		$insercion = consultaSql($sql);
		echo $insercion;

} else if ($proceso == "vinUsuario"){ // sentencias para VINCULAR PREGUNTAS

		$usuid = $_POST["id"];
		$pruid = $_POST["prueba"];
		//echo $preid;
		
		$sql = "select count(*) 'existe' from pruebausuario where pruid = $pruid and usuid = $usuid";
		
		//echo $sql; 
		$existe = consultaSql($sql);
		$existe = $existe->fetch_object();
		if($usuid != 0){
			if($existe->existe){
				echo "<script>alert('Este aprendiz ya esta vinculado');	</script>";
			}else{
				$sql = "INSERT INTO pruebausuario VALUES ($pruid, $usuid ,NULL,NULL,NULL);";
				//echo $sql; 			
				$insercion = consultaSql($sql);		
				if($insercion) {
					/*echo "<script>alert('vinculado');</script>";*/
												
				}else{
					echo "<script>alert('Error al crear el vinculo $sql'); </script>";
				}
			}
		}	
				
			$sql = "select 
					usuario.usuId,
					concat(`usuNumeroDoc`,' ',`usuTipoDoc`) AS `Documento`,
					concat(usuNombre1,' ',coalesce(usuNombre2,'')) AS `Nombres`,
					concat(usuApellido1,' ',coalesce(usuApellido2,'')) AS Apellidos,
					usuario.ficId 'Ficha'
					from pruebausuario 
					inner join usuario on pruebausuario.usuId = usuario.usuId
					where pruid = $pruid;";
			//echo $sql; 
			$resultado = consultaSql($sql);
			$numero = $resultado->num_rows;
			 ?>  
			 <hr>
			 <h3 >Aprendices vinculados a la prueba ( <span id="conVinUsu">
			 <?php echo $numero ?></span> )</h3>
                     
        <table align="center" class="table table-bordered ">
              <thead style="background-color:#5FCBF8">
                <tr>
                  <th>ID</th><th>Documento</th><th>Nombres</th>
                  <th>Apellidos</th><th>Ficha</th><th>Del</th>
                </tr>
              </thead>
              <tbody>
              
             <?php                         
             while($res=$resultado->fetch_object()){?>        
                <tr>
                  <td><?php echo $res->usuId ?></td>
                  <td><?php echo $res->Documento ?></td>
                  <td><?php echo $res->Nombres ?></td>
                  <td><?php echo $res->Apellidos ?></td>
                  <td><?php echo $res->Ficha ?></td>
                  <td>
                    <button class="botonStandar2"  name="desvinculaPregunta" 
                    value="<?php echo $res->usuId;?>">
                    <span class="glyphicon glyphicon-remove-sign" >
                    </button>
                  </td>
                </tr>               
              <?php } ?>
               
              </tbody>
            </table>
            <script>
			$('button[name=desvinculaPregunta]').click(function () {
				
				var boton = $(this);
				var usuid = $(this).val();
				var pruid = "<?php echo $pruid; ?>";

				$.ajax({
					url: "controlador/procesaPrueba.php", 
					type: "POST", 
					data: {proceso:"desUsuario",usuid:usuid,pruid:pruid}, 
					success: function(datos){

						if(datos == 1){
							$("#conVinUsu").text($("#conVinUsu").text()-1)
							boton.parent().parent().remove();
						}else{
							alert("Error la desvincular");
						}
						//$("#preguntasVinculadas").html(datos);
									
					}
				});	// fin ajax			
			});	
            </script>
        <?php 	
                        

				
	}else if ($proceso == "desUsuario"){ // sentencias para ELIMINAR un registro
	
		$usuid = $_POST["usuid"];
		$pruid = $_POST["pruid"];

		 $sql =  "delete from resultado where pruid = $pruid and usuid = $usuid"; 
		consultaSql($sql);
		
		 $sql =  "delete from pruebausuario where pruid = $pruid and usuid = $usuid"; 
		$insercion = consultaSql($sql);
		
		echo $insercion;

	}else if ($proceso == "vinFicha"){ // sentencias para ELIMINAR un registro
	
		
		$pruid = $_POST["pruid"];
		$ficid = $_POST["ficid"];
		
		$sql =  "delete pr from pruebausuario pr where pruid = $pruid and exists (select null from usuario us where ficid = $ficid and pr.usuId = us.usuid);"; 
		$r1 = consultaSql($sql);
		$r1 = ($r1)?"Eliminarcion correcta":"No se pudo eliminar";
		
		$sql =  "select * from usuario where ficid = $ficid;"; 
		$usu = consultaSql($sql);
		$num = $usu->num_rows;
		
		$superSql = "insert into pruebausuario (pruid, usuid) values";
			
		if ($r1 and $num > 0){			
			 while($us=$usu->fetch_object()){			
				$superSql = $superSql."('".$pruid."','".$us->usuId."'),";			
			}			
		} 

		$superSql = substr($superSql, 0, -1).";";

		$resFinal = consultaSql($superSql);
		$resFinal = ($resFinal)?"Insercion Correcta":"No se pudo insertar";
				
		echo $pruid."-".$ficid." ".$r1." ".$num." Aprendices en la ficha\n";
		echo "Fin: ".$resFinal."\n";
		//echo "SC: ".$superSql."\n";

	}else if ($proceso == "reiniciaPrueba"){ // sentencias para ELIMINAR un registro
			
		$pruid = $_POST["pruid"];
		$usuid = $_POST["usuid"];
		
		$sql = "delete from resultado where usuid = $usuid and pruid = $pruid"; 
		$r1 = consultaSql($sql);
		$r1 = ($r1)?"Respuestas eliminadas":"Respuestas no eliminadas";
		
		$sql = "UPDATE pruebausuario SET pruUsuHoraInicio=NULL, pruUsuHoraFin=NULL 
				WHERE usuid = $usuid and pruid = $pruid"; 
		$r2 = consultaSql($sql);
		$r2 = ($r2)?"Prueba reiniciada":"Prueba no reiniciada";
		
		echo $r1."\n".$r2;
		
	}else if ($proceso == "agregaTiempo"){ // sentencias para ELIMINAR un registro
			
		$pruid = $_POST["pruid"];
		$usuid = $_POST["usuid"];
		$minutos = $_POST["minutos"];
		$tipo = $_POST["tipo"];
		
		$sql = "UPDATE pruebausuario SET pruUsuHoraFin=( $tipo + INTERVAL $minutos MINUTE) WHERE pruId=$pruid AND usuId=$usuid";
		//echo $sql; 
		$r1 = consultaSql($sql);
		$r1 = ($r1)?"Tiempo modificado correctamente":"Error al modificar tiempo";
		echo $r1;
		
	}else{
	echo "ingreso prohibido";			
	}
}

?>