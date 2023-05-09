<?php
//Importe le header et la navbar
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>
<div class="container py-5">
    <div class="row">
        <div class="col-lg-4 col-md-5 col-sm-12">
            <div style="height: 400px; display: flex; justify-content: center; align-items: center;">
                <img src="../<?=$good->getImg();?>" class="img-fluid rounded-circle" alt="Image de l'objet" style="max-height: 100%; max-width: 100%;">
            </div>
            <p><strong>Propriétaire : </strong><?= $good->getLender()->getName(); ?></p>
        </div>
        <div class="col-lg-4 col-md-5 col-sm-12">
            <h2>Réservations</h2>
            <div style="max-height: 400px; overflow-y: scroll;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($borrows != null) : ?>
                            <?php foreach ($borrows as $borrow) : ?>
                                <tr>
                                    <td><?php $borrow->get(); ?></td>
                                    <td><?php $borrow->get(); ?></td>
                                </tr>
                            <?php endforeach ?>
                        <?php else : ?>
                            <tr>
                                <td>AUCUNE RÉSERVATION</td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-8 col-md-7 col-sm-12">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mb-0"><?=$good->getName();?></h1>
                </div>
                <div class="col-md-12">
                    <ul class="list-unstyled">
                        <li><strong>Catégorie : </strong><?= $good->getCategory()->getName(); ?></li>
                        <li><strong>Descriptif : </strong><?= $good->getDescription(); ?></li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <a href="/ecf_php/" class="btn btn-primary">Retour à l'accueil</a>
                    <?php if(!empty($_SESSION['loggedUser'])) if ($_SESSION['loggedUser']->getName() == $good->getLender()->getName()) : ?>
                        <a class="btn btn-outline-primary" href= /ecf_php/index.php/updategood?<?=$_SERVER['QUERY_STRING']?>>Modifier le bien</a> 
                    <?php endif ?>
                    <?php if(!empty($_SESSION['loggedUser'])) : ?>
                        <a class="btn btn-outline-primary" href= /ecf_php/index.php/borrow?<?=$_SERVER['QUERY_STRING']?>>Reserver le bien</a> 
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
//Importe le footer
require_once "./view/partial/footer.php";
?>

