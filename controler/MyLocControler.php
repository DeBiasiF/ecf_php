<?php

function loggin(){
    require_once 'view/loggin.php';
}

function signUp(){
    $roles = RoleRepository::getAllRole();
    require_once 'view/signUp.php';
}

function showGoods(){
    $goods = GoodRepository::getAllGood();
    $categories = CategoryRepository::getAllCategory();
    require_once 'view/accueil.php';
}

function showGoodDetails($id){
    $good = GoodRepository::getGoodById($id);
    require_once 'view/good.php';
}

function createGood(){
    $categories = CategoryRepository::getAllCategory();
    require_once 'view/createGood.php';
}

function createUser(){
    require_once 'view/createUser.php';
}

function gestionUser(){
    $users = UserRepository::getAllUser();
    require_once 'view/gestionUsers.php';
}

function updateUser($id){
    $user = UserRepository::getUserById($id);
    $roles = RoleRepository::getAllRole();
    require_once 'view/updateUser.php';
}

function deleteUser($id){
    UserRepository::deleteUser($id);
    header("Location: /ecf_php");
}

function updateGood($id){
    $good = GoodRepository::getGoodById($id);
    $categories = CategoryRepository::getAllCategory();
    require_once 'view/updateGood.php';
}


function getURL(){
    $url = $_SERVER['REQUEST_URI'];
    $url = strtok($url, '?');
    if (substr($url, 0, 1) === '/') {
        $url = substr($url, 1);
    }
    return $url;
}

?>