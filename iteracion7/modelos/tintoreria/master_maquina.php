<?php  

require_once "modelos/modelo.php"; 

class master_maquina extends Modelo 
{   
    public $Maquina;
    public $Nombre;
    public $Capacidad;
    public $Hora;
    public $Minutos;
    public $Jornada;
    public $Dispon;

    public function __construct() 
    { 
        parent::__construct(); 
    } 

    public function table() {
        return "master_maquina";
    }

    public function get_master_maquina() { 
        return $this->search_limit($this->table(),2,"tintoreria");
        
    } 




} 
  ?> 