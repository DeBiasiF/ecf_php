<?php
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>
<?php if(!empty($_SESSION['loggedUser'])) if (($_SESSION['loggedUser']->getRole()->getId() == 1)||($_SESSION['loggedUser']->getId() == $user->getId())) : ?>
    <div class="row mb-3">
        <div class="col-md-5">
            <label for="userName" class="form-label">Nom d'utilisateur :</label>
            <p class="fw-bold"><?=$user->getName();?></p>
        </div>
        <div class="col-md-5">
            <label for="userPoint" class="form-label">Points cumulés :</label>
            <p class="fw-bold"><?=$user->getPoints();?></p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-5">
            <table class="table" style="height: 500px; overflow-y: scroll;">
                <h3>Mes Biens</h3>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($ownedGoods!=null) : ?>
                        <?php foreach ($ownedGoods as $good): ?>
                            <tr>
                                <td><?=$good->getName();?></td>
                                <td>
                                    <?php if (($good->getStatus())) : //Affiche le statut a l'instant "t" de chaque objet en vert ou rouge?> 
                                        <p class="text-success">DISPONIBLE</p>
                                    <?php else: ?>
                                        <p class="text-danger">INDISPONIBLE</p>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?=$_SERVER['SCRIPT_NAME']?>/updategood?id=<?=$good->getId();?>" class="btn btn-primary">Editer</a>
                                    <?php if (($good->getStatus())) : //Affiche le statut a l'instant "t" de chaque objet en vert ou rouge?> 
                                        <a href="<?=$_SERVER['SCRIPT_NAME']?>/deletegood?userId=<?=$user->getId();?>&goodId=<?=$good->getId();?>" class="btn btn-danger">Supprimer</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td>AUCUN BIEN</td>
                        </tr>
                    <?php endif ?>        
                </tbody>
            </table>
        </div>
        <div class="col-md-5">
            <table class="table" style="height: 500px; overflow-y: scroll;">
                <h3>Mes Reservations</h3>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($ownedGoods!=null) : ?>
                        <?php foreach ($ownedBorrows as $borrow): ?>
                            <tr>
                                <td><?=$borrow->getGood()->getName();?></td>
                                <td>
                                    du : <?= date("d-m-Y", strtotime($borrow->getStartBorrow())); ?> <br>au : <?= date("d-m-Y", strtotime($borrow->getEndBorrow())); ?>
                                </td>
                                <td>
                                    <a href="<?=$_SERVER['SCRIPT_NAME']?>/deleteborrow?userId=<?=$user->getId();?>&borrowId=<?=$borrow->getId();?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td>AUCUNE RÉSERVATION</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-between">
        <a href='<?=$_SERVER['HTTP_REFERER']?>' class="btn btn-secondary">Retour</a>
        <div class="d-flex justify-content-between">
            <a href="<?=$_SERVER['SCRIPT_NAME']?>/updateuser?id=<?=$user->getId();?>" class="btn btn-primary">Modifier le nom d'utilisateur</a>
            <a href="<?=$_SERVER['SCRIPT_NAME']?>/deleteuser?id=<?=$user->getId();?>" onclick="event.preventDefault(); return confirmDelete(<?=$user->getId();?>);" class="btn btn-danger">Supprimer</a>
        </div>
    </div>
    <?php else : ?>
    <?php header("Location: ".$_SERVER['SCRIPT_NAME']);?>
<?php endif ?>

<script>

    const valid = (id) => {
    // Récupérer l'élément input idGood, l'élément de la date de debut et l'élément de la date de fin
    	const send = document.querySelector("#send");
		return fetch(`API/api.php?action=goodRented&id=${id}`)
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

    const confirmDelete = (id) => {
		console.log('toto');
		return valid(id).then(isValid => {
			if (isValid) {
			return confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?");
			} else {
			alert('Cet utilisateur a un bien en cours de prêt.');
			return false;
			}
		});
	};

</script>
<?php
require_once "./view/partial/footer.php";
?>