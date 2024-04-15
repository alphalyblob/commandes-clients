<?php

class Connect extends PDO{

    const HOST = "127.0.0.1";
    const DB = "commandes_clients";
    const USER = "root";
    const PASSWORD = "";

    public function __construct()
    {
        try{
            parent::__construct("mysql:dbname=".self::DB.";host=".self::HOST,self::USER,self::PASSWORD);
            // echo "CONNEXION BDD DONE";
        }
        catch(PDOException $e){
            echo $e->getMessage()." ".$e->getFile()." ".$e->getLine();
        }
        
    }

}

?>


