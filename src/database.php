<?php 
/**
 * version 1.0.1
 * Release Candidate
 */

class CsvImporter_Database {

    protected $mysqli = null;
    private $server = null;
    private $username = null;
    private $password = null;
    private $database = null;
    
    private $connected = false;
    
    function __construct( $server, $username, $password, $database)
    {
        $this->server = $server;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }
    
    private function connect()
    {
        if (!$this->connected) {
            $this->mysqli = mysqli_connect($this->server, $this->username, $this->password, $this->database);
            
            $this->connected = (bool) $this->mysqli;
        }
        
        return $this->connected;
    }
    
    protected function refValues($arr){ 
     if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+ 
     { 
         $refs = array(); 
         foreach($arr as $key => $value) 
             $refs[$key] = &$arr[$key]; 
         return $refs; 
     } 
     return $arr; 
 }
    
    public function insert($table, $data) 
    {
        if (!$this->connect()) {
            return false;
        }
        
        $valueKeys = '';
        foreach ($data[0] as $key => $value) {
            $valueKeys .= '`' . $key . '`, ';
        }
        $valueKeys = trim ($valueKeys, ', ');
        
        $sql = 'INSERT INTO ' . $table . ' ( ' . $valueKeys . ' ) VALUES ';
        
        $values = array();
        $types = '';
        
        foreach ($data as $row) {
            $sql .= '(';
            $valuesPlaceholders = '';
            foreach ($row as $value) {
                $valuesPlaceholders .= '?, ';
                $values[] = $value;
                $types .= 's';
            }
            $valuesPlaceholders = trim ($valuesPlaceholders, ', ');
            $sql .= $valuesPlaceholders . '), ';
        }
        
        $sql = trim ($sql, ', ') .';';
        
        $stmt =  mysqli_prepare($this->mysqli, $sql);
        
        call_user_func_array('mysqli_stmt_bind_param', array_merge (array($stmt, $types), $this->refValues($values)));
        return mysqli_stmt_execute($stmt);
    }
}