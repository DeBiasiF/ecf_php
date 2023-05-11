<?php
//Importe le header et la navbar
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                <h3 class="text-center">Inscription</h3>
                </div>
                <div class="card-body">
                <form enctype="multipart/form-data" action="" method="post">
                    <div class="mb-3">
                    <label for="userName" class="form-label">Nom d'utilisateur</label>
                    <input type="text" class="form-control" id="userName" name="userName" placeholder="Votre nom" required>
                    </div>
                    <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="userPassword" placeholder="Votre mot de passe" required>
                    </div>
                    <div class="mb-3">
                    <label for="password_confirm" class="form-label">Confirmation du mot de passe</label>
                    <input type="password" class="form-control" id="password_confirm" name="userPasswordConfirm" placeholder="Confirmez votre mot de passe" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" required>Envoyer</button>
                    <a href='<?=$_SERVER['HTTP_REFERER']?>' class="btn btn-secondary">Retour</a>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
//Importe le footer
require_once "./view/partial/footer.php";
?>