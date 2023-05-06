<?php

class CategoryRepository {
       
    
    //Permet la création d'un Objet "Category"
    public static function createCategory(Array $myCategory) : ?Category {
        $category = new Category();
        $category->setId($myCategory['id_category'])
                ->setName($myCategory['name_category'])
                ->setReward($myCategory['valor_point_cat_egory']);
        return $category;                
    }

    //Permet l'appel à l'integralité des catégories et renvoie un tableau d'objet "Category"
    public static function getAllCategory() : Array {
        $connectionDB = Connect::getInstance();
        $stmt = $connectionDB->prepare('SELECT * FROM category;');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $categoryList=[];
        foreach ($result as $category) {
            $categoryList[]= self::createCategory($category);
        }

        return $categoryList;
    }

    //Permet l'ajout d'une catégorie
    public static function addCategory() : int {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('INSERT INTO category (name_category, valor_point_cat_egory) VALUES(:name, :reward);');
        $stmt->bindValue(":name", $_POST['categoryName'], PDO::PARAM_STR);
        $stmt->bindValue(":reward", $_POST['categoryReward'], PDO::PARAM_INT);
        $stmt->execute();
        return $connectionDB->lastInsertId();
    }

    //Permet l'édition d'une catégorie
    public static function updateCategory(int $id) : int {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('UPDATE category SET name_category = :name valor_point_cat_egory = :reward WHERE id_category = :id ;');
        $stmt->bindValue(":name", $_POST['categoryName'], PDO::PARAM_STR);
        $stmt->bindValue(":reward", $_POST['categoryReward'], PDO::PARAM_INT);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $id;
    }

    //Permet la suppression d'une catégoorie
    public static function deleteCategory(int $id) {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('DELETE FROM category WHERE id_category = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    //Permet l'appel à un objet "Category" via son ID
    public static  function getCategoryById(int $id) : ?Category {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('SELECT * FROM category WHERE id_category = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $category = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($category) !== 0) {
            return self::createCategory($category[0]);
        }else{
            return null;
        }    
    }
}
?>
