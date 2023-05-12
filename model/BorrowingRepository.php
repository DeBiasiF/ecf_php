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
    public static function addBorrowing(String $startBorrow, String $endBorrow, int $borrower, int $goodBorrowed) : int {
        
        $connectionDB = Connect::getInstance();

        if(self::getBorrowDisponibility($goodBorrowed, $startBorrow, $endBorrow)){
            $stmt = $connectionDB->prepare('INSERT INTO borrowing (start_borrowing, end_borrowing, Id___user_borrower, Id_goods) VALUES(:startBorrow, :endBorrow, :borrower, :good);');
            $stmt->bindValue(":startBorrow", date("Y-m-d", strtotime($startBorrow)), PDO::PARAM_STR);
            $stmt->bindValue(":endBorrow", date("Y-m-d", strtotime($endBorrow)), PDO::PARAM_STR);
            $stmt->bindValue(":borrower", $borrower, PDO::PARAM_INT);
            $stmt->bindValue(":good", $goodBorrowed, PDO::PARAM_INT);
            $stmt->execute();
            return $goodBorrowed;
        }
    }

    //Permet l'édition d'un emprunt
    public static function updateBorrowing(int $id, String $startBorrow, String $endBorrow, int $borrower, int $goodBorrowed) : int {
        $connectionDB = Connect::getInstance();

        if(self::getBorrowDisponibility($goodBorrowed, $startBorrow, $endBorrow)){
            $stmt = $connectionDB->prepare('UPDATE borrowing SET start_borrowing = :startBorrow end_borrowing = :endBorrow Id___user_borrower = :borrower Id_goods = :good WHERE id_borrowing = :id ;');
            $stmt->bindValue(":startBorrow", date("Y-m-d", strtotime($startBorrow)), PDO::PARAM_STR);
            $stmt->bindValue(":endBorrow", date("Y-m-d", strtotime($endBorrow)), PDO::PARAM_STR);
            $stmt->bindValue(":borrower", $borrower, PDO::PARAM_INT);
            $stmt->bindValue(":good", $goodBorrowed, PDO::PARAM_INT);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $id;
        }
    }

    //Permet la suppression d'un emprunt
    public static function deleteBorrowing(int $id) : void {
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
    
    //Permet de retourner la liste des dates de reservation au format json
    public static function getBorrowingListJson($array) : array {
        $borrowlist = [];
        if($array){
            foreach ($array as $borrow) {
                $borrowlist[] = [
                    "startBorrow" => $borrow->getStartBorrow(),
                    "endBorrow" => $borrow->getEndBorrow()
                ];
            }
        }
        return $borrowlist;
    }

    //Function permetant de savoir si une plage de reservation est possible
    public static function getBorrowDisponibility(int $id, String $startBorrow, String $endBorrow): bool {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('SELECT 1 FROM borrowing WHERE Id_goods = :id AND :startBorrow BETWEEN start_borrowing AND end_borrowing;');
        $stmt->bindValue(":startBorrow", date("Y-m-d", strtotime($startBorrow)), PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $testStart = !$stmt->fetch();

        $stmt = $connectionDB->prepare('SELECT 1 FROM borrowing WHERE Id_goods = :id AND :endBorrow BETWEEN start_borrowing AND end_borrowing;');
        $stmt->bindValue(":endBorrow", date("Y-m-d", strtotime($endBorrow)), PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $testEnd = !$stmt->fetch();

        $stmt = $connectionDB->prepare('SELECT 1 FROM borrowing WHERE Id_goods = :id AND start_borrowing BETWEEN :startBorrow AND :endBorrow;');
        $stmt->bindValue(":startBorrow", date("Y-m-d", strtotime($startBorrow)), PDO::PARAM_STR);
        $stmt->bindValue(":endBorrow", date("Y-m-d", strtotime($endBorrow)), PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $testGlobalStart = !$stmt->fetch();

        $stmt = $connectionDB->prepare('SELECT 1 FROM borrowing WHERE Id_goods = :id AND end_borrowing BETWEEN :startBorrow AND :endBorrow;');
        $stmt->bindValue(":startBorrow", date("Y-m-d", strtotime($startBorrow)), PDO::PARAM_STR);
        $stmt->bindValue(":endBorrow", date("Y-m-d", strtotime($endBorrow)), PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $testGlobalEnd = !$stmt->fetch();
        
        return ($testStart && $testEnd && $testGlobalStart && $testGlobalEnd);
    }

}
?>
