<?php
?>

<form action="index.php?route=user_update&id_user=<?= $user->getIdUtilisateur() ?>&" method="POST">
    <label for="pseudo">Pseudo</label>
    <input type="text" name="pseudo" placeholder="
        pseudo" value="<?php echo htmlspecialchars($user->getPseudo()); ?>">

    <div>
        <label for="type">Type</label>
        <select name='type'>
            <option value='standart'>Standart</option>
            <option value="admin">Admin</option>
        </select>
    </div>
    <div>
        <input type="submit" value="Valider">
    </div>
    <?= \Controllers\Controller::generateHiddenToken() ?>
</form>