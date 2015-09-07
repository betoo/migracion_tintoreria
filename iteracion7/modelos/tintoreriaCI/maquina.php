<?php  

require_once "modelos/modelo.php"; 

class Maquina extends Modelo 
{   
    public $id_______maq ; 
    public $nombre___maq ; 
    public $capacidadmaq ; 
    public $descripcimaq ; 
    public $medidas_id_______med ; 
    public $user_accounts_uacc_id ;
    public $Maquina;


    public function __construct() 
    { 
        parent::__construct(); 
    } 

    public function table() {
        return "maquinaria";
    }

    public function equivalencia_columnas() {
        $columns=[
            'Nombre'    => 'nombre___maq',
            'Capacidad' => 'capacidadmaq',
            'Hora'      => null,
            'Minutos'   => null,
            'Jornada'   => null,
            'Dispon'    => null,
            'Maquina'   => 'Maquina'  
        ];
        $columns=array_filter($columns);
        return $columns;
    }

    public function get_maquina() { 

        return $this->search_limit($this->table(),20,$this->db_old);
        
    }   
    
    public function truncate() { 
        $this->_db->query("set foreign_key_checks=0");

        $query='truncate '.$this->db_new().'.'.$this->table();
        $result=$this->_db->query($query);

        if ($result) {
            echo "<br>Tabla eliminada ".$this->table();
            return true;
        }else{
            echo "<br>No se pudo eliminar ".$this->table().'  '.$this->_db->connect_error;
            return false;
        }

    }   

    public function agrega() { 
        $columns=$this->get_columns();

        $num_querys=1;
        $cantidad=ceil($this->row_count("master_maquina","tintoreria")/$num_querys);
        $offsets=0;

        for ($i=0; $i < $num_querys; $i++) { 

            $datos=$this->search_limit_normaliza("master_maquina","tintoreria",$columns['columns_old'],$offsets,$cantidad);
            if (isset($datos)) {
                $this->masive_insert("tintoreriaCI","maquinaria",$datos,$columns['columns_new']);
            }
            $offsets=$offsets+$cantidad;

        }        
        
    } 



} 
  ?> 
