<?php 
		$link = mysqli_connect("localhost","root","tinto","tintoreriaCI") or die("No se pudo conectar a base de datos:  " . mysqli_error($link)); 

	$query = 'SELECT * FROM tintoreriaCI.producto ;';
	$result=$link->query($query);
	if (!$result){
		printfproducto_id_______prd("Error  : \n", $mysql->sqlstate);
	}else{
		while ($line = mysqli_fetch_assoc($result)) {
			$productos[$line['id_______prd']]=strtolower(trim($line['codigo___prd']));
		}
	}



	//obtiene tipo_documento
	$query_tipo_doc = 'SELECT id_______tdo,nombre___tdo FROM tintoreriaCI.tipo_documento ;'or die("Error in the consult.." . mysqli_error($link));
	$result =$link->query($query_tipo_doc);

	while ($row = mysqli_fetch_assoc($result)) {
	    $tipo_documento[$row['id_______tdo']]= $row['nombre___tdo'];
	}
	

				/******************************
							Inicio Documento
				**********************************/

	$tipo_documento=array_flip($tipo_documento);//da vuelta array
	$productos=array_flip($productos);//da vuelta array
	print_r($productos);
	//obtiene master_tinhispr
	$columnas="Comprob,Fecha,Declara,Tipo,Producto,Cantidad,Costo,Modi";
	$query = 'SELECT '.$columnas.' FROM tintoreria.master_tinhispr GROUP BY Comprob, Producto;'or die("Error in the consult.." . mysqli_error($link));
	$result =$link->query($query);
	if (!$result){
		print_r("Error  : \n". mysqli_error($link));
	}
	$tipos=[
		'1'=>'Ingresos',
		'2'=>'Egresos',
		''=>'Receta'
	];
	$values="";
	//ingresa en tabla documentos
	while ($line = mysqli_fetch_assoc($result)) {
		$line['Producto']=trim(strtolower($line['Producto']));
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

		//categoria
    	if ( isset($categoria[substr(strtolower($row['Producto']), -1)])) {// corta a 1 el codigo y busca coincidencias
    		$id_categoria= $categoria[  substr($row['Producto'],-1) ];
    	}else if ( isset($categoria[substr($row['Producto'], -2)])) {// corta a 2 el codigo y busca coincidencias
    		$id_categoria= $categoria[  substr($row['Producto'], -2)  ];
    	}elsehv if(){
    		$id_categoria= $categoria['otros'];
    	}

		//si el producto no existe, lo ingresa
		if (empty($productos[$line["Producto"]])) {
			//ingresa
			$query_insert_prd="INSERT INTO tintoreriaCI.producto(codigo___prd) VALUES ( '". trim($line["Producto"])."');";	
			$link->query($query_insert_prd);
			$productos[$line['Producto']]= $link->insert_id;
		}

		$values.="(". $productos[strtolower($line["Producto"])] .",".  $tipo_documento[$line['Tipo']] .",".  $line['Cantidad'] .")";
	}

	$columnas="producto_id_______prd, tipo_documento_id_______tdo, cantidad_doc";
	$values = str_replace( ")(", "),(", $values );//pone coma(,) a la query 
	$query="INSERT INTO tintoreriaCI.documento ($columnas) VALUES ".$values;
	$result=$link->query($query);
	
    if (!$result){
		print_r("Error  : \n". mysqli_error($link));
	}else{

	}

?>