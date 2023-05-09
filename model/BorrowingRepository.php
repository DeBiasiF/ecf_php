<?php

class BorrowingRepository {
       
    //Permet la création d'un Objet "Borrowing"
    public static function createBorrowing(Array $myBorrow) : ?Borrowing {
        $borrowing = new Borrowing();
        $borrowing->setId($myBorrow['id_borrowing'])
                ->setStartBorrow($myBorrow['start_borrowing'])
                ->setEndBorrow($myBorrow['end_borrowing'])
                ->setBorrower(UserRepository::getUserById($myBorrow['id___user_borrower']))
                ->setGood(GoodRepository::getGoodById($myBorrow['id_goods']));
        return $borrowing;                
    }

    //Permet l'appel à l'integralité des emprunts et renvoie un tableau d'objet "Borrowing"
    public static function getAllBorrowing() : Array {
        $connectionDB = Connect::getInstance();
        $stmt = $connectionDB->prepare('SELECT * FROM borrowing;');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $borrowList=[];
        foreach ($result as $borrow) {
            $borrowList[]= self::createBorrowing($borrow);
        }

        return $borrowList;
    }

    //Permet l'ajout d'un emprunt
    public static function addBorrowing() : int {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('INSERT INTO borrowing (start_borrowing, end_borrowing, Id___user_borrower, Id_goods) VALUES(:startBorrow, :endBorrow, :borrower, :good);');
        $stmt->bindValue(":startBorrow", $_POST['startBorrow'], PDO::PARAM_STR);
        $stmt->bindValue(":endBorrow", $_POST['endBorrow'], PDO::PARAM_STR);
        $stmt->bindValue(":borrower", $_POST['borrower'], PDO::PARAM_INT);
        $stmt->bindValue(":good", $_POST['goodBorrow'], PDO::PARAM_INT);
        $stmt->execute();
        return $connectionDB->lastInsertId();
    }

    //Permet l'édition d'un emprunt
    public static function updateBorrowing(int $id) : int {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('UPDATE borrowing SET start_borrowing = :startBorrow end_borrowing = :endBorrow Id___user_borrower = :borrower Id_goods = :good WHERE id_borrowing = :id ;');
        $stmt->bindValue(":startBorrow", $_POST['startBorrow'], PDO::PARAM_STR);
        $stmt->bindValue(":endBorrow", $_POST['endBorrow'], PDO::PARAM_STR);
        $stmt->bindValue(":borrower", $_POST['borrower'], PDO::PARAM_INT);
        $stmt->bindValue(":good", $_POST['goodBorrow'], PDO::PARAM_INT);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $id;
    }

    //Permet la suppression d'un emprunt
    public static function deleteBorrowing(int $id) {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('DELETE FROM borrowing WHERE id_borrowing = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    //Permet l'appel à un objet "Borrowing" via son ID
    public static  function getBorrowingById(int $id) : ?Borrowing {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('SELECT * FROM borrowing WHERE id_borrowing = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $borrow = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($borrow) !== 0) {
            return self::createBorrowing($borrow[0]);
        }else{
            return null;
        }    
    }

    //Permet l'appel à une liste d'objet "Borrowing" via leur bien respectif
    public static function getNextBorrowingByGood(int $id) : ?Array {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('SELECT * FROM borrowing WHERE Id_goods = :id AND end_borrowing > CURRENT_DATE;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $borrows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($borrows) !== 0) {
            $borrowList=[];
            foreach ($borrows as $borrow) {
                $borrowList[]= self::createBorrowing($borrow);
            }
        return $borrowList;
        }else{
            return null;
        }    
    }
    
}
?>
