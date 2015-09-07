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


				if (isset($column_new['meta_data_new_table'])) {//ingresa registros a  nuevas tablas 
					
					//obtiene metadatos  para posterior insert
					$new_table[$column_old]['pk_name']=$column_new['meta_data_new_table']['pk_name'];
					$new_table[$column_old]['table_name']=$column_new['meta_data_new_table']['table_name'];
					$new_table[$column_old]['field_name']=$column_new['meta_data_new_table']['field_name'];

					$columns_old.=$column_old.",";
					$columns_new.=$columns[$column_old]['meta_data_new_table']['fk_name'].",";

					$link->query("truncate $name_db_new.".$new_table[$column_old]['table_name']); //elimina tablas

					//obtiene total de registros					
					$result =$link->query("SELECT count(DISTINCT $column_old) as total from $table_name ");//obtiene total de registros

					while ($line = mysqli_fetch_assoc($result)) {
						$total_registros_new_table=$line['total'];
					} 

					$cantidad_new_table=ceil($total_registros_new_table/$column_new['meta_data_new_table']['num_consultas']);//cantidad de registros a insertar en una query (para nueva tabla)
					
					$offset =0;				
					for ($i=0; $i < $column_new['meta_data_new_table']['num_consultas'] ; $i++) { 
						$rows 	=NULL;

						$result =$link->query("SELECT DISTINCT $column_old  FROM $name_db_old.$table_name limit $offset,$cantidad_new_table");//obtiene registro para latabla nueva (elimna duplicados)

						while ($line = mysqli_fetch_assoc($result)) {
							$row=ucfirst(strtolower(trim($line[$column_old]))); //quita espacio y convierte a capital
							$rows.='("'.$link->real_escape_string($row).'")';//grenera estructura para insert 

						} 
						$rows = str_replace(")(", "),(", $rows); //pone comas en cada fila
						$new_field_name=$column_new['meta_data_new_table']['field_name'];
						$new_table_name=$column_new['meta_data_new_table']['table_name'];
						$result =$link->query("INSERT INTO $name_db_new.$new_table_name ( $new_field_name ) VALUES $rows");

						if ($result) {
							echo "<br>Exito $new_table_name";
						}else{
							echo "<br>Error $new_table_name".mysqli_error($link) ;;
						}
						$offset=$offset+$cantidad_new_table;//paginador de registros
						
					}
				}else if (isset($column_new['relations'])) { 

					$columns_old.=$column_old.",";
					$columns_new.=$columns[$column_old]['relations']['fk_name'].",";
				}else{

					$columns_old.=$column_old.",";
					$columns_new.=$column_new.",";
				}

			}
			$columns_old=rtrim($columns_old,',');//quita última coma (,)
			$columns_new=rtrim($columns_new,',');
			$row=null;

			//obtiene total de registros					
			$result =$link->query("SELECT count($column_old) as total from $table_name ");//obtiene total de registros

			while ($line = mysqli_fetch_assoc($result)) {
				$total_registros=$line['total'];
			} 
			if ($table_name=="master_tinderes") {
				//$total_registros=300;
			}
			$cantidad=ceil($total_registros/$new_table['num_consultas']);//cantidad de registros a insertar en una query (para nueva tabla)
			$offsets =0;		

			for ($i=0; $i < $new_table['num_consultas'] ; $i++) { 

				$result =$link->query("SELECT  $columns_old FROM $table_name limit $offsets,$cantidad");//obtiene registro para latabla nueva (elimna duplicados)
				
				$insert 	=NULL;
							
				while ($line = mysqli_fetch_assoc($result)) {
					foreach ($line as $key => $val) { 

						$val=ucfirst(strtolower(trim($val))); //quita espacio y ls letra en modificada a capital


						if (is_array($columns[$key])) { //GENERANDO RELACIONES

							if (isset($columns[$key]['meta_data_new_table'])) { // relacion entre tablas nuevas  

								$pk_name	=$columns[$key]['meta_data_new_table']['pk_name'];
								$field_name	=$columns[$key]['meta_data_new_table']['field_name'];
								$name_table	=$columns[$key]['meta_data_new_table']['table_name'];

							}elseif (isset($columns[$key]['relations'])) { // relación  entre tablas 

								$pk_name			=$columns[$key]['relations']['pk_name'];
								$field_name			=$columns[$key]['relations']['field_name'];
								$name_table			=$columns[$key]['relations']['table_name'];
								$insert_if_not_exist=$columns[$key]['relations']['insert_if_not_exist'];
								$not_in				=in_array($val,$columns[$key]['relations']['not_in']);
								

							}

							$result_relations =$link->query("SELECT  $pk_name FROM $name_db_new.$name_table where $field_name='$val'");//obtiene registro para latabla nueva (elimna duplicados)			
							
							if ($result_relations->num_rows>0) { //encuentra registro y cambia por id 

								$new_val=null;
								while ($row_relations= mysqli_fetch_assoc($result_relations)) {

										$new_val=$row_relations[$pk_name];

								}

								$row.="'".$link->real_escape_string($new_val)."',";
								
							}elseif($insert_if_not_exist==true and $not_in==false){ //agrega registro y cambia id

								$result_new_row =$link->query("INSERT INTO  $name_db_new.$name_table ( $field_name ) VALUES ('$val' )");
								$row.="'".$link->real_escape_string($link->insert_id)."',";
							}else{
								$row.="'',";//al no encontrar datos para relacion queda nulo
								//$row.="'".$val."',";
							}


						}else{
							$row.="'".$link->real_escape_string($val)."',"; //columnas que se transfieren campo a campo
						}
						
					}
					$row=rtrim($row,',');
					$insert.='('.$row.')';//grenera estructura para insert 
					
					$row=NULL;
				} 				
				$insert=rtrim($insert,',');
				$insert = str_replace(")(", "),(", $insert); //pone comas en cada fila

				$table=$new_table['new_table'];

				if ($table_name=="master_tinderes") {
					//print_r("INSERT INTO $name_db_new.$table ( $columns_new ) VALUES $insert");
				}

				$result =$link->query("INSERT INTO $name_db_new.$table ( $columns_new ) VALUES $insert");
				if ($result) {
					echo "<br>Exito $name_db_new.$table ";
				}else{
					echo "<br>Error $table".mysqli_error($link) ;
				}
				$offsets=$offsets+$cantidad;//paginador de registros

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
