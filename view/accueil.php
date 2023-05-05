<?php
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>

<div class="container-fluid">
    <h1>Les Biens</h1>
    <div class="row">

<?php foreach ($goods as $good) :?>
    <div class="col-sm-6">
        <div class="card">
            <img src="<?=$good->getImg()?>" class="card-img-top" alt="Image du bien">
            <div class="card-body">
                <?php if ($good->getStatus()): ?>
                    <p class="text-success">DISPONIBLE</p>
                <?php else: ?>
                    <p class="text-danger">INDISPONNIBLE</p>
                <?php endif; ?>
                <a href="/ecf_php/index.php/good?id=<?=$good->getId()?>" class="btn btn-primary">Plus d'info</a>
            </div>
        </div>
    </div>
<?php endforeach ?>
    </div>
</div>
<?php
require_once "./view/partial/footer.php";
?>