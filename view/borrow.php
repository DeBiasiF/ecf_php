<?php
//Importe le header et la navbar
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>

<div class="container">
    <h1>Reservation</h1>
    <div class="row">
        <div class="col-lg-4 col-md-5 col-sm-12">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <p class="form-control-static" id="nom"><?= $good->getName(); ?></p>
            </div>
            <div class="form-group">
                <div style="height: 400px; display: flex; justify-content: center; align-items: center;">
                    <img src="../<?=$good->getImg();?>" class="img-fluid rounded-circle" alt="Image de l'objet" style="max-height: 100%; max-width: 100%;">
                </div>
                <p><strong>Propriétaire : </strong><?= $good->getLender()->getName(); ?></p>
            </div>
        </div>
        <div class="col-lg-4 col-md-5 col-sm-12">
            <h2>Réservations</h2>
            <div style="max-height: 400px; overflow-y: scroll;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                            <th>par</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($borrows != null) : ?>
                            <?php foreach ($borrows as $borrow) : ?>
                                <tr>
                                    <td><?= date("d-m-Y", strtotime($borrow->getStartBorrow())); ?></td>
                                    <td><?= date("d-m-Y", strtotime($borrow->getEndBorrow())); ?></td>
                                    <td><?= $borrow->getBorrower()->getName(); ?></td>
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
    </div>
    <form enctype="multipart/form-data" action="" method="post">
        <div class="form-group">
            <label for="beginDate">Date de début :</label>
            <input type="date" class="form-control" id="beginDate" name="beginDate" required>
            <input type="hidden" name="goodId" value = "<?=$good->getId();?>">
        </div>
        <div class="form-group">
            <label for="endDate">Date de fin :</label>
            <input type="date" class="form-control" id="endDate" name="endDate" required>
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
        <a href='/ecf_php/index.php/good?id=<?=$good->getId();?>' class="btn btn-secondary">Retour</a>
    </form>
</div>

<?php
//Importe le footer
require_once "./view/partial/footer.php";
?>

