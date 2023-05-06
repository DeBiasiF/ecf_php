<?php

//Fontion d'accède à la page pour se connecter
function loggin(){
    require_once 'view/loggin.php';
}

//Fontion d'accède à la page pour s'inscrire
function signUp(){
    $roles = RoleRepository::getAllRole();
    require_once 'view/signUp.php';
}

//Fontion d'accède à la page d'accueil
function showGoods(){
    $goods = GoodRepository::getAllGood();
    $categories = CategoryRepository::getAllCategory();
    require_once 'view/accueil.php';
}

//Fontion d'accès à la page d'affichage d'un bien
function showGoodDetails($id){
    $good = GoodRepository::getGoodById($id);
    require_once 'view/good.php';
}

//Fonction d'accès à la page d'ajout d'un bien
function createGood(){
    $categories = CategoryRepository::getAllCategory();
    require_once 'view/createGood.php';
}

//Fontion d'accès à la page pour créer un utilisateur
function createUser(){
    require_once 'view/createUser.php';
}

//Fonction d'accès à la page de gestion des utilisateurs
function gestionUser(){
    $users = UserRepository::getAllUser();
    require_once 'view/gestionUsers.php';
}

//Fonction d'accès à la page d'édition d'un utilisateur
function updateUser($id){
    $user = UserRepository::getUserById($id);
    $roles = RoleRepository::getAllRole();
    require_once 'view/updateUser.php';
}

//Fonction de suppression d'utilisateur
function deleteUser($id){
    UserRepository::deleteUser($id);
    header("Location: /ecf_php");
}

//Fonction d'accès à la page d'édition d'un bien
function updateGood($id){
    $good = GoodRepository::getGoodById($id);
    $categories = CategoryRepository::getAllCategory();
    require_once 'view/updateGood.php';
}

//Fonction permetant l'identification de la page souhaité
function getURL(){
    $url = $_SERVER['REQUEST_URI'];
    $url = strtok($url, '?');
    if (substr($url, 0, 1) === '/') {
        $url = substr($url, 1);
    }
    return $url;
}

?>