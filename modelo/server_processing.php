<?php
require "../modelo/conexion.php";

// Tabla de la BD a usar
$table = $_REQUEST['t']; 

// Columna que guarda la primari key
$primaryKey = consultaColumnasId($table);

//arreglo con el nombre de las comlumnas en la Tabla, o Vista segun sea el caso
// db es el nombre y dt es la posicion en la que va a aparecer
// para dar formatos especificos a datos como fechas o valores hay un ej al final de la pag	
$columns = consultaColumnasArreglo($table);	

// Informacion de la conexion
$sql_details = array(
	'user' => varCon('user'),
	'pass' => varCon('pass'),
	'db'   => varCon('db'),
	'host' => varCon('host')
);

// clase que procesa los datos y devuelve la tabla
require( 'ssp.class.php' );

//  procesa los datos y devuelve un objeto de JSON
echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);

//FIN

/* ejemplo de un arreglo con los nombres de la filas de la tabla
$columns = array(

	array( 'db' => 'areId', 'dt' => 0 ),
	array( 'db' => 'areArea',  'dt' => 1 ),
	array( 'db' => 'areCompetencia',   'dt' => 2 ),
	
	);*/

/* ejemplo de como se da formato a datos como fechas o valores
array(
		'db'        => 'start_date',
		'dt'        => 4,
		'formatter' => function( $d, $row ) {
			return date( 'jS M y', strtotime($d));
		}
	),
	array(
		'db'        => 'salary',
		'dt'        => 5,
		'formatter' => function( $d, $row ) {
			return '$'.number_format($d);
		}
	)
*/