<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/Form_Contact">Liste Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Form_Contact/index.php/addcontact">Créer un contact</a>
                </li>
            </ul>
            <?php if (!empty($_SESSION['loggedUser'])) : ?>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/ecf_php/index.php/loggout">Déconnexion</a>
                    </li>
                </ul>
            <?php else : ?>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/ecf_php/index.php/loggin">Connexion</a>
                    </li>
                </ul>
            <?php endif ?>
        </div>
    </div>
</nav>
