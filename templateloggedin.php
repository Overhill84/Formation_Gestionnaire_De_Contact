<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Repertoire</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php?route=user_logout">Me déconnecter</a></li>
            <li><a href="index.php?route=contact_index">Accueil</a></li>
            <li><a href='index.php?route=contact_index&ordre=nom'>Tous les contacts par nom</a></li>
            <li><a href='index.php?route=contact_index&ordre=creation'>Tous les contacts par date</a></li>
            <li><a href='index.php?route=contact_insert'>Ajouter un contact</a></li>
            <li><a href='index.php?route=categorie_insert'>Ajouter une catégorie</a></li>
            <?php 
                $user = new \Models\Utilisateur(\Models\Utilisateurcourant::getInstance());
                if($user->verify_admin($_SESSION['user']['idUtilisateur'])) { ?>
                    <li><a href='index.php?route=user_manage'>Gérer les utilisateurs</a></li>
            <?php } ?>
            
            
        </ul>
    </nav>
    <?php    
        echo $this->generate($view, $datas);
    ?>
</body>
</html>