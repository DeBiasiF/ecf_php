<?php
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>
<?php if(!empty($_SESSION['loggedUser'])) if (($_SESSION['loggedUser']->getRole()->getId() == 1)) : ?>
    <div class="container">
        <form enctype="multipart/form-data" action="" method="POST">
            <div class="mb-3">
                <label for="categoryName" class="form-label">Nom de la categorie</label>
                <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="Votre nom" value= "<?=$category->getName();?>">
                <label for="categoryPoint" class="form-label">Points en récompense</label>
                <input type="text" class="form-control" id="categoryPoint" name="categoryPoint" value= "<?=$category->getRewards();?>">
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="<?=$_SERVER['SCRIPT_NAME']?>/deletecategory?id=<?=$category->getId();?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')" class="btn btn-danger">Supprimer</a>
            </div>
        </form>
    </div>
<?php else : ?>
    <?php header("Location: ".$_SERVER['SCRIPT_NAME']);?>
<?php endif ?>
<?php
require_once "./view/partial/footer.php";
?>