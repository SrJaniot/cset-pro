<?php  
require "../modelo/conexion.php";
    if (isset($_POST['action']) == "upload") {
        //cargamos el archivo al servidor con el mismo nombre
        //toma el archivo y lo pasa a una variable
        $archivo = $_FILES['excel']['name'];
        $tipo = $_FILES['excel']['type'];
        //solo le agregue el sufijo bak_ 
        $destino = "bak_" . $archivo;
        // si el archivo esta vacio lo rechaza
        if (!empty($archivo)) {
            // si el archivo no es .xlxs lo rehaza
            if ($tipo == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {               
                if (copy($_FILES['excel']['tmp_name'], $destino)){
                    echo "Archivo Importado Con Exito";
                    echo "<br>";
                }
                //si por algo no cargo el archivo bak_ 
                else{
                    echo "Error Al Cargar el Archivo";
                }
                // si todo sale bien
                if (file_exists("bak_" . $archivo)) {
                    /** Clases necesarias */
                    require_once('../modelo/PHPExcel.php');
                    require_once('../modelo/PHPExcel/Reader/Excel2007.php');
                    // Cargando la hoja de cálculo
                    $objReader = new PHPExcel_Reader_Excel2007();
                    $objPHPExcel = $objReader->load("bak_" . $archivo);
                    $objFecha = new PHPExcel_Shared_Date();
                    // Asignar hoja de excel activa
                    $objPHPExcel->setActiveSheetIndex(0);
                    //conectamos con la base de datos 
                    //$cn = mysql_connect("localhost", "root", "") or die("ERROR EN LA CONEXION");
                    //$db = mysql_select_db("csetpro", $cn) or die("ERROR AL CONECTAR A LA BD");
                    // Llenamos el arreglo con los datos  del archivo xlsx
                    $filavacia = 1;
                    $i = 2;
                    $errores = 0; 
                    $insertados = 0;            
                    while ($filavacia) {         
                        $tipodoc1 = trim($objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue());
                        $numerodoc1 = trim($objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue());                    
                        $nombre1 = trim($objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue());
                        $nombre2 = trim($objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue());
                        $apellido1 = trim($objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue());
                        $apellido2 = trim($objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue()); 
                        $ficha = trim($objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue());                                          
                        //$pas = md5($numerodoc1);     
                        $pas = $numerodoc1;                                           
                        //verifica si todas las celdas ya estan vacias para dar final al recorrido en las filas del excel.                
                        if ($tipodoc1 == '' && $numerodoc1 == '' && $nombre1 == '' && $nombre2 == '' && $apellido1 == '' && $apellido2 == '') {
                            $filavacia = 0;                 
                        }
                        //si el campo numerodoc1 o nombre1 o apellido1 esta vacio
                        elseif ($numerodoc1 == '' || $nombre1 == '' || $apellido1 == '' ) {
                            echo "Error en la fila ". $i.": Ninguno de estos campos pueden estar vacios (Numero Doc, Primer Nombre, Primer Apellido)."."<br>";
                            $errores++;
                        }
                        // verifica que la variable numerodoc este compuesta solo de numeros
                        elseif (!is_numeric($numerodoc1)) {
                            echo "Error en la fila ". $i.": ".$numerodoc1." debe ser solo numerico."."<br>";
                            $errores++;
                        }
                        // verificaque no haya solo espacios, tabs o enters en las variables
                        elseif (ctype_space($tipodoc1) || ctype_space($nombre1) || ctype_space($nombre2) || ctype_space($apellido1) || ctype_space($apellido2)) {
                            echo "Error en la fila ". $i.": el tipo de documento, Los nombres y apellidos deben ser solo letras."."<br>";
                            $errores++;
                        }
                        //verifica que solo este compuesto de letras
                        elseif (!sonLetras($nombre1) || !sonLetras($nombre2) || !sonLetras($apellido1) || !sonLetras($apellido2)) {
                            echo "Error en la fila ". $i.": Los nombres y apellidos deben ser solo letras."."<br>";
                            $errores++;
                        }
                        //verifica si el usuario ya existe en la base de datos
                        elseif ((consultaSQL("select COUNT(*) 'existe' from usuario where usunumerodoc = $numerodoc1")->fetch_object()->existe)) {
                            echo "Error en la fila ". $i.": El usuario: ". $numerodoc1." ya existe en la base de datos."."<br>";
                            $errores++;
                        }
                        //verifica si la ficha a la que voy a asociar a el usuario ya existe en la base de datos
                        elseif (!(consultaSQL("select COUNT(*) 'existe' from ficha where ficId = $ficha")->fetch_object()->existe)) {
                            echo "Error en la fila ". $i.": Aun no se ha creado la ficha(".$ficha.") en la que intenta asociar al aprendiz: ". $numerodoc1."<br>";
                            $errores++;
                        }
                        else {
                            $sql = "INSERT INTO usuario (usuId, usuTipoDoc, usuNumeroDoc, usuNumeroDocAnterior, usuNombre1, usuNombre2, usuApellido1, usuApellido2, usuFoto, usuSexo, usuRol,ficId,usuPassword, usuEstado, usuInsercion) 
                            VALUES (NULL,'$tipodoc1','$numerodoc1','$numerodoc1','$nombre1','$nombre2','$apellido1','$apellido2','perfil.jpg','masculino','aprendiz','$ficha','$pas','1', $now );";
                            //echo "$sql"."<Br>";
                            $result = consultaSQL($sql);
                            if (!$result) {
                            echo "Error al insertar registro " . $numerodoc1."<br>";
                            $errores++;
                            }                            
                        } 
                        $i++; 
                    } 
                    $insertados = $i - 3;
                    $exito= $insertados - $errores;   
                    echo "<strong><center>DE $insertados REGISTROS EN TOTAL, $exito FUERON CARGADOS CON EXITO EN LA BASE DE DATOS Y $errores ERRORES</center></strong>";  
                }
            //una vez terminado el proceso borramos el archivo que esta en el servidor el bak_
            unlink($destino);
            }          
            else {    
                echo "El archivo que intencar cargar no es del formato .xlsx";
            }        
        } 
        else {
            echo "Necesitas primero importar el archivo";
        }      
    }
?>   