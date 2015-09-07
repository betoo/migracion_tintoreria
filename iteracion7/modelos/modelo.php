<?php  
require_once "coneccion/config.php"; 

class Modelo 
{ 
    protected $_db; 

    public function __construct() 
    { 
        $this->_db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); 

        if ( $this->_db->connect_errno ) 
        { 
            echo "Fallo al conectar a MySQL: ". $this->_db->connect_error; 
            return;     
        } 

        $this->_db->set_charset(DB_CHARSET); 
        $this->_db->query("set foreign_key_checks=0");
    } 

    function db_old() {
        return "tintoreria";
    }
    function db_new() {
        return "tintoreriaCI";
    }


    function insert($link,$db,$tbl,$col,$data) {

        $sql = "INSERT INTO $db.$tbl ($col) values $data"; 
        $result_insert=$this->_db->query($sql);

        if ($result_insert) {
            echo "<br>Exito $tbl";
            return true;
        }else{
            echo "<br>Fallo".$this->_db->connect_error;
            return false;
        }
    }

    function masive_insert($db,$tbl,$data,$columns) {
        
        $insert="";
        foreach ($data as $nombre_columna => $arr_columna) {

            $row="";
            foreach ($arr_columna as $campo => $valor) {
                
                $row    .="'".ucfirst(strtolower(trim($valor)))."',";
            }

            $row=rtrim($row,",");
            $insert.="(".$row."),";
        }
        $insert=rtrim($insert,",");

        $sql = "INSERT INTO $db.$tbl ($columns) values $insert"; 

        $result_insert=$this->_db->query($sql);

        if ($result_insert) {
            echo "<br>Exito $tbl";
            return true;
        }else{
            echo "<br>Fallo .".$this->_db->connect_error;
            return false;
        }
    }

    function search($tbl,$db,$where,$ids) { 

        $sql="SELECT $ids FROM $db.$tbl  where $where";
        $result=$this->_db->query($sql);
        $datos=[];
        while ($line =  $result->fetch_assoc()) {
            $datos[]=$line;
        }

        if ($datos>0) {
            return $datos;
        }else{
            return false;
        }
    }
    
    function search_distinct($tbl,$db,$column) { 

        $sql="SELECT DISTINCT $column  FROM $db.$tbl ";
        $result=$this->_db->query($sql);
        $datos=[];
        while ($line = $result->fetch_assoc()) {
            $datos[]=$line;
        }

        if ($datos>0) {
            return $datos;
        }else{
            return false;
        }
    }

    function search_limit($tbl,$num_querys,$name_db) {

        $cantidad=ceil($this->row_count($tbl,$name_db)/$num_querys);        
        
        $offsets=0;

        for ($i=0; $i < $num_querys; $i++) { 

            $sql="SELECT * FROM $name_db.$tbl  limit $offsets,$cantidad";
            $result=$this->_db->query($sql);

            $datos=[];
            while ($row = $result->fetch_assoc()) {
                $datos[] = $row;
            }
            $offsets=$offsets+$cantidad;
        }        

        
        if ($datos>0) {
            return $datos;
        }else{
            return false;
        }
    }

    function search_limit_normaliza($tbl,$name_db,$col,$offsets,$cantidad) {

            $sql="SELECT $col FROM $name_db.$tbl  limit $offsets,$cantidad";
            $result=$this->_db->query($sql);

            $datos=[];
            while ($row = $result->fetch_assoc()) {
                $datos[] = $row;
            }

        
        if ($datos>0) {
            return $datos;
        }else{
            return false;
        }
    }

    function search_all($tbl,$link,$name_db_old) {
        //para normalizar la la columna categoria
        //agrega a categoria

        $sql="SELECT * FROM $name_db_old.$tbl";
        $result=$this->_db->query($sql);

        $datos=[];
        while ($line = $result->fetch_assoc()) {
            $datos[]=$line;
        }

        if ($datos>0) {
            return $datos;
        }else{
            return "false";
        }
    }
        
    function row_count($tbl,$name_db) {

        $sql="SELECT count(*) as total FROM $name_db.$tbl ";
        $result=$this->_db->query($sql);
        $datos=[];
        while ($row = $result->fetch_assoc()) {
            $datos = $row['total'];
        }

        if ($datos>0) {
            return $datos;
        }else{
            return "false";
        }
    }

    public function get_columns() { 
        foreach ($this->equivalencia_columnas() as $key => $value) {
            $columns_old.=$key.",";
            $columns_new.=$value.",";
        }

        $columns=[
            'columns_old' =>rtrim($columns_old,","),
            'columns_new' =>rtrim($columns_new,","),
        ];

        return $columns;
    } 

} 
?> 