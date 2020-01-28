<?php

namespace Controllers;

class CategorieController extends Controller
{
    function insert()
    {
        $this->redirectIfNotLogged();


        if (!empty($_POST)) {
            $this->_checkToken($_POST);
            $categorie = new \Models\Categorie(\Models\Utilisateurcourant::getInstance());
            $categorie->setIdUtilisateur($_SESSION['user']['idUtilisateur']);
            $categorie->setNom($_POST['nom']);
            $categorie->insert();
            header("Location:index.php?route=contact_index");
            exit();
        }

        $catList = new \Models\Categorie(\Models\Utilisateurcourant::getInstance());
        $catList->setIdUtilisateur($_SESSION['user']['idUtilisateur']);
        $cat = $catList->selectByUser();
        $view = 'views/categorie/insert_categorie.php';

        $params = ['view' => $view, 'datas' => [
            'categories' => $cat
        ]];

        $v = new \Views\View;
        return $v->generate('views/templateloggedin.php', $params);
    }

    function delete()
    {
        $this->redirectIfNotLogged();
        $this->_checkToken($_GET);
        $categorie = new \Models\Categorie(\Models\Utilisateurcourant::getInstance());
        $categorie->setIdUtilisateur($_SESSION['user']['idUtilisateur']);
        $categorie->setIdCat($_GET['id_cat']);
        $categorie->delete();

        header('Location: index.php?route=categorie_insert');
        exit();
    }
}
