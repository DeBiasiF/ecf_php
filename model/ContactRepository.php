<?php


class ContactRepository {
    
    public static function createContact(Array $myResult) : Contact {
        $contact = new Contact();
        $contact->setId($myResult['id'])
                ->setLastName($myResult['lastname'])
                ->setFirstName($myResult['firstname'])
                ->setMail($myResult['mail'])
                ->setPhone($myResult['phone'])
                ->setBirthDay($myResult['birthday'])
                ->setFile($myResult['file']);
        return $contact;                
    }

    public static function getAllContact() : Array {
        $connectionDB = Connect::getInstance();
        $stmt = $connectionDB->prepare('SELECT * FROM contact;');
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Contact');
        $stmt->execute();
        $contactList = $stmt->fetchAll();
        return $contactList;
    }

    public static function addContact() : int {
        $connectionDB = Connect::getInstance();

        $img = self::saveImg();
        $stmt = $connectionDB->prepare('INSERT INTO contact (lastName, firstName, mail, phone, birthDay, file) VALUES(:lastName, :firstName, :mail, :phone, :birthDay, :file) RETURNING id;');
        $stmt->bindValue(":lastName", $_POST['lastName'], PDO::PARAM_STR);
        $stmt->bindValue(":firstName", $_POST['firstName'], PDO::PARAM_STR);
        $stmt->bindValue(":mail", $_POST['mail'], PDO::PARAM_STR);
        $stmt->bindValue(":phone", $_POST['phone'], PDO::PARAM_STR);
        $stmt->bindValue(":birthDay", $_POST['birthDay'], PDO::PARAM_STR);
        $stmt->bindValue(":file", $img, PDO::PARAM_STR);
        $stmt->execute();
        return $connectionDB->lastInsertId();
    }

    public static function updateContact(int $id) : int {
        $connectionDB = Connect::getInstance();

        (!empty($_FILES['file']['tmp_name']))?$img = self::saveImg():$img = self::getContactById($id)->getFile();
        $stmt = $connectionDB->prepare('UPDATE contact SET lastName = :lastName, firstName = :firstName, mail = :mail, phone = :phone, birthDay = :birthDay, file = :file WHERE id = :id ;');
        $stmt->bindValue(":lastName", $_POST['lastName'], PDO::PARAM_STR);
        $stmt->bindValue(":firstName", $_POST['firstName'], PDO::PARAM_STR);
        $stmt->bindValue(":mail", $_POST['mail'], PDO::PARAM_STR);
        $stmt->bindValue(":phone", $_POST['phone'], PDO::PARAM_STR);
        $stmt->bindValue(":birthDay", $_POST['birthDay'], PDO::PARAM_STR);
        $stmt->bindValue(":file", $img, PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $id;
    }

    public static function deleteContact(int $id) {
        $connectionDB = Connect::getInstance();
        $stmt = $connectionDB->prepare('DELETE FROM contact WHERE id = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static  function getContactById(int $id) : Contact {
        $connectionDB = Connect::getInstance();
        $stmt = $connectionDB->prepare('SELECT * FROM contact WHERE id = :id ;');
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Contact');
        $stmt->execute();
        $contact = $stmt->fetchAll();

        if (count($contact) !== 0) {
            return $contact[0];
        }else{
            return null;
        }    
    }
    
    private static function saveImg() {
        $allowedExtensions = array("jpg", "jpeg", "png", "gif"); // Liste des extensions de fichiers autorisées
        $maxFileSize = 5 * 1024 * 1024; // Taille maximale de fichier autorisée (ici, 5 Mo)
        if(isset($_FILES['file'])) {
            $file = $_FILES['file'];
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



