<?php
require_once './DBConnection.php';

class Shard implements DBConnection {

    public function __construct(
            private string $hostname,
            private string $username, 
            private string $password,
            private string $database
    
    ) {
        
    }
    
    public function connect(): mysqli|bool {
        try {
            $connection = mysqli_connect($this->hostname, $this->username, $this->password, $this->database);
        } catch (Exception $exc) {
            
        }
        
        return $connection;
    }
    
    
    public function query() {}
    
}
