 <?php   
 	
    
 	require_once "modelos/tintoreriaCI/maquina.php"; 
 	require_once "modelos/tintoreriaCI/mantencion.php"; 

 	require_once "modelos/tintoreria/master_maquina.php"; 

 	
    $maquina = new maquina(); 
    $maquina->truncate();
    $maquina = $maquina->agrega();
 	


    $mantencion = new Mantencion(); 
    $mantencion = $mantencion->agregar();


    //$master_maquina = new master_maquina(); 
    //$master_maquina = $master_maquina->get_master_maquina(); 
    
    print_r($mantencion);
?> 