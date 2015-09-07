
<?php 

include('new.php');

if (!function_exists ( "insert" )) {
	
	function insert($link,$db,$tbl,$col,$data) {
		//$link->query("truncate ".$db.'.'.$tbl);
	    $sql = "INSERT INTO $db.$tbl ($col) values $data"; 
	    print_r($sql);
	    $result_insert=$link->query($sql);

	    if ($result_insert) {
	    	echo "<br>Exito $tbl";
	    	return true;
	    }else{
	    	echo "<br>Fallo".mysqli_error($link);
	    	return false;
	    }
	}
}


if (!function_exists ( "add" )) {
	
	function add($new_data,$key,$link,$name_db_new) {
		//para normalizar la la columna categoria
		//agrega a categoria
		$tbl=$new_data[$key]['new_table'];
		unset($new_data[$key]['new_table']);
		$insert_values="";
		foreach ($new_data[$key]as $k => $v) {//foeeach tablas

			$values="";
			$col="";
			foreach ($v as $name_cols => $value_col) {//foeeach columnas
				$col.=$name_cols.",";
				$values.="'".$value_col."',";
			}
			$values=rtrim($values,",");
			$insert_values.="(".$values."),";


		}

		$insert_values= rtrim($insert_values,",");
		$col = rtrim($col,",");
		return  insert($link,$name_db_new,$tbl,$col,$insert_values);
	}
}

if (!function_exists ( "search" )) {
	
	function search($tbl,$link,$name_db_new,$where,$ids) {
		//para normalizar la la columna categoria
		//agrega a categoria
		

		$sql="SELECT $ids FROM $name_db_new.$tbl  where $where";
		$result_search=$link->query($sql);
		$datos=[];
		while ($line = mysqli_fetch_assoc($result_search)) {
			$datos[]=$line;
		}

		if ($datos>0) {
			return $datos;
		}else{
			return false;
		}
	}
}

if (!function_exists ( "search_all" )) {
	
	function search_all($tbl,$link,$name_db_old) {
		//para normalizar la la columna categoria
		//agrega a categoria

		$sql="SELECT * FROM $name_db_old.$tbl limit 10";
		$result_search=$link->query($sql);

		$datos=[];
		while ($line = mysqli_fetch_assoc($result_search)) {
			$datos[]=$line;
		}

		if ($datos>0) {
			return $datos;
		}else{
			return "false";
		}
	}
}


if (!function_exists ( "add_document" )) {
	
	function add_document($tbl,$link,$name_db_new,$name_db_old,$meta_data_tbl) {
		//para normalizar la la columna categoria
		
		$data=search_all($tbl,$link,$name_db_old);
		$meta_data_tbl=array_filter($meta_data_tbl);

		unset($meta_data_tbl['is_document']);
		unset($meta_data_tbl['num_consultas']);

		//obtiene columnas
		$columnas_new =NULL;
		$columnas_old =NULL;

		foreach ($meta_data_tbl as $key => $value) {
			$columnas_old.=$key.",";
			$columnas_new.=$value.",";
			$fields_for_insert[]=$key;
		}
		$columnas_old=rtrim($columnas_old,",");
		$columnas_new=rtrim($columnas_new,",");
		$rows="";
		foreach ($data as $keys => $fila) {
			$row=null;
			foreach ($fila as $cols => $va) {
				$isset=in_array($cols, $fields_for_insert);

				if ($isset) {

					//normaliza datos para tabla 
					if ($cols=="Producto") {

						$tbl 	='producto';
						$where 	="codigo___prd='Aaro10b'";
						$ids 	='id_______prd';

						$new_value=search($tbl,$link,$name_db_new,$where,$ids); //busca categorias

						if (isset($new_value[0][$ids])) {
							$va=$new_value[0][$ids];
						}else{
							$va=0; //si no lo encuentra, cambia el valor por cero
						}
					}
					$row.="'".trim($va)."',";
				}
			}
			$row=rtrim($row,',');
			$rows.="(". $row ."),";
			
		}
		$rows=rtrim($rows,',');
		$tbl='documento';
		print_r(insert($link,$name_db_new,$tbl,$columnas_new,$rows));
	}
}




//es realizado para normalizar el campo categorias
if ($table_name=='master_tinprod' and $key=='Producto') {
	if (!isset($insert_cat) or  $insert_cat==false) {
		$insert_cat=add($new_data,$key,$link,$name_db_new); //agrega categorias

		$modify_columns_new=explode(',', $columns_new);//ordena las columnas para almacenar el registro 
		$modify_columns_new[3]=$modify_columns_new[2];
		$modify_columns_new[2]=$modify_columns_new[1];
		$modify_columns_new[1]='categoria_id_______cat';
		$columns_new=implode(',', $modify_columns_new);
	}

	
	$cut=strtoupper(substr( $val, 0, 1));//corta el campo Producto a 1 caracter 

	$tbl 	=$new_data[$key]['new_table'];
	$where 	="abreviado='$cut'";
	$ids 	='id_______cat';

	$categoria=search($tbl,$key,$link,$name_db_new,$where,$ids); //busca categorias

	if ($categoria==false) { //si no hay coincidencias, prueba cortando el campo Producto a 2 caracteres 

		$cut=strtoupper(substr( $val, 0, 2));//corta el campo Producto a 1 caracter 
		$where 	="abreviado='$cut'";
		$categoria=search($tbl,$key,$link,$name_db_new,$where,$ids); //busca categorias		
	} 

	if ($categoria==false){//si no hay coincidencias, le asigna "otros"
		
		$where 	="abreviado='otros'";
		$categoria=search($tbl,$key,$link,$name_db_new,$where,$ids); //busca categorias		
	}

	$row="'$val','".$categoria[0][$ids]."',";
}




if ($table_name=='master_tinhispra' and $key=='Producto') {
	
	if (!isset($insert_cat) or  $insert_cat==false) {
		$insert_cat=add($new_data,$key,$link,$name_db_new); //agrega categorias

		$modify_columns_new=explode(',', $columns_new);//ordena las columnas para almacenar el registro 
		$modify_columns_new[3]=$modify_columns_new[2];
		$modify_columns_new[2]=$modify_columns_new[1];
		$modify_columns_new[1]='categoria_id_______cat';
		$columns_new=implode(',', $modify_columns_new);
	}

	$tbl 	='producto';
	$where 	="codigo___prd='$val'";
	$ids 	='id_______prd';


	$search_prd=search($tbl,$key,$link,$name_db_new,$where,$ids); //busca categorias

	if (empty($search_prd)) {
		
	}

	$row="'".$search_prd[0][$ids]."',";
}

 ?>
