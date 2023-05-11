<?php
class CategoriesControler {

    //Fonction d'accès à la page de gestion des catégories
    public static function gestionCategory() : void {
        $categories = CategoryRepository::getAllCategory();
        require_once 'view/gestionCategories.php';
    }

    //Fonction d'accès à la page d'édition des catégories
    public static function updateCategory(int $id) : void {
        $category = CategoryRepository::getCategoryById($id);
        require_once 'view/updateCategories.php';
    }

    //Fonction de suppression des catégories
    public static function deleteCategory(int $id) : void {
        CategoryRepository::deleteCategory($id);
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }

    //Fonction d'accès à la page d'ajout d'un bien
    public static function createCategory() : void {
        require_once 'view/createCategory.php';
    }

    //Fonction sauvegarde de la catégorie ajouté
    public static function addCategory(String $name, int $point) : void {
        header("Location: ".$_SERVER['SCRIPT_NAME']."/good?id=".CategoryRepository::addCategory($name, $point));
    }


    //Fonction de sauvegarde de l' user update
    public static function categoryUpdated(int $id, String $name) : int {
        $user = UserRepository::getUserById($id);
        return UserRepository::updateUser($user->getId(), $name, $user->getPoints(), $user->getRole()->getId());
    }

}