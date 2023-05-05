<?php
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>

<form enctype="multipart/form-data" action="" method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Nom d'utilisateur</label>
        <input type="text" class="form-control" id="name" name="userName" placeholder="Votre nom">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="userPassword" placeholder="Votre mot de passe">
    </div>
    <div class="mb-3">
        <label for="password_confirm" class="form-label">Confirmation du mot de passe</label>
        <input type="password" class="form-control" id="password_confirm" name="userPasswordConfirm" placeholder="Confirmez votre mot de passe">
    </div>
    <div class="mb-3">
        <label for="category" class="form-label">Catégorie</label>
        <select class="form-control" id="role" name="userRoleId">
            <?php foreach ($roles as $role): ?>
            <option value="<?=$role->getId()?>"><?=$role->getName()?></option>
            <?php endforeach ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Envoyer</button>
</form>

<?php
require_once "./view/partial/footer.php";
?>