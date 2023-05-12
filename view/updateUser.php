<?php
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>
<?php if(!empty($_SESSION['loggedUser'])) if (($_SESSION['loggedUser']->getRole()->getId() == 1)||($_SESSION['loggedUser']->getId() == $user->getId())) : ?>
    <div class="container">
        <form enctype="multipart/form-data" action="" method="POST">
            <div class="mb-3">
                <label for="userName" class="form-label">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="userName" name="userName" placeholder="Votre nom" value= "<?=$user->getName();?>">
                <label for="userPoint" class="form-label">Points cumulé</label>
                <input type="text" class="form-control" id="userPoint" name="userPoint" value= "<?=$user->getPoints();?>" <?= ($_SESSION['loggedUser']->getRole()->getId() == 1)?"":"readonly"?>>
            </div>
            
            <?php if(!empty($_SESSION['loggedUser'])) if ($_SESSION['loggedUser']->getRole()->getId() == 1) : ?>
                <div class="mb-3">
                    <label for="userRoleId" class="form-label">Role</label>
                    <select class="form-control" id="role" name="userRoleId">
                        <?php foreach ($roles as $role): ?>
                            <option value="<?=$role->getId()?>" <?php if($user->getRole()->getId() == $role->getId())echo("selected"); //Ajoute select sur l'option deja connu?>><?=$role->getName()?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            <?php endif ?>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="<?=$_SERVER['SCRIPT_NAME']?>/deleteuser?id=<?=$user->getId();?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')" class="btn btn-danger">Supprimer</a>
            </div>
        </form>
    </div>
<?php else : ?>
    <?php header("Location: ".$_SERVER['SCRIPT_NAME']);?>
<?php endif ?>
<?php
require_once "./view/partial/footer.php";
?>