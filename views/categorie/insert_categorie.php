<?php
//$categories = $view['datas']['categories'];

?>

<h1>Vos catégories</h1>
<div>
    <?php foreach ($categories as $categorie) { ?>
        <div>
            <h3>- <?php echo $categorie->getNom() ?> 
            <?php if($categorie->getIdUtilisateur() != null){ ?>
            <a style="color: red;" href="index.php?route=categorie_delete&id_cat=<?php echo $categorie->getIdCat() ?>&<?= \Controllers\Controller::generateGetToken()?>">X</a>
            <?php } ?>
        </h3>
        </div>
    <?php } ?>
</div>
<h2>Ajouter une catégorie</h2>
<form action="index.php?route=categorie_insert" method="POST">
    <div>
        <input type="text" name="nom" placeholder="Nom catégorie">
    </div>
    <div>
        <input type="submit" value="Valider">
    </div>
    <?= \Controllers\Controller::generateHiddenToken() ?>
</form>