<?php

class CategoryRepository implements RepositoryInterface {
        
    //Permet la création d'un Objet "Category"
    public static function create(Array $myCategory) : ?Category {
        return new Category(
            $myCategory['id_category'],
            htmlspecialchars_decode($myCategory['name_category']),
            $myCategory['valor_point_cat_egory']
        );                
    }

    //Permet l'appel à l'integralité des catégories et renvoie un tableau d'objet "Category"
    public static function getAll() : Array {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('SELECT * FROM category;');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $categoryList=[];
        foreach ($result as $category) {
            $categoryList[]= self::create($category);
        }

        return $categoryList;
    }

    //Permet l'ajout d'une catégorie
    public static function add(Object $category) : int {

        if (!$category instanceof Category) {
            throw new InvalidArgumentException('Expected instance of Good');
        }

        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('INSERT INTO category (name_category, valor_point_cat_egory) VALUES(:name, :reward);');
        $stmt->bindValue(":name", htmlspecialchars($category->getName()), PDO::PARAM_STR);
        $stmt->bindValue(":reward", $category->getReward(), PDO::PARAM_INT);
        $stmt->execute();
        return $connectionDB->lastInsertId();
    }

    //Permet l'édition d'une catégorie
    public static function update(Object $category) : int {

        if (!$category instanceof Category) {
            throw new InvalidArgumentException('Expected instance of Good');
        }

        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('UPDATE category SET name_category = :name, valor_point_cat_egory = :reward WHERE id_category = :id ;');
        $stmt->bindValue(":name", htmlspecialchars($category->getName()), PDO::PARAM_STR);
        $stmt->bindValue(":reward", $category->getReward(), PDO::PARAM_INT);
        $stmt->bindValue(":id", $category->getId(), PDO::PARAM_INT);
        $stmt->execute();
        return $category->getId();
    }

    //Permet la suppression d'une catégoorie
    public static function delete(int $id) : void {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('DELETE FROM category WHERE id_category = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    //Permet l'appel à un objet "Category" via son ID
    public static  function getById(int $id) : ?Category {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('SELECT * FROM category WHERE id_category = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $category = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($category) !== 0) {
            return self::create($category[0]);
        }else{
            return null;
        }    
    }
}
?>
