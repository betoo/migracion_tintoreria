<?php 

	/*base de datos antigua*/
	$link = mysql_connect('localhost', 'root', 'tinto')
    or die('No se pudo conectar: ' . mysql_error());
	echo 'Connected successfully';
	mysql_select_db('tintoreria') or die('No se pudo seleccionar la base de datos');

	/*base de datos nueva*/
	
	$query = 'SELECT * FROM tintoreria.master_oper;';
	$result = mysql_query($query) or die('Consulta fallidaaaaa:1 ' . mysql_error());
	$line = mysql_fetch_assoc($result);

	mysql_select_db('tintoreriaCI') or die('No se pudo seleccionar la base de datos2');
	// Imprimir los resultados en HTML
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
		//print_r($line);

		$str="'".$line['Op_nombre']."',1,1,1,1,1,1";
		$query2 ="INSERT INTO personal (nombre___per,empresa_id_______emp,cargo_id_______car,maquinaria_id_______maq,nacionalidad_id_______nac,comuna_id_______com,turno_id_______tur) VALUES ($str)";
		$result2  =mysql_query($query2) or die('Consulta fallidaaaaa: ' . mysql_error());
		echo "<br>-->";
		print_r($result1);

		$query4 ='SELECT  MAX(id_______per) from personal where nombre___per="' .$line['Op_nombre']. '"';
		$result4  =mysql_query($query4) or die('Consulta fallidaaaaa: ' . mysql_error());
		$id=(int)$result4;
		$str_user="'".$id."',1,2";
		$query3 ="INSERT INTO `tintoreriaCI`.`user_accounts` (uacc_group_fk ,uacc_email,uacc_password, uacc_ip_address,uacc_active,encargado_cliente_id_______enc) 
		VALUES (5, 'asdaa@123123.cl', '$2a$08$iv.CqFv2IYX8co9ZlZgkyOmP3ccbDdcKiRcheZZ8HfvCsTonnoOeC',  '127.0.0.1', 1,". $query4 . " )";
$result2  =mysql_query($query3);
		$result2  =mysql_query($query3);
		$result2  =mysql_query($query2);
	    if (!$result2) {
		    die('Invalid query: ' . mysql_error());
		}
	}
	mysql_free_result($result);
	mysql_free_result($result2);

	// Cerrar la conexión
	mysql_close($link);
 ?>


    
