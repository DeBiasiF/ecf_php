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
            <?php if ($_SERVER['PHP_SELF'] == '/Form_Contact/index.php/contact') { ?>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <form action="" method="post">
                            <input type="hidden" name="delete" value="<?= $_GET['id'] ?>">
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')">Supprimer</button>
                        </form>
                    </li>
                </ul>
            <?php } ?>
        </div>
    </div>
</nav>
