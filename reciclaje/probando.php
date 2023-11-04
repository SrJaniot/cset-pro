<button type="button" class="btn btn-lg btn-danger" data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?">Click to toggle popover</button>

<?php 
include ("modelo/conexion.php");
 echo "<hr>";
 echo 'Versión actual de PHP: ' . phpversion();
 echo "<br>";
 echo "start TRANSACTION;
 insert into auxiliar values (null,'x','xx','xxx','xxxx',now());
 insert into auxiliar values (null,'x','xx','xxx','xxxx',now());
 COMMIT;";
 
 
 $res = consultaSql("select UNIX_TIMESTAMP() 'time';");
$ores = $res->fetch_object();
echo 'server = '.$ores->time.'<br> -p h p = '.time();
 echo "<hr>";
  
 echo td("1428958003")."<br>";
 echo "1428958003"."<br>";
 echo time();
 echo "<hr>";
 echo $_SERVER['DOCUMENT_ROOT'] ;
 echo "<br>";
 echo $_SERVER['HTTP_HOST'];
 echo "<hr>";
foreach ($_SERVER as $key => $value){ echo "{$key} = {$value}\r\n<br>";}
 echo "<hr>";
 echo "<hr>";
echo "Hora de Colombia GMT -5:00<br>";
$res = consultaSql("select $now 'hora';");
$ores = $res->fetch_object();
echo $ores->hora;
echo "<br>";
 ?>
