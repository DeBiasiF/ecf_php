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
        if (!empty($_POST['userName']) && !empty($_POST['userPassword'])) {      
            if (($_SESSION['loggedUser'] = UserRepository::getLogged(trim($_POST['userName']), trim($_POST['userPassword'])))!=null){
                header("Location: /ecf_php/index.php");
            }
        }
    }

    //Fontion d'accède à la page pour s'inscrire
    public static function signUp() : void {
        $roles = RoleRepository::getAllRole();
        require_once 'view/signUp.php';
        if (!empty($_POST['userName']) && !empty($_POST['userPassword']) && !empty($_POST['userPasswordConfirm'])) { 
            UserRepository::addUser(trim($_POST['userName']), $_POST['userRoleId']);
            if (($_SESSION['loggedUser'] = UserRepository::getLogged($_POST['userName'], $_POST['userPassword']))!=null){
                header("Location: /ecf_php/index.php");
            }
        }
    }

    //Fonction de vérification de connection
    public static function getLogged(String $name , String $psw) : ?User {
        return UserRepository::getLogged($name , $psw);
    }

    //Function pour charger les utilitaires dans l'index et la super variable de session

    public static function loadIndex(){
        //Autoloader
        spl_autoload_register(function ($class_name) {
            if(file_exists('./model/'.$class_name . '.php')){
                include './model/'.$class_name . '.php';
            }else{
                include './controler/'.$class_name . '.php';
            }      
        });
        //Active la supervariable session
        session_start();
    }

}