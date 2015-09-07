<?php 

	/*base de datos antigua*/
	$link = mysql_connect('localhost', 'root', 'tinto')
    or die('No se pudo conectar: ' . mysql_error());
	echo 'Connected successfully';
	mysql_select_db('tintoreria') or die('No se pudo seleccionar la base de datos');

	/*base de datos nueva*/
	
	$query = 'SELECT * FROM tintoreria.master_tinderee;';
	$result = mysql_query($query) or die('Consulta fallidaaaaa: ' . mysql_error());

	mysql_select_db('tintoreriaCI') or die('No se pudo seleccionar la base de datos2');
	
	$campos='Recetacor , Linea1 ,Cantidad, Producto , Incidencia, Comentario,Costo,Costo5';
	while ($line = mysql_fetch_assoc($result)) {
		//print_r($line);
		//ECHO "<BR>";

		$values= 	mysql_real_escape_string($line['Recetacor']).",'".
					mysql_real_escape_string($line['Linea1'])."','".
					mysql_real_escape_string($line['Producto'])."','".
					mysql_real_escape_string($line['Cantidad'])."','".
					mysql_real_escape_string($line['Incidencia'])."','".
					mysql_real_escape_string($line['Comentario'])."',".
					mysql_real_escape_string($line['Costo']).",".
					mysql_real_escape_string($line['Costo5']);

		$insert = "insert into  master_tinderee (".$campos.") values (".$values." ) ;";
		echo "<br>";
		print_r($insert);
		$resultado = mysql_query($insert) or die('Consulta fallida: ' . mysql_error());
		//$result  =mysql_query($insert);
		
	}
	mysql_free_result($resultado);

	// Cerrar la conexión
	mysql_close($link);
 ?>

