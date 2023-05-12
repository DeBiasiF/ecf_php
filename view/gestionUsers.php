<?php
//Importe le header et la navbar
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>
<div class="container">
	<h1>Liste d'utilisateurs</h1>
	<table class="table text-center">
		<thead>
			<tr>
				<th>Nom</th>
				<th>Rôle</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($users as $user) : ?>
				<tr>
					<td><?=$user->getName();?></td>
					<td><?=$user->getRole()->getName();?></td>
					<td>
						<a href="<?=$_SERVER['SCRIPT_NAME']?>/updateuser?id=<?=$user->getId();?>" class="btn btn-primary">Editer</a>
						<a href="<?=$_SERVER['SCRIPT_NAME']?>/deleteuser?id=<?=$user->getId();?>" class="btn btn-danger" onclick="event.preventDefault(); return confirmDelete(<?=$user->getId();?>);">Supprimer</a>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<a href='<?=$_SERVER['HTTP_REFERER']?>' class="btn btn-secondary">Retour</a>
</div>

<?php
//Importe le js
UtilsControler::getJs("gestionuser.js");
//Importe le footer
require_once "./view/partial/footer.php";
?>
