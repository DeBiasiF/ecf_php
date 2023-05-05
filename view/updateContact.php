<?php
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>

<form enctype="multipart/form-data" action="" method="post">
    <div class="mb-3">
        <label for="lastName" class="form-label">Nom de famille</label>
        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Votre nom de famille" value="<?=$lastName?>">
    </div>
    <div class="mb-3">
        <label for="firstName" class="form-label">Prénom</label>
        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Votre prénom" value="<?=$firstName?>">
    </div>
    <div class="mb-3">
        <label for="mail" class="form-label">Adresse e-mail</label>
        <input type="email" class="form-control" id="mail" name="mail" placeholder="Votre adresse e-mail" value="<?=$mail?>">
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Numéro de téléphone</label>
        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Votre numéro de téléphone" value="<?=$phone?>">
    </div>
    <div class="mb-3">
        <label for="birthDay" class="form-label">Date de naissance</label>
        <input type="date" class="form-control" id="birthDay" name="birthDay" value="<?=$birthday?>">
    </div>
    <div class="mb-3">
    <label for="file" class="form-label">Télécharger un fichier</label>
        <input type="file" class="form-control" id="file" name="file">
        <img id="preview" src="<?=$file?>" alt="Image par défaut" style="max-width: 300px; max-height: 300px;">
    </div>
    <button type="submit" class="btn btn-primary">Envoyer</button>

    <script>
        // Récupérer l'élément input file et l'élément img
        const input = document.getElementById('file');
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
require_once "./view/partial/footer.php";
?>