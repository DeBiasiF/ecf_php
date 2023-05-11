<?php

class IndexControler {
  
    //Function pour charger les utilitaires dans l'index et la super variable de session
    private static function loadIndex($devLog) : void {
        // Autoloading des classes
        function myAutoloader($class_name){
            $controller_file = 'controler/' . $class_name . '.php';
            $entities = 'model/' . $class_name . '.php';

            if (file_exists($controller_file)) {
                include_once $controller_file;
            } elseif (file_exists($entities)) {
                include_once $entities;
            }
        }

        // Enregistrez la fonction d'autoloading
        spl_autoload_register('myAutoloader');

        session_start()? "" : print("Connection echouée"); //on lance la session avec session
        if ($devLog){

            echo '<pre>';
            echo 'SESSION : <br>';
            var_dump($_SESSION);
            echo '</pre>';
            
            echo '<pre>';
            echo 'GET : <br>';
            var_dump($_GET);
            echo '</pre>';
            
            echo '<pre>';
            echo 'POST : <br>';
            print_r($_POST);
            echo '</pre>';
        }

    }
    
    //Fonction pour afficher les info php
    private static function getPhpInfo($phpInfo) : void {
        if($phpInfo)phpinfo();
    }

    //Fonction de gestion des pages sur l'index
    public static function setIndex() : void {
        self::loadIndex(false);
        self::getPhpInfo(false);

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
                    header("Location: ".$_SERVER['SCRIPT_NAME']);
                } 
                break;

            //Permet la suppression d'une reservation
            case 'ecf_php/index.php/deleteborrow':
                if (!empty($_SESSION['loggedUser'])) {
                    if($_SESSION['loggedUser']->getId() == $_GET['userId']){
                        GoodsControler::deleteBorrowing($_GET['borrowId']);
                    }
                }
                break;
        
            //Affiche la gestion des users
            case 'ecf_php/index.php/gestionuser':
                UserControler::gestionUser();
                break;
            
            //Affiche une page d'edition d'un user, si c'est lui meme qui est connecté lui permet de supprimer son compte, si c'est un admin il peut modifier le role en plus
            case 'ecf_php/index.php/updateuser':
                if(isset($_GET) && empty($_POST)){
                    UserControler::updateUser($_GET['id']);
                    $_SESSION['returnDirection'] = $_SERVER['HTTP_REFERER'];
                   }
                   if (!empty($_POST['userName']) && ($_SESSION['loggedUser']->getId() == $_GET['id'] || $_SESSION['loggedUser']->getRole()->getId() == 1)) {
                    if (($_SESSION['loggedUser']->getRole()->getId() == 1)?UserControler::userUpdated($_GET['id'], $_POST['userName'], $_POST['userPoint']):UserControler::userUpdated($_GET['id'], $_POST['userName'], null)){
                           $return = $_SESSION['returnDirection'];
                           unset($_SESSION['returnDirection']);
                           header("Location: ".$return);
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
        
            //Affiche la gestion des catégories
            case 'ecf_php/index.php/gestioncategory':
                CategoriesControler::gestionCategory();
                break;

            //Affiche une page d'edition d'une catégorie
            case 'ecf_php/index.php/updateuser':
                if(isset($_GET) && empty($_POST)){
                    CategoriesControler::updateCategory($_GET['id']);
                    $_SESSION['returnDirection'] = $_SERVER['HTTP_REFERER'];
                   }
                   if (!empty($_POST['categoryName']) && !empty($_POST['categoryPoint']) && $_SESSION['loggedUser']->getRole()->getId() == 1) {
                       if(CategoriesControler::categoryUpdated($_GET['id'], $_POST['categoryName'], $_POST['categoryPoint'])){
                           $return = $_SESSION['returnDirection'];
                           unset($_SESSION['returnDirection']);
                           header("Location: ".$return);
                       }
                   }
                break;
        
            //Permet la suppression d'une catégorie
            case 'ecf_php/index.php/deletecategory':
                if($_GET) CategoriesControler::deleteCategory($_GET['id']);
                break;

            //Affiche une page de création d'une categorie
            case 'ecf_php/index.php/addcategory':
                CategoriesControler::createCategory();
                if (!empty($_POST['categoryName']) && !empty($_POST['categoryPoint']) && $_SESSION['loggedUser']->getRole()->getId() == 1) {           
                    CategoriesControler::addCategory($_POST['goodName'], $_POST['goodDescription'], $_POST['goodCategoryId'], $_SESSION['loggedUser']->getId());
                }
                break;
        
            //Affiche une page de connexion
            case 'ecf_php/index.php/loggin':
                UtilsControler::loggin();
                if (!empty($_POST['userName']) && !empty($_POST['userPassword'])) {      
                   try {
                        $_SESSION['loggedUser'] = UtilsControler::getLogged(trim($_POST['userName']), trim($_POST['userPassword']));
                        header("Location: ".$_SERVER['SCRIPT_NAME']);
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
                        header("Location: ".$_SERVER['SCRIPT_NAME']);
                    }          
                }
                break;
        
            //permet la deconnexion 
            case 'ecf_php/index.php/loggout':
                if(!empty($_SESSION['loggedUser'])){
                    session_destroy();
                }
                header("Location: ".$_SERVER['SCRIPT_NAME']);
                break;
        
            //Gestion par defaut
            default:
                break;
        }
    }

}