<?php

class GoodRepository {
       

    //Permet la création d'un Objet "Good"
    public static function createGood(Array $myGood) : ?Good {
        $good = new Good();
        $good->setId($myGood['id_goods'])
                ->setName($myGood['name_goods'])
                ->setImg($myGood['img_goods'])
                ->setDescription(htmlspecialchars_decode($myGood['description_goods']))
                ->setStatus($myGood['status_goods'])
                ->setCategory(CategoryRepository::getCategoryById($myGood['id_category']))
                ->setLender(UserRepository::getUserById($myGood['id___user_lender']));
        return $good;                
    }

    //Permet l'appel à l'integralité des biens et renvoie un tableau d'objet "Good"
    public static function getAllGood() : Array {
        $connectionDB = Connect::getInstance();
        $stmt = $connectionDB->prepare('SELECT * FROM goods;');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $goodList=[];
        foreach ($result as $good) {
            $goodList[]= self::createGood($good);
        }

        return $goodList;
    }

    //Permet l'ajout d'un bien
    public static function addGood() : int {
        $connectionDB = Connect::getInstance();

        $img = self::saveImg();
        $stmt = $connectionDB->prepare('INSERT INTO goods (img_goods, name_goods, description_goods, status_goods, Id_category, Id___user_lender) VALUES(:img, :name, :description, :status, :category, :lender);');
        $stmt->bindValue(":img", $img, PDO::PARAM_STR);
        $stmt->bindValue(":name", $_POST['goodName'], PDO::PARAM_STR);
        $stmt->bindValue(":description", $_POST['goodDescription'], PDO::PARAM_STR);
        $stmt->bindValue(":status", true, PDO::PARAM_BOOL);
        $stmt->bindValue(":category", $_POST['goodCategoryId'], PDO::PARAM_INT);
        $stmt->bindValue(":lender", 1, PDO::PARAM_INT);
        $stmt->execute();
        return $connectionDB->lastInsertId();
    }

    //Permet l'édition d'un bien
    public static function updateGood(int $id, String $name, String $description, String $img, int $category, int $lender) : int {
        $connectionDB = Connect::getInstance();

        $description = htmlspecialchars($description);

        $stmt = $connectionDB->prepare('UPDATE goods SET img_goods = :img name_goods = :name description_goods = :description Id_category = :category Id___user_lender = :lender WHERE id_goods = :id ;');
        $stmt->bindValue(":img", $img, PDO::PARAM_STR);
        $stmt->bindValue(":name", $name, PDO::PARAM_STR);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->bindValue(":category", $category, PDO::PARAM_INT);
        $stmt->bindValue(":lender", $lender, PDO::PARAM_INT);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $id;
    }

    //Permet la suppression d'un bien
    public static function deleteGood(int $id) {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('DELETE FROM goods WHERE id_goods = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    //Permet l'appel à un objet "Good" via son ID
    public static  function getGoodById(int $id) : ?Good {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('SELECT * FROM goods WHERE id_goods = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $good = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($good) !== 0) {
            return self::createGood($good[0]);
        }else{
            return null;
        }    
    }
    
    //Permet la sauvegarde des images
    private static function saveImg() {
        $allowedExtensions = array("jpg", "jpeg", "png", "gif"); // Liste des extensions de fichiers autorisées
        $maxFileSize = 5 * 1024 * 1024; // Taille maximale de fichier autorisée (ici, 5 Mo)
        if(isset($_FILES['image'])) {
            $file = $_FILES['image'];
            $fileName = basename($file['name']);
            $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $fileSize = $file['size'];
            $fileTmpName = $file['tmp_name'];
            
            // Vérifier si le type de fichier est autorisé
            if(!in_array($fileType, $allowedExtensions)) {
                throw new Exception("Erreur : le type de fichier n'est pas autorisé. Seules les images JPG, JPEG, PNG et GIF sont autorisées.");
            }
            
            // Vérifier si la taille du fichier est autorisée
            if($fileSize > $maxFileSize) {
                throw new Exception("Erreur : la taille du fichier dépasse la limite autorisée de 5 Mo.");
            }
            
            // Générer un nom de fichier unique pour éviter les conflits de noms de fichiers
            $uniqueFileName = uniqid("", true) . "." . $fileType;
            $targetFilePath = "uploads/" . $uniqueFileName;
            
            // Déplacer le fichier téléchargé vers le dossier de destination
            if(move_uploaded_file($fileTmpName, $targetFilePath)) {
                return "./$targetFilePath";
            } else {
                throw new Exception("Erreur : une erreur est survenue lors du téléchargement du fichier.");
            }
        } else {
            throw new Exception("Erreur : aucun fichier n'a été sélectionné.");
        }
    }
    
}
?>
