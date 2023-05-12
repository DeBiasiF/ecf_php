<?php
//Importe le header et la navbar
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>
<div class="container">
    <form enctype="multipart/form-data" action="" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="goodName" placeholder="Nom du bien" value="<?=$good->getName();?>">
            <input type="hidden" name="goodId" value="<?=$good->getId();?>">
            <input type="hidden" name="goodLenderId" value="<?= $good->getLender()->getId() ?>">
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Catégorie</label>
            <select class="form-control" id="category" name="goodCategoryId">
                <?php foreach ($categories as $category): //Génère la liste des categories disponnible lors de l'enreigistrement d'un bien?>
                <option value="<?=$category->getId();?>" <?php if($good->getCategory()->getId() == $category->getId())echo("selected"); //Ajoute select sur l'option deja connu?> ><?=$category->getName()?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="goodDescription" rows="3"><?=$good->getDescription();?></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
            <img id="preview" src="../<?=$good->getImg();?>" alt="Image par défaut" style="max-width: 300px; max-height: 300px;">
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
        <a href='<?=$_SERVER['HTTP_REFERER']?>' class="btn btn-secondary">Retour</a>
    </form>
</div>

<script>
    // Récupérer l'élément input file et l'élément img
    const input = document.getElementById('image');
    const preview = document.getElementById('preview');

    // Fonction pour mettre à jour l'image
    function updateImage(file) {
        const url = URL.createObjectURL(file);
        preview.setAttribute('src', url);
    }

    // Fonction pour afficher l'image par défaut
    function showDefaultImage() {
        preview.setAttribute('src', 'uploads/default_image.jpg');
    }

    // Écouter l'événement "change" sur l'input file
    input.addEventListener('change', function() {
        // Récupérer le fichier sélectionné
        const file = this.files[0];

        // Vérifier si un fichier a été sélectionné
        if (file) {
            // Mettre à jour l'image
            updateImage(file);
        } else {
            // Afficher l'image par défaut
            showDefaultImage();
        }
    });
</script>

<?php
//Importe le footer
require_once "./view/partial/footer.php";
?>