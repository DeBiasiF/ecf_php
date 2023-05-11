<?php
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>
<?php if(!empty($_SESSION['loggedUser'])) if (($_SESSION['loggedUser']->getRole()->getId() == 1)) : ?>
    <form enctype="multipart/form-data" action="" method="POST">
        <div class="mb-3">
            <label for="categoryName" class="form-label">Nom de la categorie</label>
            <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="Nom de votre catégorie" >
            <label for="categoryPoint" class="form-label">Points en récompense</label>
            <input type="text" class="form-control" id="categoryPoint" name="categoryPoint" >
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Ajouter</button>
            <a href='<?=$_SERVER['HTTP_REFERER']?>' class="btn btn-secondary">Retour</a>
        </div>
    </form>
<?php else : ?>
    <?php header("Location: ".$_SERVER['SCRIPT_NAME']);?>
<?php endif ?>
<?php
require_once "./view/partial/footer.php";
?>