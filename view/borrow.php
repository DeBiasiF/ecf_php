<?php
//Importe le header et la navbar
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>

<div class="container">
    <h1>Reservation</h1>
    <div class="row">
        <div class="col-md-6 col-sm-12">
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
        <div class="col-md-6 col-sm-12">
            <h2>Réservations</h2>
            <div style="max-height: 400px; overflow-y: scroll;">
                <table class="table text-center">
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
    <form id='form' enctype="multipart/form-data" action="" method="post">
        <div class="form-group">
            <label for="beginDate">Date de début :</label>
            <input type="date" class="form-control" id="beginDate" name="beginDate" required>
            <input type="hidden" id="goodId" name="goodId" value = "<?=$good->getId();?>">
        </div>
        <div class="form-group">
            <label for="endDate">Date de fin :</label>
            <input type="date" class="form-control" id="endDate" name="endDate" required>
        </div>
        <button type="submit" class="btn btn-primary" id="send">Valider</button>
        <a href='<?=$_SERVER['HTTP_REFERER']?>' class="btn btn-secondary">Retour</a>
    </form>
</div>

<script>

    const valid = () => {
    // Récupérer l'élément input idGood, l'élément de la date de debut et l'élément de la date de fin
    const send = document.querySelector("#send");
    const goodId = document.querySelector('#goodId').value;
    const beginDate = document.querySelector('#beginDate').value;
    const endDate = document.querySelector('#endDate').value;


    return fetch(`API/api.php?action=borrowDisponibility&id=${goodId}&start=${beginDate}&end=${endDate}`)
        .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
        })
        .then(data => {
        return data.success;
        })
        .catch(error => {
        console.error(error);
        return false; // retourne false en cas d'erreur
        });
    };

    send.addEventListener("click", e => {
        e.preventDefault();
        valid().then(isValid => {
            if (isValid) {
                document.querySelector('#form').submit();
            } else {
                alert('Cette date de prêt n\'est pas disponnible.');
            }
        });
    });

</script>
<?php
//Importe le footer
require_once "./view/partial/footer.php";
?>

