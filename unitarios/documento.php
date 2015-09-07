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
	//print_r($medidas);
	echo "<br>";
	echo "<br>";

	//obtiene array associativo de categoria
		
	$query_categoria = 'SELECT * FROM tintoreriaCI.categoria;'or die("Error in the consult.." . mysqli_error($link)); ;
	$result=$link->query($query_categoria);
	while ($row = mysqli_fetch_assoc($result)) {
		$categoria[$row['id_______cat']]=strtolower($row['abreviado']);
	}
	$categoria=array_flip($categoria);//da vuelta array

	//print_r($categoria);

	echo "<br>";
	echo "<br>";
	//obtiene productos
	/*
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
	    			strtolower($row['Producto']).'","'.
	    			strtolower($row['Descrip']).'",'.
	    			$unidad_medida.','.
	    			$id_categoria;

	    //
	    $values='codigo___prd,nombre___prd,medidas_id_______med,categoria_id_______cat';

	    $query_insert_prd="INSERT INTO tintoreriaCI.producto(".$values.") VALUES (".$campos.");";	
	    //print_r($query_insert_prd);
	    //echo "<br>";
	    $link->query($query_insert_prd);
	    //$insert =mysqli_query($query_insert_prd) or die('Consulta  "query_insert_prd" fallida: ' . mysqli_error());
	}
*/
	/******************************
			Productos
	**********************************/


	//obtiene productos
	$query_producto = 'SELECT * FROM tintoreriaCI.producto;' or die("Error in the consult.." . mysqli_error($link));
	$result =$link->query($query_producto);
	while ($row = mysqli_fetch_assoc($result)) {
	    $productos[$row['id_______prd']]= $row['nombre___prd'];
	}
	//obtiene tipo_documento
	$query_tipo_doc = 'SELECT id_______tdo,nombre___tdo FROM tintoreriaCI.tipo_documento ;'or die("Error in the consult.." . mysqli_error($link));
	$result =$link->query($query_tipo_doc);

	while ($row = mysqli_fetch_assoc($result)) {
	    $tipo_documento[$row['id_______tdo']]= $row['nombre___tdo'];
	}
	



	



	$tipo_documento=array_flip($tipo_documento);//da vuelta array
	$productos=array_flip($productos);//da vuelta array

	//obtiene master_tinhispr
	$query_historia = 'SELECT * FROM master_tinhispr GROUP BY Comprob, Producto limit 0,10;'or die("Error in the consult.." . mysqli_error($link));
	$result =$link->query($query_historia);
	
	$tipos=[
		'1'=>'Ingresos',
		'2'=>'Egresos',
		''=>'Receta'
	];
	//ingresa en tabla documentos
	while ($line = mysqli_fetch_assoc($result)) {

		switch (trim($line['Tipo'])) {
			case 1:
				$line['Tipo']='Ingresos';
				//ingresos				
				break;
			case 2:
				//egresos
				$line['Tipo']='Egresos';
				break;
			case NULL:
				//Receta
				$line['Tipo']='Receta';
				break;
		}
		//si el producto no existe, lo ingresa
		$borrar=$productos;
		$line["Producto"]="11";
		if (empty($productos[$line["Producto"]])) {
			//ingresa
			$query_insert_prd="INSERT INTO tintoreriaCI.producto(codigo___prd) VALUES ( '". trim($line["Producto"])."');";	
			$link->query($query_insert_prd);
			print_r($productos[$row['nombre___prd']]= $link->insert_id);
		}
		echo "-->";
		$productos['asdasd']='asd';
		$asd=array_diff($borrar,$productos);
		print_r($asd);
		exit();

		$columnas="producto_id_______prd, tipo_documento_id_______tdo, cantidad_doc";
		$query_documento="INSERT INTO tintoreriaCI.documento ($columnas) VALUES (". $productos[$line["Producto"]] .",".  $tipo_documento[$line['Tipo']] .",".  $line['Cantidad'] .")";
		$link->query($query_documento);
		
	    if (!$result) {
		    die('Error al ingresar Documentos  : ' . mysqli_error());
		}else{
			//print_r($query_documento);
			echo "<br>";
		}
		
	}
	print_r($productos);
	

/*
	
	echo "<br>";
		print_r($productos[$line["Producto"]].'               '.$line["Producto"]);
		echo "<br>";


	id_______doc 			-> 
	comprobandoc			-> Comprob
	producto_id_______prd 	-> Producto
	Declara 				-> fecha facturacion
	Tipo 					-> *
	cantidad_doc			-> Cantidad

+-----------------------------+---------+------+-----+---------+----------------+
| Field                       | Type    | Null | Key | Default | Extra          |
+-----------------------------+---------+------+-----+---------+----------------+
| id_______doc                | int(11) | NO   | PRI | NULL    | auto_increment |
| producto_id_______prd       | int(11) | YES  | MUL | NULL    |                |
| proveedor_id_______pro      | int(11) | YES  | MUL | NULL    |                |
| factura_id_______fac        | int(11) | YES  | MUL | NULL    |                |
| bodega_id_______bod         | int(11) | YES  | MUL | NULL    |                |
| tipo_documento_id_______tdo | int(11) | YES  | MUL | NULL    |                |
| precio___doc                | double  | NO   |     | NULL    |                |
| cantidad_doc                | double  | YES  |     | NULL    |                |
| guia_id_______gui           | int(11) | YES  | MUL | NULL    |                |
| piezas_id_______pza         | int(11) | YES  | MUL | NULL    |                |
+-----------------------------+---------+------+-----+---------+----------------+


+----------+---------------+------+-----+---------+-------+
| Field    | Type          | Null | Key | Default | Extra |
+----------+---------------+------+-----+---------+-------+
| Comprob  | varchar(10)   | NO   |     | NULL    |       |
| Fecha    | date          | NO   |     | NULL    |       |
| Declara  | date          | NO   |     | NULL    |       |
| Tipo     | char(1)       | NO   |     | NULL    |       |
| Producto | varchar(10)   | NO   |     | NULL    |       |
| Cantidad | decimal(10,3) | NO   |     | NULL    |       |
| Costo    | decimal(9,2)  | NO   |     | NULL    |       |
| Modi     | char(1)       | NO   |     | NULL    |       |
+----------+---------------+------+-----+---------+-------+


*/
 ?>




