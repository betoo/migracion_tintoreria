<?php  

require_once "modelos/modelo.php"; 

class Mantencion extends Modelo 
{   
    var $id;
    var $descripcion;
    var $materiales;
    var $fecha;
    var $operador;
    var $tipo;
    var $maquina;
    


    public function __construct() 
    { 
        parent::__construct(); 
    } 

    public function table() {
        return "mantencion_maquinaria";
    }

    public function equivalencia_columnas() {
        $columns=[
        
            //'id'            => 'id_______mam',
            'descripcion'   => 'observacimam',
            'materiales'    => 'insumos_id_______ins',
            'fecha'         => 'fecha____mam',
            'operador'      => 'user_accounts_uacc_id',
            'tipo'          => 'tipo_mantencion_id_______tma',
            'Maquina'       => "maquinaria_id_______maq",
        ];
        $columns=array_filter($columns);
        return $columns;
    }

    public function truncate() { 
        $query='truncate '.$this->db_old().'.'.$this->table();
        $result=$this->_db->query($query);

        if ($result) {
            echo "<br>Tabla eliminada ".$this->table();
            return true;
        }else{
            echo "<br>No se pudo eliminar ".$this->table().'  '.$this->_db->connect_error;
            return false;
        }

    }   

    public function get_mantencion() { 
        return $this->search_limit($this->table(),20,"tintoreriaCI");
    } 

    public function agregar() { 

        $columns=$this->get_columns();

        $relations_columns=[
                            'maquina'=>[
                                    'tabla'     => 'maquinaria',
                                    'id'        =>'id_______maq',
                                    'nombre'    => 'Maquina',
                                ],
                            'tipo'=>[
                                    'tabla'     => 'tipo_mantencion',
                                    'id'        =>'id_______tma',
                                    'nombre'    => 'nombre___tma',
                                ],
                            'materiales'=>[
                                            'tabla'     => 'insumos',
                                            'id'        =>'id_______ins',
                                            'nombre'    => 'nombre___ins',
                                        ],
                        ];

        $num_querys=1;
        $cantidad=ceil($this->row_count("mantencion","tintoreria")/$num_querys);
        $offsets=0;

        $tbl_old="mantencion";
        $tbl_new="mantencion_maquinaria";

        $this->nueva_tabla_normaliza($tbl_old,"nombre___ins",'materiales',"insumos");//agrega  nuevas tablas 
        $this->nueva_tabla_normaliza($tbl_old,"nombre___tma",'tipo',"tipo_mantencion");
        
        for ($i=0; $i < $num_querys; $i++) {//genera relaciones 
            $datos=$this->search_limit_normaliza("mantencion","tintoreria",$columns['columns_old'],$offsets,$cantidad);

            if (isset($datos)) {
                foreach ($datos as $key => $value) {
                    foreach ($value as $k => $v) {
                        $relacion=in_array($k, array_keys($relations_columns));
                        if ($relacion) {
                            $where=$relations_columns[$k]['nombre']."='$v'";
                            $ids=$relations_columns[$k]['id'];
                            $nuevo_valor=$this->search($relations_columns[$k]['tabla'],$this->db_new(),$where,$ids);
                            $datos[$key][$k]=$nuevo_valor[0][$ids];
                        }
                    }
                }
                $this->masive_insert($this->db_new(),$tbl_new,$datos,$columns['columns_new']);
            }
            $offsets=$offsets+$cantidad;

        }        
        return "";
    } 
    

    public function nueva_tabla_normaliza($old_table,$columns_new,$column_old,$new_table) {

        $this->_db->query("set foreign_key_checks=0");
        $query='truncate '.$this->db_new().'.'.$new_table;
        $result=$this->_db->query($query);

        $datos=$this->search_distinct($old_table,$this->db_old(),$column_old,$new_table);
        
        if (isset($datos)) {
            $this->masive_insert("tintoreriaCI",$new_table,$datos,$columns_new);
        }

    } 


    /*
        PARA HACER INSERT MASIVOS
      public function normaliza_maquina() { 
        $num_querys=1;

        $cantidad=ceil($this->row_count("master_maquina","tintoreria")/$num_querys);
        $offsets=0;

        for ($i=0; $i < $num_querys; $i++) { 

            $datos=$this->search_limit_normaliza("master_maquina","tintoreria",$offsets,$cantidad);
            if (isset($datos)) {
                $this->masive_insert("tintoreriaCI","maquinaria",$datos);
            }
            $offsets=$offsets+$cantidad;

        }        
        
    } 

    */



} 
  ?> 