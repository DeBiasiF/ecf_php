<?php
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-4 col-md-5 col-sm-6">
            <img src="<?=$img?>" class="img-fluid rounded-circle" alt="Image de l'objet">
            <p><strong>Propriétaire : </strong><?= $lender ?></p>

        </div>
        <div class="col-lg-8 col-md-7 col-sm-6">
            <h1 class="mb-0"><?=$name?></h1>
            <ul class="list-unstyled">
                <li><strong>Catégorie : </strong><?= $category ?></li>
                <li><strong>Descriptif : </strong><?= $description ?></li>
            </ul>
            <a href="/ecf_php/" class="btn btn-primary">Retour à l'accueil</a>
            <a class="btn btn-primary" href= /ecf_php/index.php/updatecontact?<?=$_SERVER['QUERY_STRING']?>>Modifier le contact</a>            
        </div>
    </div>
</div>

<?php
require_once "./view/partial/footer.php";
?>

