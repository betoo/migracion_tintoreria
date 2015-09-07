<?php 

	include('new.php');
	include('old.php');
	gc_enable() ;
	$link = mysqli_connect("localhost","root","tinto","tintoreria") or die("No se pudo conectar a base de datos:  " . mysqli_error($link)); 
	$tiempo_inicio = microtime(true);
	/*******************************
			obtiene de datos
	********************************/
	$all_data=[];
	//recorre bd  
	foreach ($db_old as $db => $table) {
		//recorre tablas
		foreach ($table as $key => $columns) {

			$table_name=$key;
			$count=count($columns);//para poner comas (,)
			$i=1;
			$column_name="";
			foreach ($columns as $k => $value) {
				$column_name.=" ".$k;
				if ($count != $i) {
					$column_name.=" , ";
				}
				$i++;
			}

			$query="SELECT $column_name from $table_name ";

			$result =$link->query($query);

			while ($line = mysqli_fetch_assoc($result)) {
				$all_data[$key][]=$line;
			}

			if (!$result){
				print_r("Error $table_name : <br>".mysqli_error($link));
			}else{
				echo "$table_name OK <br>";
			}


		}
	}
	
	$nombre_db="tintoreriaCI";
	foreach ($all_data as $data_tables => $data_value) {
		
		//recorre tablas
		//cambia nombres de tablas y realiza el cambio de nombre 
		if (array_key_exists($data_tables, $relations_table)) {
			$table_name=$relations_table[$data_tables];
		}else{
			$table_name=$data_tables;
		}
		$insert=null;
		foreach ($data_value as $keys => $data_columns) {
			$columns_name=null;
			$values_row=null;

			$count=count($data_columns);//para poner comas (,)
			$i=1;
			$columns="";
			foreach ($data_columns as $k => $v) {
				//setea campos
				$k=trim($k);
				$v=trim($v);
				$tbl_flip=array_flip($db_new[$nombre_db][$table_name]);
				if (array_key_exists($k, $tbl_flip)) {
					$columns=$tbl_flip[$k];
				}else{
					$columns=$k;
				}

				//
				
				$validacion_normaliza=array_key_exists($k, $tbl_flip);
				if ($validacion_normaliza) {
					$values_row.='"'.$link->real_escape_string($v).'"';	

					$columns_name.=$columns;
					if ($count != $i) {
						$columns_name.=",";
						$values_row.=",";
					}
				}
				$i++;
			}

			$columns_name=rtrim($columns_name,',');//elimina la ultima coma (,)
			$values_row=rtrim($values_row,',');//elimina la ultima coma (,)
			$insert.="(".$values_row.")";

		}
		
		$link->query("use ".$nombre_db);
		$insert = str_replace(")(", "),(", $insert);
		$query = 'INSERT INTO '.$table_name.' ( '.$columns_name.' )values  '.$insert.'  ;'or die("Error en la consulta" . mysqli_error($link));
		$result =$link->query($query);
		$query=null;
		if ("master_tinderee"==$table_name) {
			print_r($query);	
		}

		if ($result) {
			echo "EXITO";
		}else{
			print_r("FAIL".mysqli_error($link));
		}
		echo "<br>";
	}
	$tiempo_fin = microtime(true);
	echo "Tiempo empleado: " . ($tiempo_fin - $tiempo_inicio);
	echo "<br>";
	echo memory_get_peak_usage(), "\n";
	exit();
	foreach ($all_data as $key => $value) {
		foreach ($value as $k => $v) {
			print_r(COUNT($v));
			echo "<br>";
		}
	}
exit();
	$query = 'SELECT Unidad FROM tintoreria.master_tinprod ;'or die("Error en la consulta" . mysqli_error($link));
	$result =$link->query($query);
	while ($line = mysqli_fetch_assoc($result)) {
		$medidas[$line['Unidad']]=strtolower($line['Unidad']);
		$values.="('".$line['Unidad']."')";
	}

	/*******************************
		  fin obtiene de datos
	********************************/
 /*

 */

 /*
	delete from  producto;


	select count(*) from producto;
	select count(*) from master_tinderee;
	select count(*) from master_tinenree;

	delete from producto;
	delete from master_tinderee;
	delete from master_tinenree;
 */
 ?>

