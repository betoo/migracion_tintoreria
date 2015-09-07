<?php 

	/*base de datos antigua*/
	$link = mysql_connect('localhost', 'root', 'tinto')
    or die('No se pudo conectar:  '. mysql_error());
	echo 'Connected successfully';
	mysql_select_db('tintoreria') or die('No se pudo seleccionar la base de datos');

	/*base de datos nueva*/
	
	$query = 'SELECT * FROM tintoreria.master_tinenres;';
	$result = mysql_query($query) or die('Consulta fallidaaaaa: ' . mysql_error());

	mysql_select_db('tintoreriaCI') or die('No se pudo seleccionar la base de datos2');
	
	$campos='Receta, Descrip, Costo, Fibra, Por1, Por2, Costop, Manual, Valcos, Unialt';
	while ($line = mysql_fetch_assoc($result)) {
		//print_r($line);
		//ECHO "<BR>";

		$values= 	"'".
					mysql_real_escape_string($line['Receta'])."','".
					mysql_real_escape_string($line['Descrip'])."','".
					mysql_real_escape_string($line['Costo'])."','".
					mysql_real_escape_string($line['Fibra'])."','".
					mysql_real_escape_string($line['Por1'])."','".
					mysql_real_escape_string($line['Por2'])."','".
					mysql_real_escape_string($line['Costop'])."','".
					mysql_real_escape_string($line['Manual'])."','".
					mysql_real_escape_string($line['Valcos'])."','".
					mysql_real_escape_string($line['Unialt'])."'";

		$insert = "insert into  master_tinenres (".$campos.") values (".$values." ) ;";
		echo "<br>";
		print_r($insert);
		$resultado = mysql_query($insert) or die('Consulta fallida: ' . mysql_error());
		//$result  =mysql_query($insert);
		
	}
	mysql_free_result($resultado);

	// Cerrar la conexión
	mysql_close($link);
 ?> 

