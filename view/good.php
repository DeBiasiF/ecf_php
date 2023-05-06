<?php
//Importe le header et la navbar
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-4 col-md-5 col-sm-6">
            <img src="../<?=$good->getImg();?>" class="img-fluid rounded-circle" alt="Image de l'objet">
            <p><strong>Propriétaire : </strong><?= $good->getLender()->getName(); ?></p>

        </div>
        <div class="col-lg-8 col-md-7 col-sm-6">
            <h1 class="mb-0"><?=$good->getName();?></h1>
            <ul class="list-unstyled">
                <li><strong>Catégorie : </strong><?= $good->getCategory()->getName(); ?></li>
                <li><strong>Descriptif : </strong><?= $good->getDescription(); ?></li>
            </ul>
            <a href="/ecf_php/" class="btn btn-primary">Retour à l'accueil</a>
            <?php if(!empty($_SESSION['loggedUser'])) if ($_SESSION['loggedUser']->getName() == $good->getLender()->getName()) : ?>
                <a class="btn btn-outline-primary" href= /ecf_php/index.php/updategood?<?=$_SERVER['QUERY_STRING']?>>Modifier le bien</a> 
            <?php endif ?>           
        </div>
    </div>
</div>

<?php
//Importe le footer
require_once "./view/partial/footer.php";
?>

