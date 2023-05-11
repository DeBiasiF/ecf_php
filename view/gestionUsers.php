<?php
//Importe le header et la navbar
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>
<div class="container">
	<h1>Liste d'utilisateurs</h1>
	<table class="table">
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
//Importe le footer
require_once "./view/partial/footer.php";
?>
