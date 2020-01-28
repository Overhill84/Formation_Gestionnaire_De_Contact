<?php
//$categories = $view['datas']['categories'];

?>



<form action="index.php?route=contact_insert" method="POST">
    <div>
        <select name='categorie'>
            <?php

            foreach ($categories as $categorie) { ?>
                <option value='<?php echo $categorie->getIdCat();?>'><?php echo $categorie->getNom(); ?></option>
            <?php } ?>
        </select>
    </div>
    <div>

        <input type="text" name="nom" placeholder="Nom">
    </div>
    <div>
        <input type="text" name="prenom" placeholder="Prénom">
    </div>
    <div>
        <input type="text" name="mobile" placeholder="Mobile">
    </div>
    <div>
        <input type="text" name="domicile" placeholder="Domicile">
    </div>
    <div>
        <input type="text" name="bureau" placeholder="Bureau">
    </div>
    <div>
        <input type="text" name="email" placeholder="E-mail">
    </div>
    <div>
        <input type="submit" value="Valider">
    </div>
    <?= \Controllers\Controller::generateHiddenToken() ?>
</form>