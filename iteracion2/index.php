<?php 
if(function_exists('xdebug_disable')) { xdebug_disable(); }

	include('new.php');
	include('old.php');
	gc_enable() ;
	$tiempo_inicio = microtime(true);
	$link = mysqli_connect("localhost","root","tinto","tintoreria") or die("No se pudo conectar a base de datos:  " . mysqli_error($link)); 
	$link->query("set foreign_key_checks=0");

	$tiempo_inicio = microtime(true);	
	/*******************************
			obtiene de datos
	********************************/
	$link->query("truncate tintoreriaCI.cliente;");
	$link->query("truncate tintoreriaCI.condicion;");
	$link->query("truncate tintoreriaCI.transporte;");

	$name_db_new=array_keys($db_new); //obtiene nombre db
	$name_db_new=$name_db_new[0]; // nombre db

	//recorre bd  
	foreach ($db_old as $db => $table) { //nombre db = > array la tabla
		//recorre tablas
		foreach ($table as $table_name => $columns) { // nombre de tabla => nombre de columnas 
			
			$columns=array_filter($columns); //filtra y obtiene nombres de columnas que hacen relacion con la nueva db
			$num_consultas=$columns['num_consultas']; //establece numero de consultas que se realizaran en la base de datos (insert)
			$tabla_new=$columns['tabla_new']; //nombre de la db nueva
			$create_table=$columns['create_table'];//nuevas tablas 

			//si se crea una nueva variale en array de db y no es utilizada para el insert  se elimina (el array se ocupa para formar estructura de insert)
			unset($columns['num_consultas']);//quita del array 
			unset($columns['tabla_new']);//quita del array 
			unset($columns['create_table']);

			$columns_old=NULL;
			$columns_new=NULL;

			//campos para la migración 
			foreach ($columns as $column_old => $column_new) {
				$columns_old.=$column_old.',';//concatena nombres de columnas en una variable nueva 
				$columns_new.=$column_new.',';
			}

			$field_old=$columns_old;//es almacenado para saber qué campos se ingresan en la tabla (para diferenciar datos de nuevas tablas)

			//campos para la nuevas tablas 
			if (isset($create_table)) {
				foreach ($create_table as $column_old => $tables_new) {
					$new_tbl.=$column_old.',';//concatena nombres de columnas en una variable nueva 
				}
				$columns_old.=$new_tbl;//se concatenan campos para obtener columnas para nuevas tablas
			}

			$columns_old=rtrim($columns_old,',');//quita última coma (,)
			$columns_new=rtrim($columns_new,',');	
			$new_tbl 	=rtrim($new_tbl,',');	

			$query="SELECT  count(*) as total from $table_name "; //obtiene total de registros
			$result =$link->query($query);

			while ($line = mysqli_fetch_assoc($result)) {
				$total_registros=$line;
			} 

			$cantidad=ceil($total_registros['total']/$num_consultas);//cantidad de registros a insertar en una query 

			$offset=0;			
			for ($i=0; $i < $num_consultas ; $i++) { //ingresa en for la cantidad de veces que se ha definido en el campo "num_consultas" de $db_old

				$query="SELECT  $columns_old from $table_name limit ".$offset.",".$cantidad;
				$result =$link->query($query);

				$insert=NULL;
				$row_insert=null;				
				$row="";
				
				$data_new_tbl="";
				while ($line = mysqli_fetch_assoc($result)) { //recorre registros obtenidos de la base de datos antigua
					//obtiene columnas nuevas
					foreach ($line as $name_colum => $value_column) { // recorre array (columnas ) para obtener los datos 
					 	$nueva_tabla=in_array($create_table[$name_colum], $create_table );

					 	if ($nueva_tabla) {
					 		$data_new_tbl[$name_colum][]='"'.$link->real_escape_string(trim(strtolower($value_column))).'",'; //busca el nombre de la nueva tabla 
					 	}
					}
					$rows[]=$line;
			 		
				 	$row=NULL;
				 	//$data_new_tbl=null;
				
				}
				
				foreach ($data_new_tbl as $name_tbl => $value_new_table) {
						
				 		$value_new_table = array_unique($value_new_table);  //quita duplicados
				 		$insert_new_tbl="";
				 		foreach ($value_new_table as $key => $value) {//recorre y obtiene los datos para estructurar insert masivos
							$insert_new_tbl.="(".rtrim($value,',').")";//quita última coma  (...)				 			
				 		}	
				 		
			 			$insert_new_tbl = str_replace(")(", "),(", $insert_new_tbl); //pone comas entre  cada fila

			 			$nombre_table=$create_table[$name_tbl]['table_name'];//obtiene nombre de tabla nueva
			 			$nombre_field=$create_table[$name_tbl]['field_name'];//obtiene nombre de campos de db nueva

			 			$query="INSERT INTO $name_db_new.$nombre_table ($nombre_field) VALUES $insert_new_tbl";		

			 			$result =$link->query($query);					 
			 			
						if ($result) {
							echo "Exito $nombre_table<br>";
						}else{
							echo "<br>FALLO en $nombre_table".mysqli_error($link) ;
						}
					}

					//se repite foreach para formar relaciones depues de insertadas las nuevas columnas 
					foreach ($rows as $name_colum => $value_column) { // recorre array (columnas ) para obtener los datos 
					$row=NULL;
						foreach ($value_column as $k => $v) {

							$nueva_tabla=in_array($create_table[$k], $create_table );
							if ($nueva_tabla==true) {

								$v=strtolower(trim($v));

								$tabla 	=$create_table[$k]['table_name'];
								$campo 	=$create_table[$k]['field_name'];
								$id 	=$create_table[$k]['pk_name'];

								$query="SELECT $id FROM $name_db_new.$tabla WHERE $campo ='".$v." ';";
								
								$result =$link->query($query);					 
								while ($line = mysqli_fetch_assoc($result)) { //recorre registros obtenidos de la base de datos antigua
									$v=$line[$id];//el registro deberia estar sola una vez
					 			}

					 			$row.='"'.$link->real_escape_string($v).'",'; //relacion con tabla nueva 

							}else{
								$row.='"'.$link->real_escape_string($v).'",'; //campos con data para insert
							}

							
						}
					 	$row_insert.="(".rtrim($row,',').")";//quita última coma  (...)
					}
				 	
				 	
						

				 //si se deben crear nuevas tablas
				$insert = str_replace(")(", "),(", $row_insert); //pone comas entre cada una de las filas (..),(..),(...)

				$column_insert=str_replace($new_tbl,'',$columns_new); //obtiene columnas para el insert en la tabla 
				$column_insert=rtrim($column_insert,',');//quita última coma
				$column_insert.=",transporte_id______tra,condicion_id_______con";
				$query="INSERT INTO $name_db_new.$tabla_new ($column_insert) VALUES $insert";
				$result =$link->query($query);
				print_r($query);
				if ($result) {
					echo "Exito $tabla_new<br>";
				}else{
					echo "<br>FALLO $tabla_new".mysqli_error($link) ;
				}
				$offset=$offset+$cantidad;

			}
 


		}	
	
	}


	$tiempo_fin = microtime(true);
	echo "Tiempo empleado: " . ($tiempo_fin - $tiempo_inicio);
	echo "<br>";
	echo memory_get_peak_usage(), "\n";
	$link->query("set foreign_key_checks=1");


 /*
$sql->free();
	$link->query("use ".$name_db_new); //cambia a base de datos nueva
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


