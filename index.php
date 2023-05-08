<?php
spl_autoload_register(function ($class_name) {
    if(file_exists('./model/'.$class_name . '.php')){
        include './model/'.$class_name . '.php';
    }else{
        include './controler/'.$class_name . '.php';
    }      
});
//Active la supervariable session
session_start();

//Importe les controlleurs 
//require_once "./controler/myLocControler.php";
// var_dump($_SESSION);
// var_dump($_POST);

switch (UtilsControler::getURL()) {

    //Affichage de la page d'accueil
    case 'ecf_php/':
    case 'ecf_php/index.php':
    case 'ecf_php/index.php/':
    case 'ecf_php/index.php/accueil':
        GoodsControler::showGoods();
        break;
    
    //Affiche un seul bien
    case 'ecf_php/index.php/good':
        if($_GET) GoodsControler::showGoodDetails($_GET['id']);
        if(!empty($_POST['delete'])){
            GoodsControler::deleteGood($_POST['delete']);
            header("Location: /ecf_php");
        }
        break;
    
    //Affiche une page d'ajout de bien
    case 'ecf_php/index.php/addgood':
        GoodsControler::createGood();
        if (!empty($_POST['goodName']) && !empty($_POST['goodDescription']) && !empty($_POST['goodCategoryId'])) {           
            header("Location: /ecf_php/index.php/good?id=".GoodsControler::addGood($_POST['goodName'], $_POST['goodDescription'], $_POST['goodCategoryId'], $_SESSION['loggedUser']->getId()));
        }
        break;

            //Affiche une page d'edition d'un bien
    case 'ecf_php/index.php/updategood':
        if($_GET) GoodsControler::updateGood($_GET['id']);

        if (!empty($_POST['goodName']) && !empty($_POST['goodDescription']) && !empty($_POST['goodCategoryId'])) { 
            (!empty($_FILES['goodImg']['tmp_name']))?$img = self::saveImg():$img = self::getGoodById($id)->getImg();
            header("Location: /Form_Contact/index.php/good?id=".GoodsControler::goodUpdated($good->getId(), $_POST['goodName'], $_POST['goodDescription'], $img, $_POST['goodCategoryId'], $good->getLender()->getId()));
        }
        break;


    //Affiche la gestion des users
    case 'ecf_php/index.php/gestionuser':
        UserControler::gestionUser();
        break;
    
    //Affiche une page d'edition d'un user, si c'est lui meme qui est connecté lui permet de supprimer son compte, si c'est un admin il peut modifier le role en plus
    case 'ecf_php/index.php/updateuser':
        if($_GET) UserControler::updateUser($_GET['id']);

        if (!empty($_POST['userName']) && !empty($_POST['userPassword']) && !empty($_POST['userPasswordConfirm'])) {
            if(!empty($_SESSION['loggedUser'])) if ($_SESSION['loggedUser']->getRole()->getId() == 1){
                header("Location: /ecf_php/index.php/user?id=".UserControler::userUpdated($user->getId(), $_POST['userName'], $user->getPoints(), $user->getRole()->getId()));
            }else{
                header("Location: /ecf_php/index.php/user?id=".UserControler::userUpdated($user->getId(), $_POST['userName'], $user->getPoints(), $_POST['userRoleId']));
            }
        }
        break;

    //Permet la suppression d'un user
    case 'ecf_php/index.php/deleteuser':
        if($_GET) UserControler::deleteUser($_GET['id']);
        break;

    //Affiche une page de connexion
    case 'ecf_php/index.php/loggin':
        UtilsControler::loggin();
        if (!empty($_POST['userName']) && !empty($_POST['userPassword'])) {      
            if (($_SESSION['loggedUser'] = UtilsControler::getLogged(trim($_POST['userName']), trim($_POST['userPassword'])))!=null){
                header("Location: /ecf_php/index.php");
            }
        }
        break;

    //Affiche une page d'inscription
    case 'ecf_php/index.php/signup':
        UtilsControler::signUp();
        if (!empty($_POST['userName']) && !empty($_POST['userPassword']) && !empty($_POST['userPasswordConfirm'])) { 
            UserControler::addUser($_POST['userName'], $_POST['userRoleId']);
            if (($_SESSION['loggedUser'] = UtilsControler::getLogged($_POST['userName'], $_POST['userPassword']))!=null){
                header("Location: /ecf_php/index.php");
            }          
        }
        break;

    //permet la deconnexion 
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