<?php
//Importe le header et la navbar
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>

<div class="container-fluid">
    <h1>Les Biens</h1>
    <div class="row">

<?php foreach ($goods as $good) :  //Génere les cards affiché sur la page d'accueil?>
    <div class="col-sm-6">
        <div class="card">
            <img src="<?=$good->getImg()?>" class="card-img-top" alt="Image du bien">
            <div class="card-body">
                <?php if ($good->getStatus()): //Affiche le statut a l'instant "t" de chaque objet en vert ou rouge?> 
                    <p class="text-success">DISPONIBLE</p>
                <?php else: ?>
                    <p class="text-danger">INDISPONIBLE</p>
                <?php endif; ?>
                <a href="/ecf_php/index.php/good?id=<?=$good->getId()?>" class="btn btn-primary">Plus d'info</a>
            </div>
        </div>
    </div>
<?php endforeach ?>
    </div>
</div>
<?php
//Importe le footer
require_once "./view/partial/footer.php";
?>