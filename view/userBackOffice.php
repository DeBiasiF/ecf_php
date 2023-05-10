<?php
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>
<?php if(!empty($_SESSION['loggedUser'])) if (($_SESSION['loggedUser']->getRole()->getId() == 1)||($_SESSION['loggedUser']->getId() == $user->getId())) : ?>
    <form enctype="multipart/form-data" action="" method="post">
        <div class="mb-3">
            <label for="userName" class="form-label">Nom d'utilisateur</label>
            <input type="text" class="form-control" id="userName" name="userName" placeholder="Votre nom" value="<?=$user->getName();?>">
            <label for="userPoint" class="form-label">Points cumulé</label>
            <input type="text" class="form-control" id="userPoint" name="userPoint" value="<?=$user->getPoints();?>" readonly>
        </div>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ownedGoods as $good): ?>
                <tr>
                    <td><?=$good->getName();?></td>
                    <td><?php if (($good->getStatus())) : //Affiche le statut a l'instant "t" de chaque objet en vert ou rouge?> 
                        <p class="text-success">DISPONIBLE</p>
                    <?php else: ?>
                        <p class="text-danger">INDISPONIBLE</p>
                    <?php endif; ?></td>
                    <td>
						<a href="/ecf_php/index.php/updategood?id=<?=$good->getId();?>" class="btn btn-primary">Editer</a>
						<a href="/ecf_php/index.php/deletegood?userId=<?=$user->getId();?>&goodId=<?=$good->getId();?>" class="btn btn-danger">Supprimer</a>
					</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="/ecf_php/index.php/deleteuser" class="btn btn-primary">Supprimer</a>
    </form>
    <?php else : ?>
    <?php header("Location: /ecf_php");?>
<?php endif ?>
<?php
require_once "./view/partial/footer.php";
?>