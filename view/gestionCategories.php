<?php
//Importe le header et la navbar
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>
<div class="container">
	<h1>Liste des catégories</h1>
	<table class="table">
		<thead>
			<tr>
				<th>Nom</th>
				<th>Points</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($categories as $category) : ?>
				<tr>
					<td><?=$category->getName();?></td>
					<td><?=$category->getReward();?></td>
					<td>
						<a href="<?=$_SERVER['SCRIPT_NAME']?>/updatecategory?id=<?=$category->getId();?>" class="btn btn-primary">Editer</a>
						<a href="<?=$_SERVER['SCRIPT_NAME']?>/deletecategory?id=<?=$category->getId();?>" class="btn btn-danger">Supprimer</a>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<a href='<?=$_SERVER['HTTP_REFERER']?>' class="btn btn-secondary">Retour</a>
	<a href='<?=$_SERVER['SCRIPT_NAME']?>/addcategory' class="btn btn-primary">Créer une catégorie</a>
</div>
<?php
//Importe le footer
require_once "./view/partial/footer.php";
?>
