<?php
session_start(); 
require_once "./controler/myLocControler.php";
var_dump($_SESSION);
var_dump($_POST);

switch (getURL()) {
    case 'ecf_php/':
    case 'ecf_php/index.php':
    case 'ecf_php/index.php/accueil':
        showGoods(GoodRepository::getAllGood());
        
        break;
    
    case 'ecf_php/index.php/good':
        if($_GET) showGoodDetails(GoodRepository::getGoodById($_GET['id']));
        if(!empty($_POST['delete'])){
            GoodRepository::deleteGood($_POST['delete']);
            header("Location: /ecf_php");
        }
        break;
    
    case 'ecf_php/index.php/addgood':
        createGood();
        if (!empty($_POST['goodName']) && !empty($_POST['goodDescription']) && !empty($_POST['goodCategoryId'])) {           
            header("Location: /ecf_php/index.php/good?id=".GoodRepository::addGood());
        }
        break;
    
    case 'ecf_php/index.php/updatecontact':
        if($_GET) updateContact(ContactRepository::getContactById($_GET['id']));
        if (!empty($_POST['lastName']) && !empty($_POST['firstName']) && !empty($_POST['mail']) && !empty($_POST['phone']) && !empty($_POST['birthDay'])) {           
            header("Location: /Form_Contact/index.php/contact?id=".ContactRepository::updateContact($_GET['id']));
        }
        break;

    case 'ecf_php/index.php/loggin':
        loggin();
        if (!empty($_POST['userName']) && !empty($_POST['userPassword'])) {      
            if (($_SESSION['loggedUser'] = UserRepository::getLogged($_POST['userName'], $_POST['userPassword']))!=null){
                header("Location: /ecf_php/index.php");
            }
        }
        break;

    case 'ecf_php/index.php/signup':
        signUp();
        if (!empty($_POST['userName']) && !empty($_POST['userPassword']) && !empty($_POST['userPasswordConfirm']) && !empty($_POST['userRoleId'])) { 
            UserRepository::addUser();
            if (($_SESSION['loggedUser'] = UserRepository::getLogged($_POST['userName'], $_POST['userPassword']))!=null){
                header("Location: /ecf_php/index.php");
            }          
        }
        break;

    case 'ecf_php/index.php/loggout':
        if(!empty($_SESSION['loggedUser'])){
            session_destroy();
        }
        header("Location: /ecf_php");
        break;

    default:
        break;
}

?>