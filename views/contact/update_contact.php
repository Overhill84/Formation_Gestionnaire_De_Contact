<?php
    //$contact = $view['datas']['contact'];
?>


<form action="index.php?route=contact_update&id_user=<?= $contact->getIdUtilisateur() ?>&id_contact=<?= $contact->getIdContact() ?>" method="POST">
    <div>
        <label for="categorie">Catégorie</label>
        <select name='categorie'>
            <?php foreach (Models\Contact::getCategories() as $id => $libelle){?>  
                <option value='<?php echo $id;?>'  <?= $id == $contact->getCategorie() ? "selected='selected'":""; ?>><?php echo $libelle;?></option>
            <?php }?>        
        </select>
    </div>
    <div>
        <label for="nom">Nom</label>
        <input type="text" name="nom" placeholder="Nom" value="<?php echo htmlspecialchars( $contact->getNom());?>">
    </div>
    <div>
        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" placeholder="Prénom" value="<?php echo htmlspecialchars( $contact->getPrenom());?>">
    </div>
    <div>
        <label for="mobile">Mobile</label>
        <input type="text" name="mobile" placeholder="Mobile" value="<?php echo htmlspecialchars( $contact->getMobile());?>">
    </div>
    <div>
        <label for="domicile">Domicile</label>
        <input type="text" name="domicile" placeholder="Domicile" value="<?php echo htmlspecialchars( $contact->getDomicile());?>">
    </div>
    <div>
        <label for="bureau">Bureau</label>
        <input type="text" name="bureau" placeholder="Bureau" value="<?php echo htmlspecialchars( $contact->getBureau());?>">
    </div>
    <div>
        <label for="bureau">Email</label>
        <input type="text" name="email" placeholder="E-mail" value="<?php echo htmlspecialchars( $contact->getEmail());?>">
    </div>
    <div>
        <input type="submit" value="Valider">
    </div>
    <?= \Controllers\Controller::generateHiddenToken() ?>
</form>