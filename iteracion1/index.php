<?php 

	include('new.php');
	include('old.php');
	gc_enable() ;
	$tiempo_inicio = microtime(true);
	$link = mysqli_connect("localhost","root","tinto","tintoreria") or die("No se pudo conectar a base de datos:  " . mysqli_error($link)); 
	$link->query("set foreign_key_checks=0");

	
	/*******************************
			obtiene de datos
	********************************/
	$all_data=[];
	//recorre bd  
	foreach ($db_old as $db => $table) {
		//recorre tablas
		foreach ($table as $table_name => $columns) {

			//$count 			=count($columns);//para poner comas (,)
			$column_name 	="";

			//obtiene columnas para select
			foreach ($columns as $field => $type) {
				$column_name.=$field.",";	
			}	

			$column_name=rtrim($column_name,',');//elimina la ultima coma (,)

			if ($table_name=='master_tinderee' or $table_name=='master_tinenree' or $table_name=='master_piezas') {
				$query="SELECT $column_name from $table_name limit 0,1000";

			}else{
				$query="SELECT $column_name from $table_name ";
			}

			$result =$link->query($query);

			$new_data_tables=[];
			while ($line = mysqli_fetch_assoc($result)) {
				//creando una tabla a partir de otra 
				foreach ($columns as $field => $type) {
					$new_data=isset($new_table[$table_name][$field]);

					if ($new_data) {

						$new_data=isset($new_table[$table_name][$field]);
						if ($new_data) {
							$new_data=isset($new_table[$table_name][$field]);
							if ($new_data) {
								$nueva[$new_table[$table_name][$field]][][$field]=$line[$field];
								//$unique = array_merge(array_flip(array_flip($nueva[$new_table[$table_name][$field]]))); //error string quitar  dupicados	
							}
						}
					}
				}

				$all_data[$table_name][]=$line; //agrega tabla 	
			}
			if (!$result){
				print_r("Error  $table_name : <br>".mysqli_error($link));
			}else{
				echo "$table_name OK <br>";
			}
		}	
		$all_data = array_merge($nueva, $all_data);
	}
	$db=array_keys($db_new); //obtiene nombre db
	$nombre_db=$db[0]; // nombre db
	$link->query("use ".$nombre_db); //cambia a base de datos nueva


	//recorre tablas
	foreach ($all_data as $data_tables => $data_value) {

		
		//cambia nombres de tablas (antiguos por nuevos)
		if (array_key_exists($data_tables, $relations_table)) {
			$table_name=$relations_table[$data_tables];
		}else{
			$table_name=$data_tables;
		}

		$insert=null;
		//recorre columnas
		foreach ($data_value as $data_table => $data_columns) {
			$columns_name=null;
			$values_row=null;
			$columns=null;

			$count=count($data_table);//para poner comas (,)

			//cambiando nombres de culumnas 
			foreach ($data_columns as $field => $data_field) {
				//setea campos
				$field=trim($field);//campo(antiguo)
				$data_field=trim($data_field); //dato del campo

				$asd=isset($db_new[$nombre_db][$data_tables][$field]);


				//cambiando campo antiguo por nuevo 
				if (isset($db_new[$nombre_db][$data_tables][$field])) {

					$columns_name=$db_new[$nombre_db][$data_tables][$field];
					print_r($columns_name);

				}

				$data_field='"'.$link->real_escape_string( $data_field ).'",';	
				$columns_name=$field.",";
			}

			$columns_name=rtrim($columns_name,',');//elimina la ultima coma (,)
			$data_field=rtrim($data_field,',');//elimina la ultima coma (,)
			$insert.="(".$data_field.")";

		}
		
		$insert = str_replace(")(", "),(", $insert);
		$query = 'INSERT INTO '.$table_name.' ( '.$columns_name.' )values  '.$insert.'  ;'or die("Error en la consulta" . mysqli_error($link));
		
		//print_r($query);
		$result =$link->query($query);
		if ($result) {
			echo "EXITO $data_tables <br>";
		}else{
			print_r("FAIL $data_tables <br>".mysqli_error($link));
		} 
	}

	$tiempo_fin = microtime(true);
	echo "Tiempo empleado: " . ($tiempo_fin - $tiempo_inicio);
	echo "<br>";
	echo memory_get_peak_usage(), "\n";
	$link->query("set foreign_key_checks=1");
	
	$link->close();
	exit();
	 
 

	/*******************************
		  fin obtiene de datos
	********************************/
 /*
$sql->free();
    $mysqli_connection->close();
 */

 /*
	delete from  producto;



	use tintoreriaCI;
	select count(*) from  cliente;
	select count(*) from transporte;
	select count(*) from condicion;
	select count(*) from producto;
	select count(*) from medidas ; 
	select count(*) from master_tinderee;
	select count(*) from master_tinenree;
	select count(*) from fibras;
	select count(*) from piezas;
	select count(*) from tejido;

	
	use tintoreriaCI;
	select * from  cliente limit 0,10;
	select * from transporte limit 0,10;
	select * from condicion limit 0,10;
	select * from producto limit 0,10;
	select * from medidas limit 0,10; 
	select * from master_tinderee limit 0,10;
	select * from master_tinenree limit 0,10;
	select * from master_fibras limit 0,10;
	select * from master_piezas limit 0,10;
	select * from tejido limit 0,10

	use tintoreriaCI;
	delete from cliente	;
	delete from transporte;
	delete from producto;
	delete from master_tinderee;
	delete from master_tinenree;
	delete from condicion;
	delete from medidas;
	delete from fibras;
	delete from piezas;
	delete from tejido;

	
	--select * from master_tinderee;
	
 */
 ?>

