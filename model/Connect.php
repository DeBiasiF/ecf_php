<?php

class Connect extends PDO{
 
    private static ?Connect $instance = null;


    //Privatise la connection du constructeur parent
    private function __construct($dsn, $username, $password, $options){
        parent::__construct($dsn, $username, $password, $options);
    }
    
    /**
     * getInstance, return a connection
     *
     * @return Connect
     */
    public static function getInstance() : Connect {
        if(self::$instance == null){
            $conf = require_once './config.php';
            $dsn = "pgsql:host=".$conf['host'].";port=".$conf['port'].";dbname=".$conf['dbname'];
            $options = array(
                PDO::ATTR_PERSISTENT  => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            try {
                self::$instance = new self($dsn, $conf['username'], $conf['pass'], $options);
            } catch (Error $e) {
                echo($e->getMessage());
            }
        }
        return self::$instance;
    }
}
?>