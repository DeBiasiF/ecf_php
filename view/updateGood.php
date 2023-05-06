<?php
//Importe le header et la navbar
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>
    <form enctype="multipart/form-data" action="" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="goodName" placeholder="Nom du bien" value="<?=$good->getName();?>">
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Catégorie</label>
            <select class="form-control" id="category" name="goodCategoryId">
                <?php foreach ($categories as $category): //Génère la liste des categories disponnible lors de l'enreigistrement d'un bien?>
                <option value="<?=$category->getId()?>" <?php if($good->getCategory()->getId() == $category->getId())echo("selected"); //Ajoute select sur l'option deja connu?> ><?=$category->getName()?></option>
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
        <a href='/ecf_php/index.php/good?id=<?=$good->getId();?>' class="btn btn-secondary">Retour</button>
    </form>

    <script>
        // Récupérer l'élément input file et l'élément img
        const input = document.getElementById('image');
        const preview = document.getElementById('preview');

        // Écouter l'événement "change" sur l'input file
        input.addEventListener('change', function() {
            // Récupérer le fichier sélectionné
            const file = this.files[0];

            // Vérifier si un fichier a été sélectionné
            if (file) {
                // Créer un objet URL pour le fichier
                const url = URL.createObjectURL(file);

                // Mettre à jour l'attribut "src" de l'img
                preview.setAttribute('src', url);
            } else {
                // Si aucun fichier n'a été sélectionné, afficher l'image par défaut
                preview.setAttribute('src', 'uploads/default_image.jpg');
            }
        });
    </script>
</form>
<?php
//Importe le footer
require_once "./view/partial/footer.php";
?>