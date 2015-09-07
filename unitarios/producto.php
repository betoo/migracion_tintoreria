<?php 
	error_reporting(E_ALL);
	/*base de datos antigua*/

    $link = mysqli_connect("localhost","root","tinto","tintoreriaCI") or die("No se pudo conectar a base de datos:  " . mysqli_error($link)); 

	/* obtiene datos */		
	
	
	/******************************
			Productos
	**********************************/

	//obtiene array associativo de medidas
	$query_unidades = 'SELECT * FROM tintoreriaCI.medidas;' or die("Error in the consult.." . mysqli_error($link)); ;
	$result=$link->query($query_unidades);
	while ($row = mysqli_fetch_assoc($result)) {
		$medidas[$row['id_______med']]=strtolower($row['abreviadomed']);
	}

	$medidas=array_flip($medidas);//da vuelta array
	print_r($medidas);
	echo "<br>";
	echo "<br>";

	//obtiene array associativo de categoria
		
	$query_categoria = 'SELECT * FROM tintoreriaCI.categoria;'or die("Error in the consult.." . mysqli_error($link)); ;
	$result=$link->query($query_categoria);
	while ($row = mysqli_fetch_assoc($result)) {
		$categoria[$row['id_______cat']]=strtolower($row['abreviado']);
	}
	$categoria=array_flip($categoria);//da vuelta array

	print_r($categoria);

	echo "<br>";
	echo "<br>";
	//obtiene productos
	$query_productos_old = 'SELECT * FROM tintoreria.master_tinprod ;'or die("Error in the consult.." . mysqli_error($link));
	$result =$link->query($query_productos_old);

	while ($row = mysqli_fetch_assoc($result)) {
	    $productos_old[$row['Producto']]= $row['Descrip'];// forma array de productos

	    //si unidad de medida es vacío  intanciamos 'NULL', por el contrario obtiene id  de array unidades de medidas 
	    $unidad_medida=empty($medidas[strtolower($row['Unidad'])])? 'NULL':$medidas[strtolower($row['Unidad'])];

	    //categoria

    	if ( isset($categoria[substr(strtolower($row['Producto']), 0, 1)])) {// corta a 1 el codigo y busca coincidencias
    		$id_categoria= $categoria[  substr(strtolower($row['Producto']), 0, 1) ];
    	}else if ( isset($categoria[substr(strtolower($row['Producto']), 0, 2)])) {// corta a 2 el codigo y busca coincidencias
    		$id_categoria= $categoria[  substr(strtolower($row['Producto']), 0, 2)  ];
    	}else{
    		$id_categoria= $categoria['otros'];
    	}

	    $campos = '"'.
	    			trim(strtolower($row['Producto'])).'","'.
	    			trim(strtolower($row['Descrip'])).'",'.
	    			$unidad_medida.','.
	    			$id_categoria;

	    $values='codigo___prd,nombre___prd,medidas_id_______med,categoria_id_______cat';

	    $query_insert_prd="INSERT INTO tintoreriaCI.producto(".$values.") VALUES (".$campos.");";	
	    $link->query($query_insert_prd);
	}

	/******************************
			Productos
	**********************************/

	
 ?>



