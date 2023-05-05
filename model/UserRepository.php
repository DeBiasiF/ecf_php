<?php

class UserRepository {
       
    public static function createUser(Array $myUser) : ?User {
        $user = new User();
        $user->setId($myUser['id___user'])
                ->setName($myUser['name___user'])
                ->setPassword($myUser['password___user'])
                ->setPoints($myUser['quantity_points___user'])
                ->setRole(RoleRepository::getRoleById($myUser['id___role']));
        return $user;                
    }

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

    public static function addUser() : int {
        $connectionDB = Connect::getInstance();

        $psw = password_hash($_POST['userPsw'], PASSWORD_BCRYPT);
        $stmt = $connectionDB->prepare('INSERT INTO __user (name___user, password___user, quantity_points___user, Id_role) VALUES(:name, :psw, :points, :Id_role)');
        $stmt->bindValue(":name", $_POST['userName'], PDO::PARAM_STR);
        $stmt->bindValue(":psw", $psw, PDO::PARAM_STR);
        $stmt->bindValue(":points", $_POST['userPoints'], PDO::PARAM_INT);
        $stmt->bindValue(":Id_role", $_POST['userIdRole'], PDO::PARAM_INT);
        $stmt->execute();
        return $connectionDB->lastInsertId();
    }

    public static function updateUser(int $id) : int {
        $connectionDB = Connect::getInstance();

        $psw = password_hash($_POST['userPsw'], PASSWORD_ARGON2I);
        $stmt = $connectionDB->prepare('UPDATE __user SET name___user = :name, password___user = :psw, quantity_points___user = :mail, Id_role = :phone WHERE id___user = :id ;');
        $stmt->bindValue(":name", $_POST['userName'], PDO::PARAM_STR);
        $stmt->bindValue(":psw", $psw, PDO::PARAM_STR);
        $stmt->bindValue(":points", $_POST['userPoints'], PDO::PARAM_INT);
        $stmt->bindValue(":Id_role", $_POST['userIdRole'], PDO::PARAM_INT);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $id;
    }

    public static function deleteUser(int $id) {
        $connectionDB = Connect::getInstance();
        $stmt = $connectionDB->prepare('DELETE FROM __user WHERE id___user = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

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

    public static function getLogged(String $name, String $psw) : ?User {
        $connectionDB = Connect::getInstance();
        $stmt = $connectionDB->prepare("SELECT * FROM __user WHERE name___user = :name");
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) !== 0){
            $user = UserRepository::createUser($result[0]);
            $registeredPsw = $user->getPassword();
            if(password_verify($psw, $registeredPsw)){
                session_start(); //on lance la session avec session
                $_SESSION['user'] = [
                    'userId' => $user->getId(),
                    'userName' => $user->getName()
                ];
                return $user;
            } else {
                throw new Exception("Nom d'utilisateur et mot de passe invalide");
                return null;
            }
        }    
    }
    
    
}
?>

