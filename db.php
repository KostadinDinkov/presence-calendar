<?php

class database{
    private $connection;
    
    public function __construct($dbtype, $host, $dbname, $user, $password){
        try{
             $this->connection = new PDO("$dbtype:host=$host;dbname=$dbname;",$user,$password);
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function getConnection(){
        return $this->connection;
    }

}


?>
