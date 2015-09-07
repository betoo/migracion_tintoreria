<?php 

	/*base de datos antigua*/
	$link = mysql_connect('localhost', 'root', 'tinto')
    or die('No se pudo conectar: ' . mysql_error());
	echo 'Connected successfully';
	mysql_select_db('tintoreria') or die('No se pudo seleccionar la base de datos');

	/*base de datos nueva*/
	
	$query = 'SELECT * FROM tintoreria.master_fibras;';

	$result = mysql_query($query) or die('Consulta fallidaaaaa: ' . mysql_error());
	$line = mysql_fetch_assoc($result);

	mysql_select_db('tintoreriaCI') or die('No se pudo seleccionar la base de datos2');
	// Imprimir los resultados en HTML
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$str=$line['Fi_fibra'].",'".$line['Fi_nomabre']."','".$line['Fi_nomexte']."'";
		$query2 ="INSERT INTO fibras (id_______fib,abreviadofib,nombre___fib) VALUES ($str)";
		echo '<br>';
		print_r($query2);
		echo '<br>';
		$result1  =mysql_query($query2);
	    if (!$result1) {
		    die('Invalid query: ' . mysql_error());
		}
	}
	mysql_free_result($result);
	mysql_free_result($result1);
	// Cerrar la conexión
	mysql_close($link);
 ?>




    
