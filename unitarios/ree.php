<?php 
	$link = mysqli_connect("localhost","root","tinto","tintoreriaCI") or die("No se pudo conectar a base de datos:  " . mysqli_error($link)); 

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

	//obtiene array associativo de categoria	
	$query_categoria = 'SELECT * FROM tintoreriaCI.categoria;'or die("Error en la consulta 'query_categoria'" . mysqli_error($link)); ;
	$result=$link->query($query_categoria);
	while ($row = mysqli_fetch_assoc($result)) {
		$categoria[$row['id_______cat']]=strtolower($row['abreviado']);
	}
	$categoria=array_flip($categoria);//da vuelta array
	//print_r($categoria);

	//obtiene productos
	$query = 'SELECT * FROM tintoreria.master_tinprod ;'or die("Error en la consulta" . mysqli_error($link));
	$result =$link->query($query);

	$campos='codigo___prd,nombre___prd,medidas_id_______med,categoria_id_______cat';
	$values="";
	$i=1;$total = mysqli_num_rows($result);

	while ($row = mysqli_fetch_assoc($result)) {

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
    	
	    $values.= '("'.
	    			trim(strtolower($row['Producto'])).'","'.
	    			trim(strtolower($row['Descrip'])).'",'.
	    			$unidad_medida.','.
	    			$id_categoria.")";

		if ($total>$i) {
			$values.=',';
		}
		$i++;



	    //$productos[$row['Producto']]= $link->insert_id;// forma array de productos, es utilizado para normalizar las tablas de receta
	}

    $query="INSERT INTO tintoreriaCI.producto(".$campos.") VALUES ".$values." ;";
	$result=$link->query($query);
	if (!$result){
		printf("Error  : <br>", $link->sqlstate);
	}else{
		echo "Productos OK <br>";
	}

	/******************************
			Productos
	**********************************/


	/******************************
			Receta Específica 
	**********************************/
				/******************************
							Encabezado
						 (master_tinenree)
				**********************************/
 
	$query = 'SELECT * FROM tintoreriaCI.producto ;';
	$result=$link->query($query);
	if (!$result){
		printf("Error  : \n", $mysql->sqlstate);
	}else{
		while ($line = mysqli_fetch_assoc($result)) {
			$productos[$line['id_______prd']]=$line['codigo___prd'];
		}
	}

	$query = 'SELECT * FROM tintoreria.master_tinenree ;';
	$result=$link->query($query);
	$total = mysqli_num_rows($result);
	//manejo de errores 
	if (!$result){
		printf("Error  : \n", $mysql->sqlstate);
	}

	$campos='Recetacor,Clasific,Kg1fib,Kg2fib,Descrip,Fecha,Costotot,Hora,Litros,Reproceso,Clarepro,Unialt,Reccli';
	$values="";
	$i=1;
	while ($line = mysqli_fetch_assoc($result)) {

		$values.= 	"('".
					$link->real_escape_string($line['Recetacor'])."','".
					$link->real_escape_string($line['Clasific'])."','".
					$link->real_escape_string($line['Kg1fib'])."','".
					$link->real_escape_string($line['Kg2fib'])."','".
					$link->real_escape_string($line['Descrip'])."','".
					$link->real_escape_string($line['Fecha'])."',".
					$link->real_escape_string($line['Costotot']).",'".
					$link->real_escape_string($line['Hora'])."','".
					$link->real_escape_string($line['Litros'])."','".
					$link->real_escape_string($line['Reproceso'])."','".
					$link->real_escape_string($line['Clarepro'])."','".
					$link->real_escape_string($line['Unialt'])."','".
					$link->real_escape_string($line['Reccli'])."')";

		if ($total>$i) {
			$values.=',';
		}
		$i++;
	}

	$query = "insert into  master_tinenree (".$campos.") values ".$values." ;";
	$result=$link->query($query);
	if (!$result){
		printf("<br>Error  : \n", $link->sqlstate);
	}else{
		echo "master_tinenree OK <br>";
	}




				/******************************
						 Fin Encabezado
						(master_tinenree)
				**********************************/
				/******************************
							Detalle
						(master_tinderee)
				**********************************/
	








	$campos='Recetacor , Producto ,Linea1 ,Cantidad,Incidencia, Comentario,Costo';
	$query = 'SELECT '.$campos.' FROM tintoreria.master_tinderee limit 800000; ';
	$result=$link->query($query);
	$total = mysqli_num_rows($result);
	$values="";
	while ($line = mysqli_fetch_assoc($result)) {
		//busca productos
		$prd=$productos[$line['Producto']];//genera error !! por que no existe, iguanmente agregar producto
		//si esta vacío, lo inserta
		if(isset($prd)){
			
			//$values_producto = str_replace(")(", "),(", $values_producto);
			
			$query_insert_prd="INSERT INTO tintoreriaCI.producto(codigo___prd) VALUES (". $line['Producto'] .");"or die("Error en la consulta " . mysqli_error($link));	
			//manejo de errores 
			if (!$link->query($query_insert_prd)){
				print_r("producto Error :  \n".mysqli_error($link));
			}else{
				$productos[$line['Producto']]= $link->insert_id;//agrega al array productos
			}
		}

		$values_producto="( '". trim(strtolower($line['Producto']))."')";

		$values.= '("'.$link->real_escape_string(trim(strtolower($line['Recetacor']))).'","'.
					$link->real_escape_string($prd).'",'.
					$link->real_escape_string(trim(strtolower($line['Linea1']))).',"'.
					$link->real_escape_string(trim(strtolower($line['Cantidad']))).'","'.
					$link->real_escape_string(trim(strtolower($line['Incidencia']))).'","'.
					$link->real_escape_string(trim(strtolower($line['Comentario']))).'",'.
					$link->real_escape_string(trim(strtolower($line['Costo']))).")";
	}

	if(empty($values_producto)){
		
		$values_producto = str_replace(")(", "),(", $values_producto);
		$query_insert_prd="INSERT INTO tintoreriaCI.producto(codigo___prd) VALUES ". $values_producto .";"or die("Error en la consulta " . mysqli_error($link));	
		echo "asd";
		//manejo de errores 
		if (!$link->query($query_insert_prd)){
			echo "asd";
			print_r("producto Error :  \n".mysqli_error($link));
		}else{
			$productos[$line['Producto']]= $link->insert_id;//agrega al array productos
		}
	}



	$values = str_replace( ")(", "),(", $values );//pone comas(,) a la query 
	$query = "insert into  tintoreriaCI.master_tinderee (".$campos.") values ".$values.";"or die("Error en la consulta " . mysqli_error($link));
	$result=$link->query($query);
	if (!$result){
		print_r("master_tinderes Error   : \n".mysqli_error($link));
	}else{
		echo "master_tinderes OK \n";

	}


 


				/******************************
							Fin Detalle
						(master_tinderee)
				**********************************/



	




/*

 delete from producto;
 delete from master_tinderee;
 delete from master_tinenree;

 select count(*) from producto;
 select count(*) from tintoreria.master_tinenree;
 select count(*) from tintoreriaCI.master_tinenree;
 select count(*) from tintoreria.master_tinderee;
 select count(*) from tintoreriaCI.master_tinderee;

*/
 ?>
