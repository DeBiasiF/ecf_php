<?php

class RoleRepository {
       
    public static function createRole(Array $myRole) : ?Role {
        $role = new Role();
        $role->setId($myRole['id___role'])
             ->setName($myRole['name___role']);
        return $role;                
    }

    public static function getAllRole() : Array {
        $connectionDB = Connect::getInstance();
        $stmt = $connectionDB->prepare('SELECT * FROM __role;');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $roleList=[];
        foreach ($result as $role) {
            $roleList[]= self::createRole($role);
        }

        return $roleList;
    }

    public static function addRole() : int {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('INSERT INTO __role (name___role) VALUES(:name) RETURNING id;');
        $stmt->bindValue(":name", $_POST['roleName'], PDO::PARAM_STR);
        $stmt->execute();
        return $connectionDB->lastInsertId();
    }

    public static function updateRole(int $id) : int {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('UPDATE __role SET name___role = :name WHERE id___role = :id ;');
        $stmt->bindValue(":name", $_POST['roleName'], PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $id;
    }

    public static function deleteRole(int $id) {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('DELETE FROM __role WHERE id___role = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static  function getRoleById(int $id) : ?Role {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('SELECT * FROM __role WHERE id___role = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $role = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($role) !== 0) {
            return self::createRole($role[0]);
        }else{
            return null;
        }    
    }
    
}
?>

