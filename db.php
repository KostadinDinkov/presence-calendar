<?php

class Database{
    private $connection;
    
    public function __construct(){
        require_once("db_config.php");

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
