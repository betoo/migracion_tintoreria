<?php 
	
	//conexion a base de datos
	$link = mysql_connect('localhost', 'root', 'tinto')
    or die('No se pudo conectar: ' . mysql_error());
	echo 'Connected successfully';



	/*****************************
		migracion productos
	******************************/
	//obtiene datos 
	$query = 'SELECT * FROM tintoreria.master_tinprod;';
	mysql_select_db('tintoreria') or die('No se pudo seleccionar la base de datos tintoreria');
	$result = mysql_query($query) or die('Consulta master_tinprod fallida: ' . mysql_error());
	$line = mysql_fetch_assoc($result);


	mysql_select_db('tintoreriaCI') or die('No se pudo seleccionar la base de tintoreriaCI');
	//unidades de medidas
	$query_medidas = 'SELECT * FROM tintoreriaCI.medidas;';
	$medidas = mysql_query($query_medidas) or die('Consulta fallida: ' . mysql_error());


	//ARMA ARRAY ASOCIATIVO DE UNIDADES DE MEDIDAS 
	while ($line = mysql_fetch_array($medidas, MYSQL_ASSOC)) {
			$unidad_medida[$line['abreviadomed']]=[
													'id' =>$line['id_______med'], 
													'nombre' =>$line['nombre___med']
												];
	}
	
	/* ingresando productos */
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$unidad=empty($unidad_medida[$line['Unidad']]['id'])? 'NULL':$unidad_medida[$line['Unidad']]['id'];//si, unidad es vacio lo cambia por NULL
		$str="'".trim($line['Producto'])."','".trim($line['Descrip'])."',".$unidad.",10";

		$query2 ="INSERT INTO producto (nombre___prd,observaciprd,medidas_id_______med,stock_minprd) VALUES ($str)";
		echo '<br>';
		print_r($query2);
		echo '<br>';
		$result1  =mysql_query($query2);
	    if (!$result1) {
		    die('Invalid query: ' . mysql_error());
		}
	}
	mysql_free_result($result1);
	mysql_free_result($result);
	/*****************************
		FIN migracion productos
	******************************/

	/*****************************
		migracion RECETA Estandar
	******************************/

						/*****************************
								 ENCABEZADO
						******************************/
	mysql_select_db('tintoreria') or die('No se pudo seleccionar la base de datos Tintoreria');

	$query = 'SELECT * FROM tintoreria.master_tinenres;';
	$result = mysql_query($query) or die('Consulta master_tinenres fallida: ' . mysql_error());

	mysql_select_db('tintoreriaCI') or die('No se pudo seleccionar la base tintoreriaCI');

	$campos='Receta, Descrip, Costo, Fibra, Por1, Por2, Costop, Manual, Valcos, Unialt';
	while ($line = mysql_fetch_assoc($result)) {

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
		$result  =mysql_query($insert);
		
	}

						/*****************************
							FIN ENCABEZADO
						******************************/

						/*****************************
								 	DETALLE
						******************************/

	mysql_select_db('tintoreria') or die('No se pudo seleccionar la base de datos Tintoreria');

	$query = 'SELECT * FROM tintoreria.master_tinderes;';
	$result = mysql_query($query) or die('Consulta master_tinderes Fallida: ' . mysql_error());

	mysql_select_db('tintoreriaCI') or die('No se pudo seleccionar la base de datos2');
	$campos='Receta,Linea1,Producto,Cantidad,Incidencia,Comentario';
	while ($line = mysql_fetch_assoc($result)) {

		$values= 	"'".
					mysql_real_escape_string($line['Receta'])."','".
					mysql_real_escape_string($line['Linea1'])."','".
					mysql_real_escape_string($line['Producto'])."','".
					mysql_real_escape_string($line['Cantidad'])."','".
					mysql_real_escape_string($line['Incidencia'])."','".
					mysql_real_escape_string($line['Comentario'])."'";

		$insert = "insert into  master_tinderes (".$campos.") values (".$values." ) ;";
		echo "<br>";
		print_r($insert);
		$resultado = mysql_query($insert) or die('Consulta fallida: ' . mysql_error());
		$result  =mysql_query($insert);
		
	}



						/*****************************
								FIN  DETALLE
						******************************/



	/*****************************
		FIN migracion RECETAS Estandar
	******************************/

		/*****************************
			migracion RECETA Especifica
		******************************/

						/*****************************
								 ENCABEZADO
						******************************/
	mysql_select_db('tintoreria') or die('No se pudo seleccionar la base de datos Tintoreria');

	$query = 'SELECT * FROM tintoreria.master_tinenree;';
	$result = mysql_query($query) or die('Consulta master_tinenree fallida: ' . mysql_error());

	mysql_select_db('tintoreriaCI') or die('No se pudo seleccionar la base tintoreriaCI');


	$campos='Recetacor,Clasific,Kg1fib,Kg2fib,Descrip,Fecha,Costotot,Flag,Hora,Litros,Reproceso,Clarepro,Unialt,Reccli';
	while ($line = mysql_fetch_assoc($result)) {
		$values= 	"'".
					mysql_real_escape_string($line['Recetacor'])."','".
					mysql_real_escape_string($line['Clasific'])."','".
					mysql_real_escape_string($line['Kg1fib'])."','".
					mysql_real_escape_string($line['Kg2fib'])."','".
					mysql_real_escape_string($line['Descrip'])."','".
					mysql_real_escape_string($line['Fecha'])."','".
					mysql_real_escape_string($line['Costotot'])."','".
					mysql_real_escape_string($line['Flag'])."','".
					mysql_real_escape_string($line['Hora'])."','".
					mysql_real_escape_string($line['Litros'])."','".
					mysql_real_escape_string($line['Reproceso'])."','".
					mysql_real_escape_string($line['Clarepro'])."','".
					mysql_real_escape_string($line['Unialt'])."','".
					mysql_real_escape_string($line['Reccli'])."'";

		$insert = "insert into  master_tinenres (".$campos.") values (".$values." ) ;";
		echo "<br>";
		print_r($insert);
		$resultado = mysql_query($insert) or die('Consulta fallida: ' . mysql_error());
		$result  =mysql_query($insert);
		
	}

						/*****************************
							FIN ENCABEZADO
						******************************/

						/*****************************
								 	DETALLE
						******************************/

	mysql_select_db('tintoreria') or die('No se pudo seleccionar la base de datos Tintoreria');

	$query = 'SELECT * FROM tintoreria.master_tinderee;';
	$result = mysql_query($query) or die('Consulta master_tinderee Fallida: ' . mysql_error());

	mysql_select_db('tintoreriaCI') or die('No se pudo seleccionar la base de datos2');
	$campos='Receta,Linea1,Producto,Cantidad,Incidencia,Comentario';
	while ($line = mysql_fetch_assoc($result)) {
		$values= 	"'".
					mysql_real_escape_string($line['Recetacor'])."','".
					mysql_real_escape_string($line['Linea1'])."','".
					mysql_real_escape_string($line['Producto'])."','".
					mysql_real_escape_string($line['Cantidad'])."','".
					mysql_real_escape_string($line['Incidencia'])."','".
					mysql_real_escape_string($line['Comentario'])."','".
					mysql_real_escape_string($line['Costo'])."','".
					mysql_real_escape_string($line['Costo5'])."'";

		$insert = "insert into  master_tinderes (".$campos.") values (".$values." ) ;";
		echo "<br>";
		print_r($insert);
		$resultado = mysql_query($insert) or die('Consulta fallida: ' . mysql_error());
		$result  =mysql_query($insert);
		
	}



						/*****************************
								FIN  DETALLE
						******************************/



	/*****************************
		FIN migracion RECETAS Especifica
	******************************/



	mysql_free_result($result);
	mysql_free_result($result1);
	// Cerrar la conexión
	mysql_close($link);
 ?>



