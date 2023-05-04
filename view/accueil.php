<?php
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>

<div class="container-fluid">
    <h1>MES CONTACTS</h1>
    <div class="row">

<?php
foreach ($contacts as $contact) {
    $id = $contact->getId();
    $lastName = strtoupper($contact->getLastname());
    $firstName = ucfirst(strtolower($contact->getFirstname()));
    $mail = $contact->getMail();
    ?>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">&nbsp;</h5>
                    <p class="card-text"><?=$lastName." ".$firstName?></p>
                    <p class="card-text"><?=$mail?> <i class="bi bi-envelope"></i></p>
                    <a href="/Form_Contact/index.php/contact?id=<?=$id?>" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
<?php } ?>
    </div>
</div>
<?php
require_once "./view/partial/footer.php";
?>