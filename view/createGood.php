<?php
//Importe le header et la navbar
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>

<form enctype="multipart/form-data" action="" method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input type="text" class="form-control" id="name" name="goodName" placeholder="Nom du bien">
    </div>
    <div class="mb-3">
        <label for="category" class="form-label">Catégorie</label>
        <select class="form-control" id="category" name="goodCategoryId">
            <?php foreach ($categories as $category): //Génère la liste des categories disponnible lors de l'enreigistrement d'un bien?>
            <option value="<?=$category->getId()?>"><?=$category->getName()?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="goodDescription" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" class="form-control" id="image" name="image">
    </div>
    <button type="submit" class="btn btn-primary">Envoyer</button>
</form>
<?php
//Importe le header et la navbar
require_once "./view/partial/footer.php";
?>