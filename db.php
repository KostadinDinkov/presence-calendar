<?php

class database{
    private $connection;
    
    public function __construct($dbtype, $host, $dbname, $user, $password){
        try{
             $this->connection = new PDO("mysql:host=$host;dbname=$dbname", $user, $password,
        [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
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
