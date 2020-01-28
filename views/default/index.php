<h1>Ma Todolist</h1>
<h2>Inscrivez-vous</h2>
<form action="index.php?route=user_insert" method="POST">
    <div>
        <input type="text" name="pseudo" placeholder="Choisissez un pseudo">
    </div>
    <div>
        <input type="password" name="passwd" placeholder="Choisissez un mot de passe">
        <input type="password" name="passwd2" placeholder="Confirmez votre mot de passe">
    </div>
    <div>
        <input type="submit" value="Valider">
    </div>
    <?= \Controllers\Controller::generateHiddenToken() ?>
</form>
<h2>Connectez-vous</h2>
<form action="index.php?route=user_login" method="POST">
    <div>
        <input type="text" name="pseudo" placeholder="Entrez votre pseudo">
    </div>
    <div>
        <input type="password" name="passwd" placeholder="Entrez votre mot de passe">
    </div>
    <div>
        <input type="submit" value="Connexion">
    </div>
    <?= \Controllers\Controller::generateHiddenToken() ?>
</form>