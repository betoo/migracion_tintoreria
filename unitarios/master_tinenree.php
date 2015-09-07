<?php 

	/*base de datos antigua*/
	$link = mysql_connect('localhost', 'root', 'tinto')
    or die('No se pudo conectar: ' . mysql_error());
	echo 'Connected successfully';
	mysql_select_db('tintoreria') or die('No se pudo seleccionar la base de datos');

	/*base de datos nueva*/
	
	$query = 'SELECT * FROM tintoreria.master_tinenree;';
	$result = mysql_query($query) or die('Consulta fallidaaaaa: ' . mysql_error());

	mysql_select_db('tintoreriaCI') or die('No se pudo seleccionar la base de datos2');
	$campos='Recetacor,Clasific,Kg1fib,Kg2fib,Descrip,Fecha,Costotot,Flag,Hora,Litros,Reproceso,Clarepro,Unialt,Reccli';
	while ($line = mysql_fetch_assoc($result)) {

		$values= 	"'".
					mysql_real_escape_string($line['Recetacor'])."','".
					mysql_real_escape_string($line['Kg1fib'])."','".
					mysql_real_escape_string($line['Kg2fib'])."','".
					mysql_real_escape_string($line['Descrip'])."','".
					mysql_real_escape_string($line['Fecha'])."','".
					mysql_real_escape_string($line['Hora'])."','".
					mysql_real_escape_string($line['Litros'])."','".
					mysql_real_escape_string($line['Reccli'])."'";

		$insert = "insert into  master_tinenree (".$campos.") values (".$values." ) ;";
		$resultado = mysql_query($insert) or die('Consulta fallida: ' . mysql_error());
		//$result  =mysql_query($insert);
		
	}
	mysql_free_result($resultado);

	// Cerrar la conexión
	mysql_close($link);
 ?>

