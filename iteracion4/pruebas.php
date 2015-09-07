<?php 

	$link = mysqli_connect("localhost","root","tinto","tintoreria") or die("No se pudo conectar a base de datos:  " . mysqli_error($link)); 


	
	$result=$link->query("SELECT DISTINCT Comprob FROM  `master_tinhispr`  ORDER BY  `master_tinhispr`.`Comprob`;");

	while ($line = mysqli_fetch_assoc($result)) {
		
		print_r($line['Comprob']."\n\r");
		
	} 

		
				

 ?>