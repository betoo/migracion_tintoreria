<?php 
if(function_exists('xdebug_disable')) { xdebug_disable(); }


	
	include('functions.php');

	gc_enable() ;
	$link = mysqli_connect("localhost","root","tinto","tintoreriaCI") or die("No se pudo conectar a base de datos:  " . mysqli_error($link)); 
	$link->query("set foreign_key_checks=0");

	$tiempo_inicio = microtime(true);	

	$db_old="tintoreria";
	$db_new="tintoreriaCI";


	/*master_maquina*/
	$table_old="master_maquina";
	$table_new="maquinaria";
	$num_querys=2;
	$relations=[
		'Nombre'	=> 'nombre___maq',
		'Capacidad' => 'capacidadmaq',
		'Hora' 		=> null,
		'Minutos' 	=> null,
		'Jornada' 	=> null,
		'Dispon' 	=> null,
	];

	$count_old=row_count($table_old,$link,$db_old);
	$count_new=row_count($table_new,$link,$db_new);

	$offsets=0;
	$cantidad=ceil($count_old/$num_querys);

	for ($i=0; $i < $num_querys ; $i++) { 
		$asd=search_limit($table_old,$link,$db_old,$offsets,$cantidad) ;
		$offsets=$offsets+$cantidad;
	}

	print_r($asd);

	/*fim master_maquina*/


	/*mantencion*/

	/*fin mantencion*/

	$tiempo_fin = microtime(true);
	echo "<br>Tiempo empleado: " . ($tiempo_fin - $tiempo_inicio);
	echo "<br>Memory Peak Usage: ";
	echo memory_get_peak_usage(), "\n";
	$link->query("set foreign_key_checks=1");

	$link->close();

 ?>




