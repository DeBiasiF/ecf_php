<?php 

class GoodsControler {

    
    //Fontion d'accède à la page d'accueil
    public static function showGoods() : void {
        $goods = GoodRepository::getAllGood();
        $categories = CategoryRepository::getAllCategory();
        require_once 'view/accueil.php';
    }

    //Fontion d'accès à la page d'affichage d'un bien
    public static function showGoodDetails($id) : void {
        $good = GoodRepository::getGoodById($id);
        require_once 'view/good.php';
    }

    //Fonction d'accès à la page d'ajout d'un bien
    public static function createGood() : void {
        $categories = CategoryRepository::getAllCategory();
        require_once 'view/createGood.php';
    }

    //Fonction sauvegarde du bien ajouté
    public static function addGood(String $name, String $description, int $category, int $lender){
        GoodRepository::addGood($name, $description, $category, $lender);
    }

    
    //Fonction d'accès à la page d'édition d'un bien
    public static function updateGood($id) : void {
        $good = GoodRepository::getGoodById($id);
        $categories = CategoryRepository::getAllCategory();
        require_once 'view/updateGood.php';
    }

    //Fonction de savegarde du bien update
    public static function goodUpdated(int $id, String $name, String $description, String $img, int $categoryId, int $lenderId) : void {
        GoodRepository::updateGood($id, $name, $description, $img, $categoryId, $lenderId);
    }

    //Fonction de suppression d'un bien
    public static function deleteGood(int $id){
        GoodRepository::deleteGood($id);
    }
}