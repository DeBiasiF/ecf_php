<?php

class RoleRepository implements RepositoryInterface {
       
    //Permet la création d'un Objet "Role"
    public static function create(Array $myRole) : ?Role {
        return new Role(
            $myRole['id___role'],
            htmlspecialchars_decode($myRole['name___role'])
        );          
    }

    //Permet l'appel à l'integralité des rôles et renvoie un tableau d'objet "Role"
    public static function getAll() : Array {
        $connectionDB = Connect::getInstance();
        $stmt = $connectionDB->prepare('SELECT * FROM __role;');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $roleList=[];
        foreach ($result as $role) {
            $roleList[]= self::create($role);
        }

        return $roleList;
    }

    //Permet l'ajout d'un rôle
    public static function add(Object $role) : int {
        
        if (!$role instanceof Role) {
            throw new InvalidArgumentException('Expected instance of Good');
        }

        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('INSERT INTO __role (name___role) VALUES(:name) RETURNING id;');
        $stmt->bindValue(":name", htmlspecialchars($role->getName()), PDO::PARAM_STR);
        $stmt->execute();
        return $connectionDB->lastInsertId();
    }

    //Permet l'édition d'un rôle
    public static function update(Object $role) : int {
        
        if (!$role instanceof Role) {
            throw new InvalidArgumentException('Expected instance of Good');
        }

        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('UPDATE __role SET name___role = :name WHERE id___role = :id ;');
        $stmt->bindValue(":name", htmlspecialchars($role->getName()), PDO::PARAM_STR);
        $stmt->bindValue(":id", $role->getId(), PDO::PARAM_INT);
        $stmt->execute();
        return $role->getId();
    }

    //Permet la suppression d'un rôle
    public static function delete(int $id) : void {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('DELETE FROM __role WHERE id___role = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    //Permet l'appel à un objet "Role" via son ID
    public static  function getById(int $id) : ?Role {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('SELECT * FROM __role WHERE id___role = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $role = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($role) !== 0) {
            return self::create($role[0]);
        }else{
            return null;
        }    
    }
    
}
?>

