<?php

class UserControler {

    
    //Fontion d'accès à la page pour créer un utilisateur
    public static function createUser(){
        require_once 'view/createUser.php';
    }

    //Fonction d'accès à la page de gestion des utilisateurs
    public static function gestionUser(){
        $users = UserRepository::getAllUser();
        require_once 'view/gestionUsers.php';
    }

    //Fonction d'accès à la page d'édition d'un utilisateur
    public static function updateUser($id){
        $user = UserRepository::getUserById($id);
        $roles = RoleRepository::getAllRole();
        require_once 'view/updateUser.php';
    }

    //Fonction de suppression d'utilisateur
    public static function deleteUser($id){
        UserRepository::deleteUser($id);
        header("Location: /ecf_php");
    }

    //Fonction ajout user
    public static function addUser(String $name, int $idRole){
        UserRepository::addUser($name, $idRole);
    }


    //Fonction de sauvegarde de l' user update
    public static function userUpdated(int $id, String $name, String $points, int $roleId) : void {
        UserRepository::updateUser($id, $name, $points, $roleId);
    }


}