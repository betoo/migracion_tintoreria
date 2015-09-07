
<?php 



if (!function_exists ( "insert" )) {
	
	function insert($link,$db,$tbl,$col,$data) {
		//$link->query("truncate ".$db.'.'.$tbl);
	    $sql = "INSERT INTO $db.$tbl ($col) values $data"; 
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

if (!function_exists ( "search" )) {
	
	function search($tbl,$link,$name_db_new,$where,$ids) { 

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

if (!function_exists ( "search_limit" )) {
	
	function search_limit($tbl,$link,$name_db,$offsets,$cantidad) {
		//para normalizar la la columna categoria
		//agrega a categoria
		

		$sql="SELECT * FROM $name_db.$tbl  limit $offsets,$cantidad";
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

		$sql="SELECT * FROM $name_db_old.$tbl";
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

if (!function_exists ( "row_count" )) {
	
	function row_count($tbl,$link,$name_db) {

		$sql="SELECT count(*) as total FROM $name_db.$tbl ";

		$result_search=$link->query($sql);

		$datos=[];
		while ($line = mysqli_fetch_assoc($result_search)) {
			$datos=$line['total'];
		}

		if ($datos>0) {
			return $datos;
		}else{
			return "false";
		}
	}
}