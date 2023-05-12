<?php

class UserRepository implements RepositoryInterface {
       
    //Permet la création d'un Objet "User"
    public static function create(Array $myUser) : ?User {
        return new User($myUser['id___user'],
            htmlspecialchars_decode($myUser['name___user']),
            $myUser['password___user'],
            $myUser['quantity_points___user'],
            RoleRepository::getById($myUser['id___role'])
        );             
    }

    //Permet l'appel à l'integralité des users et renvoie un tableau d'objet "User"
    public static function getAll() : Array {
        $connectionDB = Connect::getInstance();
        $stmt = $connectionDB->prepare('SELECT * FROM __user;');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $userList=[];
        foreach ($result as $user) {
            $userList[]= self::create($user);
        }

        return $userList;
    }

    //Permet l'ajout d'un user
    public static function add(Object $user) : int {
        
        if (!$user instanceof User) {
            throw new InvalidArgumentException('Expected instance of Good');
        }

        $connectionDB = Connect::getInstance();

        $psw = password_hash($user->getPassword(), PASSWORD_BCRYPT);
        $stmt = $connectionDB->prepare('INSERT INTO __user (name___user, password___user, Id___role) VALUES(:name, :psw, :Id_role)');
        $stmt->bindValue(":name", $user->getName(), PDO::PARAM_STR);
        $stmt->bindValue(":psw", $psw, PDO::PARAM_STR);
        $stmt->bindValue(":Id_role", $user->getRole()->getId(), PDO::PARAM_INT);
        $stmt->execute();
        return $connectionDB->lastInsertId();
    }

    //Permet l'édition d'un user
    public static function update(Object $user) : int {
         
        if (!$user instanceof User) {
            throw new InvalidArgumentException('Expected instance of Good');
        }

        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('UPDATE __user SET name___user = :name, quantity_points___user = :points, Id___role = :Id_role WHERE id___user = :id ;');
        $stmt->bindValue(":name", $user->getName(), PDO::PARAM_STR);
        $stmt->bindValue(":points", $user->getPoints(), PDO::PARAM_INT);
        $stmt->bindValue(":Id_role", $user->getRole()->getId(), PDO::PARAM_INT);
        $stmt->bindValue(":id", $user->getId(), PDO::PARAM_INT);
        $stmt->execute();
        return $user->getId();
    }

    //Permet la suppression d'un user
    public static function delete(int $id) : void {
        if(self::getGoodRented($id)){
            $connectionDB = Connect::getInstance();
            $stmt = $connectionDB->prepare('DELETE FROM __user WHERE id___user = :id ;');
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    //Permet l'appel à un objet "User" via son ID
    public static  function getById(int $id) : ?User {
        $connectionDB = Connect::getInstance();
        $stmt = $connectionDB->prepare('SELECT * FROM __user WHERE id___user = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($user) !== 0) {
            return self::create($user[0]);
        }else{
            return null;
        }    
    }

    //Permet l'identification et retourne l'objet "User" approprié
    public static function getLogged(String $name, String $psw) : ?User{
        $connectionDB = Connect::getInstance();
        $stmt = $connectionDB->prepare("SELECT * FROM __user WHERE name___user = :name");
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) !== 0){
            $user = self::create($result[0]);
            $registeredPsw = $user->getPassword();
            if(password_verify($psw, $registeredPsw)){
                session_start(); //on lance la session
                $_SESSION['user'] = [
                    'userId' => $user->getId(),
                    'userName' => $user->getName()
                ];
                return $user;
            } else {
                throw new Exception("Nom d'utilisateur et mot de passe invalide");
            }
        }    
    }  
    
    //Fonction pour retourner la liste des biens d'un user
    public static function getOwnedGoods(int $id) : ?array {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('SELECT * FROM goods WHERE id___user_lender = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $goods = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($goods) !== 0) {
            $goodList=[];
            foreach ($goods as $good) {
                $goodList[]= GoodRepository::create($good);
            }
            return $goodList;
        }else{
            return null;
        }    
    }

    //Function permetant de savoir si un utilisateur a un bien prêté
    public static function getGoodRented (int $id): bool {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('SELECT 1 FROM borrowing WHERE id___user_borrower = :id AND CURRENT_DATE BETWEEN start_borrowing AND end_borrowing;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $status = $stmt->fetch();
        return !$status;
        
    }
}
?>

