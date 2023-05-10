<?php

class UserRepository {
       
    //Permet la création d'un Objet "User"
    public static function createUser(Array $myUser) : ?User {
        $user = new User();
        $user->setId($myUser['id___user'])
                ->setName($myUser['name___user'])
                ->setPassword($myUser['password___user'])
                ->setPoints($myUser['quantity_points___user'])
                ->setRole(RoleRepository::getRoleById($myUser['id___role']));
        return $user;                
    }

    //Permet l'appel à l'integralité des users et renvoie un tableau d'objet "User"
    public static function getAllUser() : Array {
        $connectionDB = Connect::getInstance();
        $stmt = $connectionDB->prepare('SELECT * FROM __user;');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $userList=[];
        foreach ($result as $user) {
            $userList[]= self::createUser($user);
        }

        return $userList;
    }

    //Permet l'ajout d'un user
    public static function addUser(String $name, int $idRole) : int {
        $connectionDB = Connect::getInstance();

        if(($_POST['userPassword']) == ($_POST['userPasswordConfirm'])){
            $psw = password_hash($_POST['userPassword'], PASSWORD_BCRYPT);
            $stmt = $connectionDB->prepare('INSERT INTO __user (name___user, password___user, Id___role) VALUES(:name, :psw, :Id_role)');
            $stmt->bindValue(":name", $name, PDO::PARAM_STR);
            $stmt->bindValue(":psw", $psw, PDO::PARAM_STR);
            $stmt->bindValue(":Id_role", $idRole, PDO::PARAM_INT);
            $stmt->execute();
            return $connectionDB->lastInsertId();
        }

    }

    //Permet l'édition d'un user
    public static function updateUser(int $id, String $name, int $point, int $idRole) : int {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('UPDATE __user SET name___user = :name, quantity_points___user = :mail, Id_role = :phone WHERE id___user = :id ;');
        $stmt->bindValue(":name", $name, PDO::PARAM_STR);
        $stmt->bindValue(":points", $point, PDO::PARAM_INT);
        $stmt->bindValue(":Id_role", $idRole, PDO::PARAM_INT);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $id;
    }

    //Permet la suppression d'un user
    public static function deleteUser(int $id) {
        $connectionDB = Connect::getInstance();
        $stmt = $connectionDB->prepare('DELETE FROM __user WHERE id___user = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    //Permet l'appel à un objet "User" via son ID
    public static  function getUserById(int $id) : ?User {
        $connectionDB = Connect::getInstance();
        $stmt = $connectionDB->prepare('SELECT * FROM __user WHERE id___user = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($user) !== 0) {
            return self::createUser($user[0]);
        }else{
            return null;
        }    
    }

    //Permet l'identification et retourne l'objet "User" approprié
    public static function getLogged(String $name, String $psw) {
        $connectionDB = Connect::getInstance();
        $stmt = $connectionDB->prepare("SELECT * FROM __user WHERE name___user = :name");
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) !== 0){
            $user = self::createUser($result[0]);
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
    public static function getOwnedGoods(int $id) : array {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('SELECT * FROM goods WHERE id___user_lender = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $goods = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($goods) !== 0) {
            $goodList=[];
            foreach ($goods as $good) {
                $goodList[]= GoodRepository::createGood($good);
            }
            return $goodList;
        }else{
            return null;
        }    
    }
}
?>

