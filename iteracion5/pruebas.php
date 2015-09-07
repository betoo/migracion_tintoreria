<?php 

	$link = mysqli_connect("localhost","root","tinto","tintoreria") or die("No se pudo conectar a base de datos:  " . mysqli_error($link)); 


	
	$result=$link->query("select Pi_fibra,Pi_porc1,Pi_porc2,Pi_tejido,Pi_ancho,count(*) as total from tintoreria.master_piezas group by Pi_fibra,Pi_porc1,Pi_porc2,Pi_tejido,Pi_ancho;");

	while ($line = mysqli_fetch_assoc($result)) {
		
			$asd[]=$line;
		
	} 

	if (isset($asd)) {
		print_r($asd);
		
	}

		
				

 ?>