<?php
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>

<form enctype="multipart/form-data" action="" method="post">
    <div class="mb-3">
        <label for="userName" class="form-label">Nom d'utilisateur</label>
        <input type="text" class="form-control" id="userName" name="userName" placeholder="Votre nom" value= "<?=$user->getName();?>">
    </div>
    
    <div class="mb-3">
        <label for="userRoleId" class="form-label">Role</label>
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