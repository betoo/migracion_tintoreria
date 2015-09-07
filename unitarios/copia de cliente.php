<?php 

	/*base de datos antigua*/
	$link = mysql_connect('localhost', 'root', 'tinto')
    or die('No se pudo conectar: ' . mysql_error());
	echo 'Connected successfully';
	mysql_select_db('tintoreria') or die('No se pudo seleccionar la base de datos');

	/*base de datos nueva*/
	
	$query = 'SELECT * FROM tintoreria.master_cliente;';
	$result = mysql_query($query) or die('Consulta fallidaaaaa: ' . mysql_error());
	$line = mysql_fetch_assoc($result);

	mysql_select_db('tintoYii2') or die('No se pudo seleccionar la base de datos2');
	// Imprimir los resultados en HTML
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
		//print_r($line);

		$str=$line['Codigo'].",'".$line['Razon']."','".$line['Direccion']."',1011";
		$query2 ="INSERT INTO cliente (codigo___cli,razon____cli,direccioncli,comuna_id_______com) VALUES ($str)";
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


    
