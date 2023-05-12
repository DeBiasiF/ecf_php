<?php
class CategoriesControler {

    //Fonction d'accès à la page de gestion des catégories
    public static function gestionCategory() : void {
        $categories = CategoryRepository::getAll();
        require_once 'view/gestionCategories.php';
    }

    //Fonction d'accès à la page d'édition des catégories
    public static function updateCategory(int $id) : void {
        $category = CategoryRepository::getById($id);
        require_once 'view/updateCategories.php';
    }

    //Fonction de suppression des catégories
    public static function deleteCategory(int $id) : void {
        CategoryRepository::delete($id);
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }

    //Fonction d'accès à la page d'ajout d'un bien
    public static function createCategory() : void {
        require_once 'view/createCategory.php';
    }

    //Fonction sauvegarde de la catégorie ajouté
    public static function addCategory(String $name, int $point) : void {
        header("Location: ".$_SERVER['SCRIPT_NAME']."/good?id=".CategoryRepository::add(new Category(0, $name, $point)));
    }


    //Fonction de sauvegarde de l' user update
    public static function categoryUpdated(int $id, String $name, int $point) : int {
        return CategoryRepository::update(new Category($id, $name, $point));
    }

}