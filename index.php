<?php 
session_start();
extract ($_REQUEST);
 $nav=0; // para deshabilitar el boton seleccionado de la barra de navegacion
$errorSesion=""; //mensaje por defecto vacio osea que no hay error en el inicio de sesion
if(isset($_REQUEST['val'])){$val=$_REQUEST['val']; //variable para definir un error de sesion
if($val==1){$errorSesion="El usuario ingresado no existe intente de nuevo";}
if($val==2){$errorSesion="La contraseña es incorrecta intente de nuevo";}
if($val==3){$errorSesion="Usuario Inactivo, comuniquese con el administrador";}}?>

<!DOCTYPE html>
<html lang="es">
<head>
<?php include 'inc/head.php'; ?>
<title>CSET PRO</title>
</head>

<body><?php //inicio del body del documento *********************************** 
 
if(!isset($_SESSION['usuId'])){ // si no  exite una sesion activa muestra el login

	 include 'inc/login.php'; // pagina con el login 
	 
}else { //si existe sesios entonces muestra la pagina que corresponsa segun el rol

	include 'inc/header.php'; // cabecera de la pagina
	$nav=10 ; 
	include 'inc/nav.php'; //barra de navegacion
	
	switch ($_SESSION['rol']) { // pagina para cada rol
		
		case "admin":
		include 'vista/indexAdmin.php'; // contenido de la pagina de administracion
			break;
			
		case "instructor":
			include 'vista/indexInstructor.php'; // contenido de la pagina instructor
			break;
			
		case "aprendiz":
			include 'vista/indexAprendiz.php'; // contenido de la pagina aprendiz
			break;
			
		case "consultor":
			include 'vista/indexConsultor.php'; // contenido de la paginaconsultor
			break;
	}
}
	 
include 'inc/footer.php'; //pie de pagina de la pagina
?>

</body>
</html>