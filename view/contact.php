<?php
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-4 col-md-5 col-sm-6">
            <img src="<?=$file?>" class="img-fluid rounded-circle" alt="Photo de profil">
        </div>
        <div class="col-lg-8 col-md-7 col-sm-6">
            <h1 class="mb-0"><?=$firstName." ".$lastName?></h1>
            <ul class="list-unstyled">
                <li><i class="fas fa-birthday-cake me-2"></i><?=$birthday?></li>
                <li><i class="fas fa-envelope me-2"></i> <?=$mail?></li>
                <li><i class="fas fa-phone me-2"></i> <?=$phone?></li>
            </ul>
            <a href="/Form_Contact/" class="btn btn-primary">Retour à l'accueil</a>
            <a class="btn btn-primary" href= /Form_Contact/index.php/updatecontact?<?=$_SERVER['QUERY_STRING']?>>Modifier le contact</a>            
        </div>
    </div>
</div>
<?php
require_once "./view/partial/footer.php";
?>

