<?php

class BorrowingRepository implements RepositoryInterface {
       
    //Permet la création d'un Objet "Borrowing"
    public static function create(Array $myBorrow) : ?Borrowing {
        return new Borrowing(
            $myBorrow['id_borrowing'],
            $myBorrow['start_borrowing'],
            $myBorrow['end_borrowing'],
            UserRepository::getById($myBorrow['id___user_borrower']),
            GoodRepository::getById($myBorrow['id_goods'])
        );                 
    }

    //Permet l'appel à l'integralité des emprunts et renvoie un tableau d'objet "Borrowing"
    public static function getAll() : Array {
        $connectionDB = Connect::getInstance();
        
        $stmt = $connectionDB->prepare('SELECT * FROM borrowing;');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $borrowList=[];
        foreach ($result as $borrow) {
            $borrowList[]= self::create($borrow);
        }

        return $borrowList;
    }

    //Permet l'ajout d'un emprunt
    public static function add(Object $borrowing) : int {

        if (!$borrowing instanceof Borrowing) {
            throw new InvalidArgumentException('Expected instance of Good');
        }
        $connectionDB = Connect::getInstance();

        if(self::getBorrowDisponibility($borrowing->getGood()->getId(), $borrowing->getStartBorrow(), $borrowing->getEndBorrow())){
            $stmt = $connectionDB->prepare('INSERT INTO borrowing (start_borrowing, end_borrowing, Id___user_borrower, Id_goods) VALUES(:startBorrow, :endBorrow, :borrower, :good);');
            $stmt->bindValue(":startBorrow", date("Y-m-d", strtotime($borrowing->getStartBorrow())), PDO::PARAM_STR);
            $stmt->bindValue(":endBorrow", date("Y-m-d", strtotime($borrowing->getEndBorrow())), PDO::PARAM_STR);
            $stmt->bindValue(":borrower", $borrowing->getBorrower(), PDO::PARAM_INT);
            $stmt->bindValue(":good", $borrowing->getGood()->getId(), PDO::PARAM_INT);
            $stmt->execute();
            return $borrowing->getGood()->getId();
        }
    }

    //Permet l'édition d'un emprunt
    public static function update(Object $borrowing) : int {

        if (!$borrowing instanceof Borrowing) {
            throw new InvalidArgumentException('Expected instance of Good');
        }
        $connectionDB = Connect::getInstance();

        if(self::getBorrowDisponibility($borrowing->getGood()->getId(), $borrowing->getStartBorrow(), $borrowing->getEndBorrow())){
            $stmt = $connectionDB->prepare('UPDATE borrowing SET start_borrowing = :startBorrow end_borrowing = :endBorrow Id___user_borrower = :borrower Id_goods = :good WHERE id_borrowing = :id ;');
            $stmt->bindValue(":startBorrow", date("Y-m-d", strtotime($borrowing->getStartBorrow())), PDO::PARAM_STR);
            $stmt->bindValue(":endBorrow", date("Y-m-d", strtotime($borrowing->getEndBorrow())), PDO::PARAM_STR);
            $stmt->bindValue(":borrower", $borrowing->getBorrower(), PDO::PARAM_INT);
            $stmt->bindValue(":good", $borrowing->getGood()->getId(), PDO::PARAM_INT);
            $stmt->bindValue(":id", $borrowing->getId(), PDO::PARAM_INT);
            $stmt->execute();
            return $borrowing->getId();
        }
    }

    //Permet la suppression d'un emprunt
    public static function delete(int $id) : void {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('DELETE FROM borrowing WHERE id_borrowing = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    //Permet l'appel à un objet "Borrowing" via son ID
    public static  function getById(int $id) : ?Borrowing {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('SELECT * FROM borrowing WHERE id_borrowing = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $borrow = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($borrow) !== 0) {
            return self::create($borrow[0]);
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
                $borrowList[]= self::create($borrow);
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
    public static function getBorrowDisponibility(int $id, string $startBorrow, string $endBorrow): bool {
        $connectionDB = Connect::getInstance();
    
        $stmt = $connectionDB->prepare('SELECT 1 FROM borrowing WHERE Id_goods = :id AND ((start_borrowing > :endBorrow) OR (end_borrowing < :startBorrow));');
        $stmt->bindValue(":startBorrow", date("Y-m-d", strtotime($startBorrow)), PDO::PARAM_STR);
        $stmt->bindValue(":endBorrow", date("Y-m-d", strtotime($endBorrow)), PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return ($stmt->fetch());
    }
}

?>
