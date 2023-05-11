<?php

class UtilsControler {


    //Fonction permetant l'identification de la page souhaité
    public static function getURL() : String {
        $url = $_SERVER['REQUEST_URI'];
        $url = strtok($url, '?');
        if (substr($url, 0, 1) === '/') {
            $url = substr($url, 1);
        }
        return $url;
    }

    //Fontion d'accède à la page pour se connecter
    public static function loggin() : void {
        require_once 'view/loggin.php';
    }

    //Fontion d'accède à la page pour s'inscrire
    public static function signUp() : void {
        $roles = RoleRepository::getAllRole();
        require_once 'view/signUp.php';
        if (!empty($_POST['userName']) && !empty($_POST['userPassword']) && !empty($_POST['userPasswordConfirm'])) { 
            $idRole = $_POST['userRoleId']!=null?$_POST['userRoleId']:2;
            UserRepository::addUser(trim($_POST['userName']), $idRole);
            if (($_SESSION['loggedUser'] = UserRepository::getLogged($_POST['userName'], $_POST['userPassword']))!=null){
                header("Location: /ecf_php/index.php");
            }
        }
    }

    //Fonction de vérification de connection
    public static function getLogged(String $name , String $psw) : ?User {
        try{
            $user = UserRepository::getLogged($name , $psw);
            
        }catch(Exception $e){
            $errorMessage = $e->getMessage();
        }
        return $user;
    }

    //Function pour charger les utilitaires dans l'index et la super variable de session
    public static function loadIndex($devLog){
        // Autoloading des classes
        function myAutoloader($class_name){
            $controller_file = 'controler/' . $class_name . '.php';
            $entities = 'model/' . $class_name . '.php';

            if (file_exists($controller_file)) {
                include_once $controller_file;
            } elseif (file_exists($entities)) {
                include_once $entities;
            }
        }

        // Enregistrez la fonction d'autoloading
        spl_autoload_register('myAutoloader');

        session_start()? "" : print("Connection echouée"); //on lance la session avec session
        if ($devLog){

            echo '<pre>';
            echo 'SESSION';
            var_dump($_SESSION);
            echo '</pre>';
            
            echo '<pre>';
            echo 'GET';
            var_dump($_GET);
            echo '</pre>';
            
            echo '<pre>';
            echo 'POST';
            print_r($_POST);
            echo '</pre>';
        }

    }
    
    //Fonction pour afficher les info php
    public static function getPhpInfo($phpInfo){
        if($phpInfo)phpinfo();
    }
}