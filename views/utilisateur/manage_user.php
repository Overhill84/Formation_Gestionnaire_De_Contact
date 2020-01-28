<?php
?>

<h1>Liste des utilisateurs</h1>

<table>
    <thead>
        <tr>
            <th>Pseudo</th>
            <th>Type</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user){ ?>           
            <tr>        
                <td><?= htmlspecialchars($user->getPseudo()) ?></td>
                <td><?= htmlspecialchars($user->getType()) ?></td>
                <td><a href="index.php?route=user_update&id_user=<?= $user->getIdUtilisateur() ?>" class="btn btn-danger">modifier</a></td>
                <td><a href="index.php?route=user_delete&id_user=<?= $user->getIdUtilisateur() ?>" class="btn btn-danger">supprimer</a></td>
            </tr>
        <?php 
        }?>
    </tbody>
    
</table>
