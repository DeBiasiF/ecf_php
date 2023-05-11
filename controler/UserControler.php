<?php

class UserControler {

    //Fontion d'accès à la page pour créer un utilisateur
    public static function createUser() : void {
        require_once 'view/createUser.php';
    }

    //Fonction d'accès à la page de gestion des utilisateurs
    public static function gestionUser() : void {
        $users = UserRepository::getAllUser();
        require_once 'view/gestionUsers.php';
    }

    //Fonction d'accès à la page d'édition d'un utilisateur
    public static function updateUser($id) : void {
        $user = UserRepository::getUserById($id);
        $roles = RoleRepository::getAllRole();
        require_once 'view/updateUser.php';
    }

    //Fonction de suppression d'utilisateur
    public static function deleteUser($id) : void {
        UserRepository::deleteUser($id);
        header("Location: ".$_SERVER['SCRIPT_NAME']);
    }

    //Fonction ajout user
    public static function addUser(String $name, int $idRole) : void {
        UserRepository::addUser($name, $idRole);
    }

    //Fonction de sauvegarde de l' user update
    public static function userUpdated(int $id, String $name, ?int $point) : int {
        $user = UserRepository::getUserById($id);
        if($point == null)$point= $user->getPoints();
        return UserRepository::updateUser($user->getId(), $name, $point, $user->getRole()->getId());
    }

    //Fonction de sauvegarde de l' user update avec point
    public static function userUpdatedPoint(int $id, String $name, int $point) : int {
        $user = UserRepository::getUserById($id);
        return UserRepository::updateUser($user->getId(), $name, $user->getPoints(), $user->getRole()->getId());
    }
    
    //Fonction d'affichage de la page back office de l'user
    public static function userBackOffice(int $id) : void {
        $user = UserRepository::getUserById($id);
        $ownedGoods = UserRepository::getOwnedGoods($id);
        $ownedBorrows = BorrowingRepository::getNextBorrowingByGood($id);
        require_once 'view/userBackOffice.php';
    }

}