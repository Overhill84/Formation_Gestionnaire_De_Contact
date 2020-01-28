<?php

namespace Controllers;

class ContactController extends Controller
{
    function index()
    {
        $this->redirectIfNotLogged();
     
        if ($_SESSION['user']['type'] == "admin") {
            $contactModel = new \Models\Contact(\Models\Utilisateurcourant::getInstance());
            $categorie = new \Models\Categorie(\Models\Utilisateurcourant::getInstance());
            $categories = $categorie->selectAll();
            $contacts = $contactModel->selectAll();

        } else {
            $contactModel = new \Models\Contact(\Models\Utilisateurcourant::getInstance());
            $contactModel->setIdUtilisateur($_SESSION['user']['idUtilisateur']);
            $categorie = new \Models\Categorie(\Models\Utilisateurcourant::getInstance());
            $categories = $categorie->selectAll();
            $ordre = $_GET['ordre'] ?? 'name';
            if ($ordre == 'creation') {
                $contacts = $contactModel->SelectByDate();
            } elseif ($ordre == 'nom') {
                $contacts = $contactModel->selectByName();
            } else {
                $contacts = $contactModel->selectByUser();
            }
        }

        $view = 'views/contact/index.php';

        $params = ['view' => $view, 'datas' => [
            'contacts' => $contacts,
            'categories' => $categories
        ]];

        $v = new \Views\View;
        return $v->generate('views/templateloggedin.php', $params);
    }

    function insert()
    {
        $this->redirectIfNotLogged();

        if (!empty($_POST)) {

            $this->_checkToken($_POST);
            $contact = new \Models\Contact(\Models\Utilisateurcourant::getInstance());
            $contact->setIdUtilisateur($_SESSION['user']['idUtilisateur']);
            $contact->setNom($_POST['nom']);
            $contact->setCategorie($_POST['categorie']);
            $contact->setPrenom($_POST['prenom']);
            $contact->setMobile($_POST['mobile']);
            $contact->setDomicile($_POST['domicile']);
            $contact->setBureau($_POST['bureau']);
            $contact->setEmail($_POST['email']);
            $contact->insert();

            header("Location:index.php?route=contact_index");
            exit();
        }
        $categories = new \Models\Categorie(\Models\Utilisateurcourant::getInstance());
        $categories->setIdUtilisateur($_SESSION['user']['idUtilisateur']);
        $cat = $categories->selectByUser();

        $view = 'views/contact/insert_contact.php';

        $params =  ['view' => $view, 'datas' => [
            'categories' => $cat
        ]];

        $v = new \Views\View;
        return $v->generate('views/templateloggedin.php', $params);
    }

    function update()
    {
        $this->redirectIfNotLogged();

        if (!empty($_POST)) {
            $this->_checkToken($_POST);
            $contact = new \Models\Contact(\Models\Utilisateurcourant::getInstance());
            $contact->setIdUtilisateur($_GET['id_user']);
            $contact->setIdContact($_GET['id_contact']);
            $contact->setNom($_POST['nom']);
            $contact->setCategorie($_POST['categorie']);
            $contact->setPrenom($_POST['prenom']);
            $contact->setMobile($_POST['mobile']);
            $contact->setDomicile($_POST['domicile']);
            $contact->setBureau($_POST['bureau']);
            $contact->setEmail($_POST['email']);
            $contact->update();

            header("Location:index.php?route=contact_index");
            exit();
        }

        $contact = new \Models\Contact(\Models\Utilisateurcourant::getInstance());
        $contact->setIdUtilisateur($_GET['id_user']);
        $contact->setIdContact($_GET['id_contact']);
        $contact->select();

        $view = 'views/contact/update_contact.php';

        $params = ['view' => $view, 'datas' => [
            'contact' => $contact
        ]];

        $v = new \Views\View;
        return $v->generate('templateloggedin.php', $params);
    }


    function show()
    {
        $contact = new \Models\Contact(\Models\Utilisateurcourant::getInstance());
        $contact->setIdUtilisateur($_GET['id_user']);
        $contact->setIdContact($_GET['id_contact']);
        $contact->select();

        $view = 'views/contact/show_contact.php';

        $params = ['view' => $view, 'datas' => [
            'contact' => $contact
        ]];

        $v = new \Views\View;
        return $v->generate('views/templateloggedin.php', $params);
    }


    function delete()
    {
        $this->redirectIfNotLogged();
        $this->_checkToken($_GET);
        $contact = new \Models\Contact(\Models\UtilisateurCourant::getInstance());
        $contact->setIdUtilisateur($_GET['id_user']);
        $contact->setIdContact($_GET['id_contact']);
        $contact->delete();

        header('Location: index.php?route=contact_index');
        exit();
    }
}
