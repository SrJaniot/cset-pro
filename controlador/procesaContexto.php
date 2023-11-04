<?php
session_start();
//imprime las variables con su contenido	
//foreach ($_POST as $key => $value){ echo "{$key} = {$value}\r\n<br>";}
//print_r($_FILES)."<br>"; print_r($_POST)."<br>";

if(isset($_POST['proceso'])){
	
	include ("../modelo/conexion.php");
	$tabla = "contexto";	
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
			$carpeta = "img/contexto/";

			
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

			$contexto1  = nulo($_POST['contexto1']);
			$contexto2  = nulo($_POST['contexto2']);
			$fuente  = nulo($_POST['fuente']);
			$usuId  = $_POST['usuId'];

			$sql ="INSERT INTO contexto VALUES (NULL,$contexto1,null, $contexto2, $now ,$usuId,$fuente,NULL);";
			//echo $sql;

			$insercion = consultaSql($sql);

			if($insercion) {
				echo "insercion ejecutada correctamente";

				if (isset($_FILES ["imagen"]) && $_FILES["imagen"]["name"] != '') {//AGREGAR LA IMAGEN	

					$ultimo = consultaSql("select MAX(conid) ultimo from contexto;");
					$ultimo = $ultimo->fetch_object()->ultimo;	

					$trozos = explode(".", $nombre); 
					$extension = strtolower( end($trozos));  
					$nombre = $ultimo.".".$extension;

					$src = $carpeta.$nombre;
					move_uploaded_file ($rutaTmp, "../".$src); 

					//actualizar el dato de la imagen en el campo usuario
					//echo "UPDATE `contexto` SET `conImagen`='$nombre' WHERE  `conId`=$ultimo;";
					$insercion2 = consultaSql("UPDATE `contexto` SET `conImagen`='$nombre' WHERE  `conId`=$ultimo;");

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

		$id       = $_POST['id'];
		$sql ="select conid, confuente, contexto, conimagen, contexto2, confechacreacion,
		usuario.usuid, concat(usunombre1,' ', usuapellido1,' ', COALESCE(usuapellido2,'')) 'Creado' from contexto 
		INNER JOIN usuario on contexto.usuid = usuario.usuId
		where contexto.conId = $id;";
		//echo $sql;

		$resultado = consultaSql($sql);
		
		if( $resultado->num_rows){
			
			$oRes = htmlDecode($resultado->fetch_object());	?>  
			
			<button id="eliminaContexto" type="button" class="botonStandar2" style="position: absolute; right:0px; margin:0em 1em;">
          <h4> &nbsp;&nbsp;Eliminar Contexto&nbsp;&nbsp; </h4>
          </button>
          <h1 class="text-center" >Contexto No: <?php echo $oRes->conid; ?></h1>
          <h4 class="text-center" >Insertado por: <?php echo $oRes->Creado; ?></h4>
          
           <?php if($oRes->confuente != ""){ ?> 
         	 <h6 class="text-center" >Fuente: <i><?php echo $oRes->confuente ?></i></h6      
           ><?php } ?>
                  
          <hr>
          <div class="col-xs-12  col-sm-10 col-sm-push-1">
		  <?php echo str_replace("\n", "<br>", $oRes->contexto);  ?></div>
          <div class="col-xs-12  col-sm-10 col-sm-push-1">
          
          <?php if($oRes->conimagen != ""){ ?> 
       	    <img class="img-responsive center-block" src="img/contexto/<?php echo $oRes->conimagen; ?>" alt="imagen">          
           <?php } ?>
           
          </div>
          <div class="col-xs-12  col-sm-10 col-sm-push-1">
		  <?php echo str_replace("\n", "<br>", $oRes->contexto2); ?>
          </div>
						
			<?php 
		}else{ ?> 
         <h1 class="text-center" > Este contexto fue eliminado</h1>
         <?php }

	} else if ($proceso == "eliminar"){ // sentencias para ELIMINAR un registro
		
		$id = $_POST["id"];
		$insercion = consultaSql("DELETE FROM $tabla WHERE conId = $id");
		echo $insercion;
		unlink("../img/contexto/".$id.".png");	
		unlink("../img/contexto/".$id.".jpg");	
	} 

}else{
	echo "ingreso prohibido";
	header('Location:'.$pagHeader);	
	
}

?>
