<?php
spl_autoload_register(function ($class_name) {
    include './model/'.$class_name . '.php';
});


function loggin(){
    require_once 'view/loggin.php';
}

function signUp(){
    $roles = RoleRepository::getAllRole();
    require_once 'view/signUp.php';
}

function showGoods(){
    $goods = GoodRepository::getAllGood();
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

function updateUser($id){
    $user = UserRepository::getUserById($id);
    require_once 'view/updateUser.php';
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