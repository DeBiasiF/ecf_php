<?php
spl_autoload_register(function ($class_name) {
    include './model/'.$class_name . '.php';
});


function loggin(){
    require_once 'view/loggin.php';
}

function signUp(){
    require_once 'view/signUp.php';
}

function showGoods($goods){
    require_once 'view/accueil.php';
}

function showGoodDetails($good){

    $id = $good->getId();
    $name = $good->getName();
    $img = "../".$good->getImg();
    $description = $good->getDescription();
    $status = $good->getStatus();
    $category = $good->getCategory()->getName();
    $lender = $good->getLender()->getName();
    require_once 'view/good.php';
}

function createGood(){
    $categories = CategoryRepository::getAllCategory();
    require_once 'view/createGood.php';
}

function createUser(){
    require_once 'view/createUser.php';
}

function updateGood($contact){
    $id = $contact->getId();
    $lastName = strtoupper($contact->getLastname());
    $firstName = ucfirst(strtolower($contact->getFirstname()));
    $mail = $contact->getMail();
    $phone = $contact->getPhone();
    $birthday = $contact->getBirthday();
    $file = "../".$contact->getFile();
    require_once 'view/updateContact.php';
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