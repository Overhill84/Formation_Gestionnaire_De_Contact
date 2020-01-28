<?php

    //$contacts = $view['datas']['contacts'];
?>

<h1>Mon répertoire</h1>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Détail</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($contacts as $contact){ ?>           
            <tr>        
                <td><?= $contact->getNom() ?></td>
                <td><?= $contact->getPrenom() ?></td>
                <td><?= $contact->getEmail() ?></td>
                <td><?= $contact->getMobile() ?></td>
                <td><a href="index.php?route=contact_show&id_user=<?= $contact->getIdUtilisateur() ?>&id_contact=<?= $contact->getIdContact() ?>" class="btn btn-danger">détail</a></td>
                <td><a href="index.php?route=contact_update&id_user=<?= $contact->getIdUtilisateur() ?>&id_contact=<?= $contact->getIdContact() ?>" class="btn btn-danger">modifier</a></td>
                <td><a href="index.php?route=contact_delete&id_user=<?= $contact->getIdUtilisateur() ?>&id_contact=<?= $contact->getIdContact() ?>&<?= \Controllers\Controller::generateGetToken()?>" class="btn btn-danger">supprimer</a></td>
            </tr>
        <?php 
        }?>
    </tbody>
    
</table>


