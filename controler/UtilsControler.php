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
                header("Location: ".$_SERVER['SCRIPT_NAME']);
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

}