<?php
session_start();
//imprime las variables con su contenido	
//foreach ($_POST as $key => $value){ echo "{$key} = {$value}\r\n<br>";}
//print_r($_FILES)."<br>"; print_r($_POST)."<br>";

if(isset($_POST['proceso'])){
	
	include ("../modelo/conexion.php");
	$tabla = "pregunta";	
	$proceso = $_POST['proceso'];
	$imagenOk = false;
	$nombre  = "";
	$carpeta = "";
	$rutaTmp = "";

	if($proceso == "agregar"){ // sentencias para AGREGAR un nuevo registro
	
		if(isset($_FILES ["imagen"]) && $_FILES["imagen"]["name"] != ''){
			
			//toma el archivo y lo pasa a una variable
			$foto    = $_FILES["imagen"];
			//extrae las propiedades del archivo
			$nombre  = $foto["name"];
			$tipo    = $foto["type"];
			$rutaTmp = $foto["tmp_name"] ;
			$size    = $foto["size"];
			// otras propiedades del archivo calculadas
			$dimensiones = getimagesize($rutaTmp); 
			$width = $dimensiones[0];
			$height = $dimensiones[1];
			$carpeta = "img/pregunta/";

			
			if ($tipo != "image/jpeg" && $tipo != "image/png"){
				echo "Error, el archivo no es una imagen"; 
			}
			else if ($size > 1024*1024*15){
				echo "Error, el tamaño máximo permitido es un 4 Megabytes"; 
			}
			else if ($width > 20000 || $width < 60 || $height > 20000 || $height < 60){
				echo "Error la anchura y la altura de la images debe de ser menores de 2000px";
			}
			else{
				
				$imagenOk = true;
			}
		}else {
		//	echo " Sin imagen\n";
			$imagenOk = true;
		}

		if ($imagenOk) {			
 
			$usuId       = nulo($_POST['usuId']);		
			$clase       = nulo($_POST['clase']);
			$area        = nulo($_POST['area']);
			$competencia = nulo($_POST['competencia']);
			$pregunta1   = nulo($_POST['pregunta1']);
			$nivel       = nulo($_POST['nivel']); 
			$contexto    = nulo($_POST['contexto']);
			$pregunta2   = nulo($_POST['pregunta2']); 
			$afirmacion  = nulo($_POST['afirmacion']); 
			$fuente  = nulo($_POST['fuente']); 


			$sql ="INSERT INTO `pregunta` VALUES (NULL, $clase, $area, $competencia, $afirmacion, $contexto, $pregunta1, NULL, $pregunta2, $nivel, $fuente, $usuId,  $now , '1');
";
			//echo $sql;

			$insercion = consultaSql($sql);

			if($insercion) {
				echo "insercion ejecutada correctamente";

				if (isset($_FILES ["imagen"]) && $_FILES["imagen"]["name"] != '') {//AGREGAR LA IMAGEN	

					$ultimo = consultaSql("select MAX(preid) ultimo from pregunta;");
					$ultimo = $ultimo->fetch_object()->ultimo;	

					$trozos = explode(".", $nombre); 
					$extension = strtolower( end($trozos));  
					$nombre = $ultimo.".".$extension;

					$src = $carpeta.$nombre;
					move_uploaded_file ($rutaTmp, "../".$src); 

					//actualizar el dato de la imagen en el campo usuario
					//echo "UPDATE `contexto` SET `conImagen`='$nombre' WHERE  `conId`=$ultimo;";
					$insercion2 = consultaSql("UPDATE `pregunta` SET `preImagen`='$nombre' WHERE  `preId`=$ultimo;");

					if($insercion2) {
						//echo "imagen insertada correctamente";
					}else{
						echo "error al insertar la imagen";
					}
				} 

			}else{
				echo "error en la insercion de los datos, verifique el contenido";
			}
		} 

	} else if ($proceso == "consultar"){ // sentencias para MODIFICAR un  registro

		$id  = $_POST['id'];
		$sql ="select preid,pregunta.conId, preclase, prefuente, prearea, precompetencia, prepregunta, preimagen, prepospregunta,preafirmacion,prenivel,
if( pregunta.conId != '',pregunta.conId,'no') 'contexto',usuario.usuId 'usuid', concat( usunombre1,' ', usuapellido1) 'Creador' from pregunta
inner join usuario on pregunta.preCreador = usuario.usuId
where preid = $id;";
		//echo $sql;

		$resultado = consultaSql($sql);
		$oRes = htmlDecode($resultado->fetch_object());
 ?> <!-- ver contexto fuera del if  para que lo vean todos los instructores y no solo el creador -->
<a href="vercontexto.php?contexto=<?php echo $oRes->conId; ?>" target="_blank">
<button id="editaPregunta" type="button" class="botonStandar" style="position: absolute; left:0px; margin:0em 1em;">
<h4> &nbsp;&nbsp;Ver Contexto&nbsp;&nbsp; </h4>
</button>
</a>
<?php if($oRes->usuid == $_SESSION['usuId']){ ?> 
<a href="editarPregunta.php?preid=<?php echo $oRes->preid; ?>">
<button id="editaPregunta" type="button" class="botonStandar" style="position: absolute; right:0px; margin:0em 1em;">
<h4> &nbsp;&nbsp;Editar Pregunta&nbsp;&nbsp; </h4>
</button>
</a>
<button id="eliminaPregunta" type="button" class="botonStandar2" style="position: absolute; right:0px; margin:0em 1em; top:72px">
<h4> &nbsp;&nbsp;Eliminar Pregunta&nbsp;&nbsp; </h4>
</button>

 <?php } ?>
<h2 class="text-center" >Pregunta No: <?php echo $oRes->preid; ?></h2>
<h4 class="text-center" >Insertada por: <?php echo $oRes->Creador; ?></h4>
<?php if($oRes->prefuente != "") { ?>
<h6 class="text-center" >Fuente: <i><?php echo $oRes->prefuente ?></i></h6>
<?php } ?>
<hr>
<div class="col-xs-12  col-sm-10 col-sm-push-1">
  <h3> <?php echo str_replace("\n", "<br>", $oRes->prepregunta);  ?> </h3>
</div>
<?php if($oRes->preimagen != ""){ ?>  
<div class="col-xs-12  col-sm-10 col-sm-push-1"> 
<img class="img-responsive center-block" src="img/pregunta/<?php echo $oRes->preimagen; ?>" alt=""> 
</div>
<?php } ?>


<div class="col-xs-12  col-sm-10 col-sm-push-1">
  <h3> <?php echo str_replace("\n", "<br>", $oRes->prepospregunta); ?> </h3>
  <hr>
</div>
<div class="col-xs-12 col-sm-10 col-sm-push-1" id="consultaOpcion">
  <?php $resultado = consultaSql(" select * from opcion where preid = $id;");
		  
while($res=$resultado->fetch_object()){?>
  <h4>
  <?php if($oRes->usuid == $_SESSION['usuId']){ ?>
    <button class="botonStandar2"  name="eliminaOpcion" 
    value="<?php echo $res->opcId;?>"> <span class="glyphicon glyphicon-remove-sign" ></span> </button>
  <?php } ?>  
                  
    <?php if($res->opcCorrecto){
                echo '<span class="glyphicon glyphicon-ok"></span> ';
                }else{
                echo '<span class="glyphicon glyphicon-remove" ></span> ';		
                    }
					echo " - ";
					echo $res->opcOpcion ;
					?>
  </h4>
  <?php } ?>
</div>
<?php if($oRes->usuid == $_SESSION['usuId']){ ?>
<div class="col-xs-12  col-sm-12">
  <hr>
  <h3>
  <form action="controlador/procesaOpcion.php" method="post" id="formOpcion" enctype="multipart/form-data">
    <input type="hidden" name="proceso" value="agregar">
    <input type="hidden" name="preid" value=<?php echo $id ?>>
    <div class="col-xs-12 col-sm-2">
      <label >
      <h4>Estado</h4>
      </label>
      <select class="form-control" name="estado">
        <option value="1">Correcta</option>
        <option value="0">Incorrecta</option>
      </select>
    </div>
    <div class="col-xs-8">
      <label>
      <h4>Opcion</h4>
      </label>
      <div class="form-group has-feedback mb">
        <textarea rows="1" class="form-control input-lg has-error" placeholder="Digite aqui la opcion" name="opcion"></textarea>
        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        <label class="control-label mb">
        <h4 class="mb"></h4>
        </label>
      </div>
      <h4></h4>
    </div>
    <div class="col-xs-12 col-sm-2"> <br>
      <br>
      <button type="button" class="botonStandar" id="enviarOpcion" style="float:left">
      <h4> &nbsp;&nbsp;enviar&nbsp;&nbsp; </h4>
      </button>
    </div>
  </form>
</div>
<?php } ?>
<?php 
		

	} else if ($proceso == "eliminar"){ // sentencias para ELIMINAR un registro
		
		$id = $_POST["id"];
		//$sql = "delete from opcion where preid = $id";
		//echo $sql;
		$insercion = consultaSql($sql);
		
		$sql = "DELETE FROM $tabla WHERE preId = $id";
		//echo $sql;
		$insercion = consultaSql($sql);
		echo $insercion;
		


	if (file_exists("../img/pregunta/".$id.".png")) {
		unlink("../img/pregunta/".$id.".png");	
	} 
	if (file_exists("../img/pregunta/".$id.".jpg")) {
		unlink("../img/pregunta/".$id.".jpg");	
	} 		
		
	}  else if ($proceso == "modificar"){ // sentencias para ELIMINAR un registro
		
		//foreach ($_POST as $key => $value){ echo "{$key} = {$value}\r\n<br>";}
			//print_r($_FILES);

if(isset($_FILES ["imagen"]) && $_FILES["imagen"]["name"] != ''){
			
			//toma el archivo y lo pasa a una variable
			$foto    = $_FILES["imagen"];
			//extrae las propiedades del archivo
			$nombre  = $foto["name"];
			$tipo    = $foto["type"];
			$rutaTmp = $foto["tmp_name"] ;
			$size    = $foto["size"];
			// otras propiedades del archivo calculadas
			$dimensiones = getimagesize($rutaTmp); 
			$width = $dimensiones[0];
			$height = $dimensiones[1];
			$carpeta = "img/pregunta/";

			
			if ($tipo != "image/jpeg" && $tipo != "image/png"){
				echo "Error, el archivo no es una imagen"; 
			}
			else if ($size > 1024*1024*15){
				echo "Error, el tamaño máximo permitido es un 4 Megabytes"; 
			}
			else if ($width > 20000 || $width < 60 || $height > 20000 || $height < 60){
				echo "Error la anchura y la altura de la images debe de ser menores de 2000px";
			}
			else{
				
				$imagenOk = true;
			}
		}else {
		//	echo " Sin imagen\n";
			$imagenOk = true;
		}

		if ($imagenOk) {			
 
 			$preId       = $_POST['preId'];
			$usuId       = $_POST['usuId'];		
			$clase       = nulo($_POST['clase']);
			$area        = nulo($_POST['area']);
			$competencia = nulo($_POST['competencia']);
			$pregunta1   = nulo($_POST['pregunta1']);
			$contexto    = nulo($_POST['contexto']);			
			$nivel       = (!isset($_POST['nivel']))?"":nulo($_POST['nivel']); 
			$pregunta2   = nulo($_POST['pregunta2']);						 
			$afirmacion  = nulo($_POST['afirmacion']); 
			$estado  = $_POST['activa']; 
			$fuente  = nulo($_POST['fuente']); 

			$sql =" UPDATE pregunta SET 
					 `preClase` = $clase, 
					 `preArea` = $area, 
					 `preCompetencia` = $competencia, 
					 `preAfirmacion` = $afirmacion, 
					 `conId` = $contexto,
					 `prePregunta` = $pregunta1, 
					 `prePosPregunta` = $pregunta2, 
					 `preNivel` = $nivel, 
					 `preEstado` = $estado, 
					 `preFuente` = $fuente
					  WHERE `preId` = $preId;";
			//echo $sql;

			$insercion = consultaSql($sql);

			if($insercion) {
				echo "insercion ejecutada correctamente";

				if (isset($_FILES ["imagen"]) && $_FILES["imagen"]["name"] != '') {//AGREGAR LA IMAGEN	
					
					$trozos = explode(".", $nombre); 
					$extension = end($trozos);  
					$nombre = $preId.".".$extension;

					$src = $carpeta.$nombre;
					move_uploaded_file ($rutaTmp, "../".$src); 

					//actualizar el dato de la imagen en el campo usuario
					//echo "UPDATE `contexto` SET `conImagen`='$nombre' WHERE  `conId`=$ultimo;";
					$insercion2 = consultaSql("UPDATE `pregunta` SET `preImagen`='$nombre' WHERE  `preId`=$preId;");
					if($insercion2) {
						//echo "imagen insertada correctamente";
					}else{
						echo "error al insertar la imagen";
					}
				} 

			}else{
				echo "error en la insercion de los datos, verifique el contenido";
			}
		} 


	} 
}else{
	echo "ingreso prohibido";
	header('Location:'.$pagHeader);	
	
}

?>
