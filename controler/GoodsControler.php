<?php 

class GoodsControler {
   
    //Fontion d'accède à la page d'accueil
    public static function showGoods() : void {
        $goods = GoodRepository::getAll();
        $categories = CategoryRepository::getAll();
        require_once 'view/accueil.php';
    }

    //Fontion d'accès à la page d'affichage d'un bien
    public static function showGoodDetails($id) : void {
        $good = GoodRepository::getById($id);
        $borrows = BorrowingRepository::getNextBorrowingByGood($id);
        require_once 'view/good.php';
    }

    //Fonction d'accès à la page d'ajout d'un bien
    public static function createGood() : void {
        $categories = CategoryRepository::getAll();
        require_once 'view/createGood.php';
    }

    //Fonction sauvegarde du bien ajouté
    public static function addGood(String $name, String $description, int $categoryId, int $lenderId) : void {
        header("Location: ".$_SERVER['SCRIPT_NAME']."/good?id=".GoodRepository::add(new Good(0, $name, '', $description, true, CategoryRepository::getById($categoryId), UserRepository::getById($lenderId))));
    }
    
    //Fonction d'accès à la page d'édition d'un bien
    public static function updateGood($id) : void {
        $good = GoodRepository::getById($id);
        $categories = CategoryRepository::getAll();
        require_once 'view/updateGood.php';
    }

    //Fonction de savegarde du bien update
    public static function goodUpdated(int $id, String $name, String $description, String $img, int $categoryId, int $lenderId) : void {
        header("Location: ".$_SERVER['SCRIPT_NAME']."/good?id=".GoodRepository::update(new Good($id, $name, $img, $description, true, CategoryRepository::getById($categoryId), UserRepository::getById($lenderId))));
    }

    //Fonction de suppression d'un bien
    public static function deleteGood(int $userId, int $goodId) : void {
        GoodRepository::delete($goodId);
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }

    //Fonction d'affichage de la page de reservation
    public static function createBorrow(int $id) : void {
        $good = GoodRepository::getById($id);
        $borrows = BorrowingRepository::getNextBorrowingByGood($id);
        require_once 'view/borrow.php';
    }

    //Fonction ajout reservation
    public static function addBorrowing(String $startBorrow, String $endBorrow, int $borrower, int $goodBorrowed) : void {
        header("Location: ".$_SERVER['SCRIPT_NAME']."/good?id=".BorrowingRepository::add(new Borrowing(0, $startBorrow, $endBorrow, UserRepository::getById($borrower), GoodRepository::getById($goodBorrowed))));
    }

    //Fonction de suppression d'une réservation
    public static function deleteBorrowing(int $id) : void {
        BorrowingRepository::delete($id);
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
    
}