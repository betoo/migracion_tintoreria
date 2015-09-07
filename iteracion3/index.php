<?php 
if(function_exists('xdebug_disable')) { xdebug_disable(); }

	include('new.php');
	include('old.php');
	gc_enable() ;
	$link = mysqli_connect("localhost","root","tinto","tintoreria") or die("No se pudo conectar a base de datos:  " . mysqli_error($link)); 
	$link->query("set foreign_key_checks=0");

	$tiempo_inicio = microtime(true);	
	/*******************************
			obtiene de datos
	********************************/
	$tiempo_inicio = microtime(true);
	$name_db_new=array_keys($db_new); //obtiene nombre db
	$name_db_new=$name_db_new[0]; // nombre db

	$name_db_old=array_keys($db_old); //obtiene nombre db
	$name_db_old=$name_db_old[0]; // nombre db

	//recorre bd  
	foreach ($db_old as $db => $table) { //nombre db = > array la tabla
		//recorre tablas
		foreach ($table as $table_name => $columns) {  // nombre de tabla => nombre de columnas 
			
			$columns=array_filter($columns); //filtra y obtiene nombres de columnas que hacen relacion con la nueva db
			$new_table['num_consultas']=$columns['num_consultas']; //establece numero de consultas que se realizaran en la base de datos (insert)
			$new_table['new_table']=$columns['new_table'];

			$link->query("truncate $name_db_new.".$new_table['new_table']); //elimina tablas
			

			//si se crea una nueva variale en array de db y no es utilizada para el insert  se elimina (el array se ocupa para formar estructura de insert)
			unset($columns['num_consultas']);//quita del array 
			unset($columns['new_table']);//quita del array  

			$columns_old=NULL;
			$columns_new=NULL;

			


			foreach ($columns as $column_old => $column_new) {

				//AGREGANDO NUEVAS TABLAS (cuando se crea una tabla a partir de un campo)
				if (is_array($column_new)) {//ingresa registros a  nuevas tablas 

					$new_table[$column_old]['pk_name']=$columns[$column_old]['pk_name'];
					$new_table[$column_old]['table_name']=$columns[$column_old]['table_name'];
					$new_table[$column_old]['field_name']=$columns[$column_old]['field_name'];

					$columns_old.=$column_old.",";
					$columns_new.=$columns[$column_old]['fk_name'].",";

					//obtiene total de registros					
					$result =$link->query("SELECT count(DISTINCT $column_old) as total from $table_name ");//obtiene total de registros

					while ($line = mysqli_fetch_assoc($result)) {
						$total_registros_new_table=$line['total'];
					} 

					$cantidad_new_table=ceil($total_registros_new_table/$column_new['num_consultas']);//cantidad de registros a insertar en una query (para nueva tabla)


					$offset =0;				
					for ($i=0; $i < $column_new['num_consultas'] ; $i++) { 
						$rows 	=NULL;

						$result =$link->query("SELECT DISTINCT $column_old  FROM $table_name limit $offset,$cantidad_new_table");//obtiene registro para latabla nueva (elimna duplicados)

						while ($line = mysqli_fetch_assoc($result)) {

							$rows.='("'.$link->real_escape_string(trim($line[$column_old])).'")';//grenera estructura para insert 

						} 

						$rows = str_replace(")(", "),(", $rows); //pone comas en cada fila
						$new_field_name=$column_new['field_name'];
						$new_table_name=$column_new['table_name'];
						$result =$link->query("INSERT INTO $name_db_new.$new_table_name ( $new_field_name ) VALUES $rows");

						if ($result) {
							echo "<br>Exito $new_table_name";
						}else{
							echo "<br>Error $new_table_name".mysqli_error($link) ;;
						}
						$offset=$offset+$cantidad_new_table;//paginador de registros
						
					}
				}else{
					$columns_old.=$column_old.",";
					$columns_new.=$column_new.",";
				}

			}
				$columns_old=rtrim($columns_old,',');//quita última coma (,)
				$columns_new=rtrim($columns_new,',');


			//obtiene total de registros					
			$result =$link->query("SELECT count($column_old) as total from $table_name ");//obtiene total de registros

			while ($line = mysqli_fetch_assoc($result)) {
				$total_registros=$line['total'];
			} 
			$cantidad=ceil($total_registros/$new_table['num_consultas']);//cantidad de registros a insertar en una query (para nueva tabla)
			$offsets =0;		

			for ($i=0; $i < $new_table['num_consultas'] ; $i++) { 
				
				$result =$link->query("SELECT  $columns_old FROM $table_name limit $offsets,$cantidad");//obtiene registro para latabla nueva (elimna duplicados)

				$insert 	=NULL;
				while ($line = mysqli_fetch_assoc($result)) {
					foreach ($line as $key => $val) {
						if (isset($new_table[$key])) {

							$val=trim($val);

							$new_table[$column_old]['pk_name']=$columns[$column_old]['pk_name'];
							$new_table[$column_old]['table_name']=$columns[$column_old]['table_name'];	

							$id=$new_table[$key]['pk_name'];
							$new_table_name=$new_table[$key]['table_name'];
							$new_field_name=$new_table[$key]['field_name'];


							$result_relations =$link->query("SELECT  $id FROM $name_db_new.$new_table_name where $new_field_name='$val'");//obtiene registro para latabla nueva (elimna duplicados)			
							while ($row_relations= mysqli_fetch_assoc($result_relations)) {
								$val=$row_relations[$id];
							}

							$row.="'".$link->real_escape_string($val)."',";

						}else{
							$row.="'".$link->real_escape_string($val)."',";
						}
						
					}
					$row=rtrim($row,',');
					$insert.='('.$row.')';//grenera estructura para insert 
					
					$row=NULL;
				} 				
				$insert=rtrim($insert,',');
				$insert = str_replace(")(", "),(", $insert); //pone comas en cada fila

				$table=$new_table['new_table'];
				//printf("INSERT INTO $name_db_new.$table ( $columns_new ) VALUES $insert");
				//echo "<br>\n"; 
				if ($result) {
				$result =$link->query("INSERT INTO $name_db_new.$table ( $columns_new ) VALUES $insert");
					echo "<br>Exito $table ";
				}else{
					echo "<br>Error $table".mysqli_error($link) ;
				}
				$offsets=$offsets+$cantidad;//paginador de registros
				$sql->free();
			} 
		}		


	}

	$tiempo_fin = microtime(true);
	echo "<br>Tiempo empleado: " . ($tiempo_fin - $tiempo_inicio);
	echo "<br>Memory Peak Usage: ";
	echo memory_get_peak_usage(), "\n";
	$link->query("set foreign_key_checks=1");

	$link->close();


 /*
$sql->free();
	$link->query("use ".$name_db_new); //cambia a base de datos nueva
    $mysqli_connection->close();
 */
 ?>