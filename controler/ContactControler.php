<?php
spl_autoload_register(function ($class_name) {
    include './model/'.$class_name . '.php';
});


function showContacts($contacts){
    require_once 'view/accueil.php';
}

function showContactDetails($contact){

    $id = $contact->getId();
    $lastName = strtoupper($contact->getLastname());
    $firstName = ucfirst(strtolower($contact->getFirstname()));
    $mail = $contact->getMail();
    $phone = $contact->getPhone();
    $birthday = $contact->getBirthday();
    $file = "../".$contact->getFile();
    require_once 'view/contact.php';

}

function createContact(){
    require_once 'view/createContact.php';
}

function updateContact($contact){
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