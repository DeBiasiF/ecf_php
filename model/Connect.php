<?php

class Connect extends PDO{
 
    private static ?Connect $instance = null;


    private function __construct($dns, $username, $password, $options){
        parent::__construct($dns, $username, $password, $options);
    }
    
    /**
     * getInstance, return a connection
     *
     * @return Connect
     */
    public static function getInstance() : Connect {
        if(self::$instance == null){
            $conf = require_once './config.php';
            $dns = "pgsql:host=".$conf['host'].";port=".$conf['port'].";dbname=".$conf['dbname'];
            $options = array(
                PDO::ATTR_PERSISTENT  => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            try {
                self::$instance = new self($dns, $conf['username'], $conf['pass'], $options);
            } catch (Error $e) {
                echo($e->getMessage());
            }
        }
        return self::$instance;
    }
}
?>