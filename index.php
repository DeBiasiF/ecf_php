<?php
require './controler/UtilsControler.php';
UtilsControler::loadIndex(false);

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
        break;
    
    //Affiche une page d'ajout de bien
    case 'ecf_php/index.php/addgood':
        GoodsControler::createGood();
        if (!empty($_POST['goodName']) && !empty($_POST['goodDescription']) && !empty($_POST['goodCategoryId'])) {           
            GoodsControler::addGood($_POST['goodName'], $_POST['goodDescription'], $_POST['goodCategoryId'], $_SESSION['loggedUser']->getId());
        }
        break;

    //Affiche une page d'edition d'un bien
    case 'ecf_php/index.php/updategood':
        if(isset($_GET) && empty($_POST)) GoodsControler::updateGood($_GET['id']);

        if (!empty($_POST['goodName']) && !empty($_POST['goodDescription']) && !empty($_POST['goodCategoryId'])&& !empty($_POST['goodId'])) { 
            GoodsControler::goodUpdated($_POST['goodId'], $_POST['goodName'], $_POST['goodDescription'], $_FILES['image']['tmp_name'], $_POST['goodCategoryId'], $_POST['goodLenderId']);
        }
        break;
   
    //Permet la suppression d'un bien
    case 'ecf_php/index.php/deletegood':
        if($_GET) GoodsControler::deleteGood($_GET['userId'], $_GET['goodId']);
        break;

    //Affiche une page d'ajout d'une reservation
    case 'ecf_php/index.php/borrow':
        if (!empty($_SESSION['loggedUser'])) {
            if(isset($_GET) && empty($_POST)) GoodsControler::createBorrow($_GET['id']);
            if (!empty($_POST['beginDate']) && !empty($_POST['endDate']) && !empty($_POST['goodId']) && isset($_SESSION['loggedUser'])) {           
                GoodsControler::addBorrowing($_POST['beginDate'], $_POST['endDate'], $_SESSION['loggedUser']->getId(), $_POST['goodId']);
            }
        }else {
            header("Location: /ecf_php");
        } 
        break;

    //Affiche la gestion des users
    case 'ecf_php/index.php/gestionuser':
        UserControler::gestionUser();
        break;
    
    //Affiche une page d'edition d'un user, si c'est lui meme qui est connecté lui permet de supprimer son compte, si c'est un admin il peut modifier le role en plus
    case 'ecf_php/index.php/updateuser':
        if(isset($_GET) && empty($_POST)) UserControler::updateUser($_GET['id']);
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

    //Permet la suppression d'un user
    case 'ecf_php/index.php/userbackoffice':
        if(isset($_GET) && empty($_POST)) UserControler::userBackOffice($_GET['id']);
        break;

    //Affiche une page de connexion
    case 'ecf_php/index.php/loggin':
        UtilsControler::loggin();
        if (!empty($_POST['userName']) && !empty($_POST['userPassword'])) {      
           try {
                $_SESSION['loggedUser'] = UtilsControler::getLogged(trim($_POST['userName']), trim($_POST['userPassword']));
                header("Location: /ecf_php/index.php");
            }catch(Exception $e){
                $errorMessage = $e->getMessage();
            }
        } else {
            $errorMessage = sprintf('Les informations ne permettent pas de vous identifier');
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