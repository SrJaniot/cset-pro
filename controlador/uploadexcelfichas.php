<?php  
require "../modelo/conexion.php";
    if (isset($_POST['action']) == "upload") {
        //cargamos el archivo al servidor con el mismo nombre
        //toma el archivo y lo pasa a una variable
        $archivo = $_FILES['excel']['name'];
        $tipo = $_FILES['excel']['type']; 
        //echo "$tipo";       
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
                        $idficha = trim($objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue());
                        $nombreficha = trim($objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue());                    
                        $jornadaficha = trim($objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue()); 
                        $nivelficha = trim($objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue());
                        $fechainificha = trim($objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue());
                        $centroficha = trim($objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue());                                              
                        // toma la fecha y la covierte en segundos php
                        $timestamp = PHPExcel_Shared_Date::ExcelToPHP($fechainificha);
                        // convierte los segundos php en fecha 
                        $fechainificha = date("Y-m-d",$timestamp);                        
                        //si todas las celdas ya estan vacias.                
                        if ($idficha == '' || $nombreficha == '' || $jornadaficha == '' || $nivelficha == '' || $fechainificha == '' || $centroficha == '') {
                            $filavacia = 0;                 
                        }
                        //si el campo ficha esta vacio
                        elseif ($idficha == '') {
                            echo "Error en la fila ". $i.": Este campo no puede estar vacio (idficha)"."<br>";
                            $errores++;
                        }
                        // verifica que la variable $idficha este compuesta solo de numeros
                        elseif (!is_numeric($idficha)) {
                            echo "Error en la fila ". $i.": ".$idficha." debe ser solo numerico."."<br>";
                            $errores++;
                        }
                        // verificaque no haya solo espacios, tabs o enters en las variables
                        elseif (ctype_space($nombreficha) || ctype_space($jornadaficha) || ctype_space($nivelficha) || ctype_space($centroficha)) {
                            echo "Error en la fila ". $i.": estos campos no pueden contener espacios, tabs o enter($nombreficha) ($jornadaficha) ($nivelficha) ($centroficha)."."<br>";
                            $errores++;
                        }
                        //verifica que solo este compuesto de letras
                        elseif (!sonLetras($nombreficha) || !sonLetras($jornadaficha) || !sonLetras($nivelficha)) {
                            echo "Error en la fila ". $i.": El nombre de la ficha debe ser solo letras."."<br>";
                            $errores++;
                        }
                        //verifica si la ficha ya existe en la base de datos
                        elseif ((consultaSQL("select COUNT(*) 'existe' from ficha where ficId = $idficha")->fetch_object()->existe)) {
                            echo "Error en la fila ". $i.": La ficha: ". $idficha." ya existe en la base de datos."."<br>";
                            $errores++;
                        }
                        else {
                            $sql = "INSERT INTO ficha (ficId, ficNombre, ficInicio, ficJornada, ficNivelTec, cenId, ficInsercion, ficEstado) 
                            VALUES ('$idficha','$nombreficha','$fechainificha','$jornadaficha','$nivelficha','$centroficha', $now ,'1');";
                            //echo "$sql"."<Br>";
                            $result = consultaSQL($sql);
                            if (!$result) {
                            echo "Error al insertar registro " . $idficha."<br>";
                            $errores++;
                            }                                                       
                        } 
                        $i++; 
                    } 
                    $insertados = $i - 3;
                    $exito= $insertados - $errores;   
                    echo "<strong><center>De $insertados REGISTROS EN TOTAL, $exito FUERON CARGADOS CON EXITO EN LA BASE DE DATOS Y $errores ERRORES</center></strong>";  
                }
            //una vez terminado el proceso borramos el archivo que esta en el servidor el bak_
            unlink($destino);
            }                                  
            else {    
                echo "El archivo que intenta cargar no es del formato .xlsx";
            }        
        } 
        else {
            echo "Necesitas primero importar el archivo";
        }     
    }
?>   