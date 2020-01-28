<?php
    //$contact = $view['datas']['contact'];
?>

<h1><?= $contact->getPrenom()?> <?= $contact->getNom()?> </h1>
<table>
    <body>
        <tr>
            <td>Mobile :</td>
            <td><?= $contact->getMobile()?></td>
        </tr>
        <tr>
            <td>Domicile :</td>
            <td><?= $contact->getDomicile()?></td>
        </tr>
        <tr>
            <td>Bureau :</td>
            <td><?= $contact->getBureau()?></td>
        </tr>
        <tr>
            <td>Email :</td>
            <td><?= $contact->getEmail()?></td>
        </tr>
        <tr>
            <td>Categorie :</td>
            <td><?= $contact->getCategorieLibelle()?></td>
        </tr>
    </body>
</table>


<p><em>Contact créé le <?= $contact->getDatecreation()?> - Mis à jour le <?= $contact->getDatemodification()?></p>