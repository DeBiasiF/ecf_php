<?php
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>

<form enctype="multipart/form-data"  action="" method="post">
    <div class="mb-3">
        <label for="lastName" class="form-label">Nom de famille</label>
        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Votre nom de famille">
    </div>
    <div class="mb-3">
        <label for="firstName" class="form-label">Prénom</label>
        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Votre prénom">
    </div>
    <div class="mb-3">
        <label for="mail" class="form-label">Adresse e-mail</label>
        <input type="email" class="form-control" id="mail" name="mail" placeholder="Votre adresse e-mail">
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Numéro de téléphone</label>
        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Votre numéro de téléphone">
    </div>
    <div class="mb-3">
        <label for="birthDay" class="form-label">Date de naissance</label>
        <input type="date" class="form-control" id="birthDay" name="birthDay">
    </div>
    <div class="mb-3">
        <label for="file" class="form-label">Télécharger un fichier</label>
        <input type="file" class="form-control" id="file" name="file">
    </div>
    <button type="submit" class="btn btn-primary">Envoyer</button>
</form>
<?php
require_once "./view/partial/footer.php";
?>