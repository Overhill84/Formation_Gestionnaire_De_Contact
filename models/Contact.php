<?php

namespace Models;

use Exception;
use PDO;

class Contact extends DbConnect
{


    private $idUtilisateur;
    private $idContact;
    private $categorie;
    private $nom;
    private $prenom;
    private $mobile = null;
    private $domicile = null;
    private $bureau = null;
    private $email;
    private $datecreation;
    private $datemodification = null;

    public function __construct($utilisateur)
    {
        parent::__construct();
        $this->idUtilisateur = $utilisateur;
    }

    public function getIdUtilisateur(): int
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(int $id)
    {
        $this->idUtilisateur = $id;
    }

    public function getIdContact(): int
    {
        return $this->idContact;
    }

    public function setIdContact(int $id)
    {
        $this->idContact = $id;
    }

    public function getCategorie(): int
    {
        return $this->categorie;
    }

    public function getCategorieLibelle(): string
    {
        if(is_null($this->categorie))
        {
            return "";
        }
        $categories = new Categorie();
        $categories->setIdCat($this->categorie);
        $categorie = $categories->select();
        
            
        return $categorie->getNom();
    }

    public function setCategorie(int $categorie = null)
    {
        $this->categorie = $categorie;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getNomComplet(): string
    {
        return $this->nom . " " . $this->prenom;
    }

    public function setNom(string $nom)
    {
        $this->nom = $nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom)
    {
        $this->prenom = $prenom;
    }

    public function getMobile(): string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile)
    {
        $this->mobile = $mobile;
    }

    public function getDomicile(): string
    {
        return $this->domicile;
    }

    public function setDomicile(string $domicile)
    {
        $this->domicile = $domicile;
    }

    public function getBureau(): string
    {
        return $this->bureau;
    }

    public function setBureau(string $bureau)
    {
        $this->bureau = $bureau;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getDatecreation(): string
    {
        return $this->datecreation;
    }

    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;
    }

    public function getDatemodification(): string
    {
        if ($this->datemodification == null) {
            return "(Jamais modifié)";
        } else {
            return $this->datemodification;
        }
    }

    public function setDatemodification($datemodification)
    {
        $this->datemodification = $datemodification;
    }


    public function insert()
    {
        $query = "INSERT INTO contacts(id_categorie, nom, prenom, num_mobile, num_domicile, num_bureau, mail, date_creation, id_user)
                    VALUES (:id_categorie, :nom, :prenom, :num_mobile, :num_domicile, :num_bureau, :mail, NOW(), :id_user)";

        $result = $this->pdo->prepare($query);
        $result->bindValue(':id_categorie', $this->categorie, PDO::PARAM_INT);
        $result->bindValue(':nom', $this->nom, PDO::PARAM_STR);
        $result->bindValue(':prenom', $this->prenom, PDO::PARAM_STR);
        $result->bindValue(':num_mobile', $this->mobile, PDO::PARAM_STR);
        $result->bindValue(':num_domicile', $this->domicile, PDO::PARAM_STR);
        $result->bindValue(':num_bureau', $this->bureau, PDO::PARAM_STR);
        $result->bindValue(':mail', $this->email, PDO::PARAM_STR);
        $result->bindValue(':id_user', $this->idUtilisateur, PDO::PARAM_INT);

        $result->execute();
        $result->debugDumpParams();
        $this->id = $this->pdo->lastInsertId();
        return $this;
    }

    public function selectByUser()
    {
        $query = "SELECT id_contact, id_categorie, nom, prenom, num_mobile, num_domicile, num_bureau, mail, date_creation
        FROM contacts WHERE id_user = '$this->idUtilisateur'";

        $result = $this->pdo->prepare($query);
        $result->execute();

        $datas = $result->fetchAll();
        $tab = [];

        if ($datas) {
            foreach ($datas as $data) {
                $new = new Contact($this->idUtilisateur);
                $new->setIdContact($data['id_contact']);
                $new->setNom($data['nom']);
                $new->setCategorie($data['id_categorie']);
                $new->setPrenom($data['prenom']);
                $new->setMobile($data['num_mobile']);
                $new->setDomicile($data['num_domicile']);
                $new->setBureau($data['num_bureau']);
                $new->setEmail($data['mail']);

                array_push($tab, $new);
            }
        }
        return $tab;
    }

    public function delete()
    {
        $query = "DELETE FROM contacts WHERE id_contact = :id_contact AND id_user = :id_user";
        $result = $this->pdo->prepare($query);
        $result->bindValue(':id_user', $this->idUtilisateur, PDO::PARAM_INT);
        $result->bindValue(':id_contact', $this->idContact, PDO::PARAM_INT);

        $result->execute();
    }

    public function update()
    {
        $query = "UPDATE contacts SET categorie = :categorie, nom = :nom, prenom = :prenom, num_mobile = :num_mobile, num_domicile = :num_domicile, num_bureau = :num_bureau, mail = :mail, date_modif = NOW()
                    WHERE id_contact = :id_contact AND id_user = :id_user";

        $result = $this->pdo->prepare($query);
        $result->bindValue(':categorie', $this->categorie, PDO::PARAM_INT);
        $result->bindValue(':nom', $this->nom, PDO::PARAM_STR);
        $result->bindValue(':prenom', $this->prenom, PDO::PARAM_STR);
        $result->bindValue(':num_mobile', $this->mobile, PDO::PARAM_STR);
        $result->bindValue(':num_domicile', $this->domicile, PDO::PARAM_STR);
        $result->bindValue(':num_bureau', $this->bureau, PDO::PARAM_STR);
        $result->bindValue(':mail', $this->email, PDO::PARAM_STR);
        $result->bindValue(':id_user', $this->idUtilisateur, PDO::PARAM_INT);
        $result->bindValue(':id_contact', $this->idContact, PDO::PARAM_INT);

        $result->execute();

        return $this;
    }

    public function selectAll()
    {
        $query = "SELECT id_contact, id_categorie, nom, prenom, num_mobile, num_domicile, num_bureau, mail, date_creation, date_modif, id_user 
        FROM contacts";

        $result = $this->pdo->prepare($query);
        $result->execute();

        $datas = $result->fetchAll();
        $tab = [];

        if ($datas) {
            foreach ($datas as $data) {
                $new = new Contact($this->idUtilisateur);
                $new->setIdContact($data['id_contact']);
                $new->setNom($data['nom']);
                $new->setCategorie($data['id_categorie']);
                $new->setPrenom($data['prenom']);
                $new->setMobile($data['num_mobile']);
                $new->setDomicile($data['num_domicile']);
                $new->setBureau($data['num_bureau']);
                $new->setEmail($data['mail']);
                $new->setIdUtilisateur($data['id_user']);

                array_push($tab, $new);
            }
        }
        return $tab;
    }

    public function select()
    {
        $query = "SELECT id_categorie, nom, prenom, num_mobile, num_domicile, num_bureau, mail, date_creation, date_modif 
        FROM contacts WHERE id_user = '$this->idUtilisateur' AND id_contact = '$this->idContact'";

        $result = $this->pdo->prepare($query);
        $result->execute();

        $data = $result->fetch();

        if ($data) {
            $this->setNom($data['nom']);
            $this->setCategorie($data['id_categorie']);
            $this->setPrenom($data['prenom']);
            $this->setMobile($data['num_mobile']);
            $this->setDomicile($data['num_domicile']);
            $this->setBureau($data['num_bureau']);
            $this->setEmail($data['mail']);
            $this->datecreation = $data['date_creation'];
            $this->datemodification = $data['date_modif'];
        }
        return $this;
    }

    public function selectByName()
    {
        $query = "SELECT id_contact, id_categorie, nom, prenom, num_mobile, num_domicile, num_bureau, mail, date_creation
        FROM contacts WHERE id_user = '$this->idUtilisateur' ORDER BY nom";

        $result = $this->pdo->prepare($query);
        $result->execute();

        $datas = $result->fetchAll();
        $tab = [];

        if ($datas) {
            foreach ($datas as $data) {
                $new = new Contact($this->idUtilisateur);
                $new->setIdContact($data['id_contact']);
                $new->setNom($data['nom']);
                $new->setCategorie($data['id_categorie']);
                $new->setPrenom($data['prenom']);
                $new->setMobile($data['num_mobile']);
                $new->setDomicile($data['num_domicile']);
                $new->setBureau($data['num_bureau']);
                $new->setEmail($data['mail']);

                array_push($tab, $new);
            }
        }
        return $tab;
    }

    public function selectByDate()
    {
        $query = "SELECT id_contact, id_categorie, nom, prenom, num_mobile, num_domicile, num_bureau, mail, date_creation
        FROM contacts WHERE id_user = '$this->idUtilisateur' ORDER BY date_creation";

        $result = $this->pdo->prepare($query);
        $result->execute();

        $datas = $result->fetchAll();
        $tab = [];

        if ($datas) {
            foreach ($datas as $data) {
                $new = new Contact($this->idUtilisateur);
                $new->setIdContact($data['id_contact']);
                $new->setNom($data['nom']);
                $new->setCategorie($data['id_categorie']);
                $new->setPrenom($data['prenom']);
                $new->setMobile($data['num_mobile']);
                $new->setDomicile($data['num_domicile']);
                $new->setBureau($data['num_bureau']);
                $new->setEmail($data['mail']);

                array_push($tab, $new);
            }
        }
        return $tab;
    }
}
