<?php

class GoodRepository implements RepositoryInterface {
       
    //Permet la création d'un Objet "Good"
    public static function create(Array $myGood) : ?Good {
        $status = self::getGoodDisponibility($myGood['id_goods']);
        return new Good(
            $myGood['id_goods'],
            htmlspecialchars_decode($myGood['name_goods']),
            $myGood['img_goods'],
            htmlspecialchars_decode($myGood['description_goods']),
            $status,
            CategoryRepository::getById($myGood['id_category']),
            UserRepository::getById($myGood['id___user_lender'])
        );        
    }

    //Permet l'appel à l'integralité des biens et renvoie un tableau d'objet "Good"
    public static function getAll() : Array {
        $connectionDB = Connect::getInstance();
        $stmt = $connectionDB->prepare('SELECT * FROM goods;');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $goodList=[];
        foreach ($result as $good) {
            $goodList[]= self::create($good);
        }
        return $goodList;
    }

    //Permet l'ajout d'un bien
    public static function add(Object $good) : int {

        if (!$good instanceof Good) {
            throw new InvalidArgumentException('Expected instance of Good');
        }

        $connectionDB = Connect::getInstance();

        $img = self::saveImg();

        $stmt = $connectionDB->prepare('INSERT INTO goods (img_goods, name_goods, description_goods, Id_category, Id___user_lender) VALUES(:img, :name, :description, :category, :lender);');
        $stmt->bindValue(":img", $img, PDO::PARAM_STR);
        $stmt->bindValue(":name", htmlspecialchars($good->getName()), PDO::PARAM_STR);
        $stmt->bindValue(":description", htmlspecialchars($good->getDescription()), PDO::PARAM_STR);
        $stmt->bindValue(":category", $good->getCategory()->getId(), PDO::PARAM_INT);
        $stmt->bindValue(":lender", $good->getLender()->getId(), PDO::PARAM_INT);
        $stmt->execute();
        return $connectionDB->lastInsertId();
    }

    //Permet l'édition d'un bien
    public static function update(Object $good) : int {
        
        if (!$good instanceof Good) {
            throw new InvalidArgumentException('Expected instance of Good');
        }

        $connectionDB = Connect::getInstance();

        (!empty($img))?$img = GoodRepository::saveImg():$img = self::getById($good->getId())->getImg();
        
        $stmt = $connectionDB->prepare('UPDATE goods SET img_goods = :img, name_goods = :nameGood, description_goods = :descriptionGood, Id_category = :category, Id___user_lender = :lender WHERE id_goods = :id ;');
        $stmt->bindValue(":img", $img, PDO::PARAM_STR);
        $stmt->bindValue(":name", htmlspecialchars($good->getName()), PDO::PARAM_STR);
        $stmt->bindValue(":description", htmlspecialchars($good->getDescription()), PDO::PARAM_STR);
        $stmt->bindValue(":category", $good->getCategory()->getId(), PDO::PARAM_INT);
        $stmt->bindValue(":lender", $good->getLender()->getId(), PDO::PARAM_INT);
        $stmt->bindValue(":id", $good->getId(), PDO::PARAM_INT);
        $stmt->execute();
        return $good->getId();
    }

    //Permet la suppression d'un bien
    public static function delete(int $goodId) : void {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('DELETE FROM goods WHERE id_goods = :id ;');
        $stmt->bindValue(":id", $goodId, PDO::PARAM_INT);
        $stmt->execute();
    }

    //Permet l'appel à un objet "Good" via son ID
    public static  function getById(int $id) : ?Good {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('SELECT * FROM goods WHERE id_goods = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $good = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($good) !== 0) {
            return self::create($good[0]);
        }else{
            return null;
        }    
    }

    //Function permetant de savoir si un bien est disponnible ou non
    public static function getGoodDisponibility(int $id): bool {
        $connectionDB = Connect::getInstance();

        $stmt = $connectionDB->prepare('SELECT * FROM borrowing WHERE Id_goods = :id AND CURRENT_DATE BETWEEN start_borrowing AND end_borrowing;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $status = $stmt->fetch();
        return !$status;
    }
    
    //Permet la sauvegarde des images
    private static function saveImg() : String {
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
