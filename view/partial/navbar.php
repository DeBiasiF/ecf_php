<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/ecf_php/index.php">Accueil</a>
                </li>
                <?php if(!empty($_SESSION['loggedUser'])) if ($_SESSION['loggedUser']->getRole()->getId() == 1) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="/ecf_php/index.php/gestionuser">Gestion Utilisateurs</a>
                </li>
                <?php endif ?>
            </ul>
            <?php if (!empty($_SESSION['loggedUser'])) : //Si user authentifié affiche la deconnexion ?> 
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <span class="nav-link">Bonjour <?= $_SESSION['loggedUser']->getName(); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ecf_php/index.php/addgood">Inscrire un bien</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ecf_php/index.php/loggout">Déconnexion</a>
                    </li>
                </ul>
            <?php else : //Sinon affiche l'inscription ou la connexion ?> 
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link d-inline-block" href="/ecf_php/index.php/signup">S'inscrire</a>
                        <a class="nav-link d-inline-block" href="/ecf_php/index.php/loggin">Connexion</a>
                    </li>
                </ul>
            <?php endif ?>
        </div>
    </div>
</nav>
