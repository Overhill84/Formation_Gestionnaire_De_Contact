<?php

namespace Controllers;

class UserController extends Controller
{
    // Fonctionnalités de traitement, redirigées
    function insert()
    {
        // Première verif : Si les "champs" du formulaire ont tous bien été renseignés
        if (!empty($_POST['pseudo']) && !empty($_POST['passwd']) && !empty($_POST['passwd2'])) {

            // Je vérifie que les deux mots de passe entrés correspondent
            if ($_POST['passwd'] === $_POST['passwd2']) {
                $this->_checkToken($_POST);
                // Dans ce cas, j'instancie un nouvel objet utilisateur, et lui renseigne ses propriétés
                $utilisateur = new \Models\Utilisateur();
                $utilisateur->setPseudo($_POST['pseudo']);
                $utilisateur->setPassword(password_hash($_POST['passwd'], PASSWORD_DEFAULT));
                var_dump($utilisateur);
                $utilisateur->insert();
            }
        }

        header("Location:index.php?route=default_index");
    }

    function login()
    {

        $utilisateur = \Models\Utilisateurcourant::getInstance();

        if ($utilisateur->login($_POST['pseudo'], $_POST['passwd'])->isLogged()) {
            header("Location:index.php?route=contact_index");
        } else {
            header("Location:index.php?route=default_index");
        }
        exit();
    }

    function logout()
    {
        $utilisateur = \Models\Utilisateurcourant::getInstance();
        $utilisateur->logout();
        header("Location:index.php?route=default_index");
        exit();
    }

    function manage()
    {
        $this->redirectIfNotLogged();
        
        $user = new \Models\Utilisateur(\Models\Utilisateurcourant::getInstance());
        
        if ($user->verify_admin($_SESSION['user']['idUtilisateur'])) {
            
            $users = $user->selectAll();
            $view = 'views/utilisateur/manage_user.php';

            $params = ['view' => $view, 'datas' => [
                'users' => $users
            ]];

            $v = new \Views\View;
            return $v->generate('views/templateloggedin.php', $params);
        } else 
        {
            throw new \Exception("Vous n'avez pas accès à la page");
        }
    }

    function update()
    {
        $this->redirectIfNotLogged();

        if (!empty($_POST)) {
            $this->_checkToken($_POST);
            $user = new \Models\Utilisateur(\Models\Utilisateurcourant::getInstance());
            $user->setIdUtilisateur($_GET['id_user']);
            $user->setPseudo($_POST['pseudo']);
            $user->setType($_POST['type']);
            $user->updateAdmin();

            header("Location:index.php?route=contact_index");
            exit();

        }

        if ($_SESSION['user']['type'] == 'admin')
        {
            $user = new \Models\Utilisateur(\Models\Utilisateurcourant::getInstance());
            $user->setIdUtilisateur($_GET['id_user']);
            $user = $user->select();
            
            $view = 'views/utilisateur/update_user.php';

            $params = ['view' => $view, 'datas' => [
                'user' => $user
            ]];

            $v = new \Views\View;
            return $v->generate('views/templateloggedin.php', $params);
            } else{
                throw new \Exception("Vous n'avez pas accès à la page");
            }
    }
}
