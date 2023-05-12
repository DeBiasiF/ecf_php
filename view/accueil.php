<?php
//Importe le header et la navbar
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>
<div class="container">
    <h1>MyLocs</h1>
    <div class="mb-3">
        <label for="category-filter" class="form-label">Filtrer par catégorie :</label>
        <select class="form-control" id="category-filter">
            <option value="all">Toutes les catégories</option>
            <?php foreach ($categories as $category) : ?>
                <option value="<?= $category->getId() ?>"><?= $category->getName() ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="row" id="card-container">

    <?php foreach ($goods as $good) :  //Génere les cards affiché sur la page d'accueil?>
        <div class="eachCard col-12 col-sm-6 col-md-4" data-category-id="<?= $good->getCategory()->getId() ?>">
            <div class="card h-100" style="height: 500px;">
                <div class="imgBox w-80" style="height: 300px;">
                    <img src="<?=$good->getImg()?>" class="card-img-top" alt="Image du bien" style="object-fit: cover; height: 100%; width: 100%;">
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= $good->getName() ?></h5> 
                    <p class="card-text"><?= $good->getCategory()->getName() ?></p>
                    <?php if (($good->getStatus())) : //Affiche le statut a l'instant "t" de chaque objet en vert ou rouge?> 
                        <p class="text-success">DISPONIBLE</p>
                    <?php else: ?>
                        <p class="text-danger">INDISPONIBLE</p>
                    <?php endif; ?>
                    <a href="<?=$_SERVER['SCRIPT_NAME']?>/good?id=<?=$good->getId()?>" class="btn btn-primary">Plus d'info</a>
                </div>
            </div>
        </div>
    <?php endforeach ?>
    </div>
</div>

<?php
//Importe le js
UtilsControler::getJs("accueil.js");
//Importe le footer
require_once "./view/partial/footer.php";
?>


