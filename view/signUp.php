<?php
//Importe le header et la navbar
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>

<form enctype="multipart/form-data" action="" method="post">
    <div class="mb-3">
        <label for="userName" class="form-label">Nom d'utilisateur</label>
        <input type="text" class="form-control" id="userName" name="userName" placeholder="Votre nom">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="userPassword" placeholder="Votre mot de passe">
    </div>
    <div class="mb-3">
        <label for="password_confirm" class="form-label">Confirmation du mot de passe</label>
        <input type="password" class="form-control" id="password_confirm" name="userPasswordConfirm" placeholder="Confirmez votre mot de passe">
    </div>
    <button type="submit" class="btn btn-primary">Envoyer</button>
</form>

<?php
//Importe le footer
require_once "./view/partial/footer.php";
?>