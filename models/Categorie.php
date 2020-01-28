<?php

namespace Models;

use Exception;
use PDO;

class Categorie extends DbConnect
{
    private $nom;
    private $idCategorie;
    private $idUtilisateur;

    public function __construct()
    {
        parent::__construct();
        $this->id_cat = -1;
        $this->nom = '';
    }

    public function setNom(string $name)
    {
        $this->nom = $name;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setIdCat(int $id)
    {
        $this->idCategorie = $id;
    }

    public function getIdCat(): int
    {
        return $this->idCategorie;
    }

    public function setIdUtilisateur(int $id = null)
    {
        $this->idUtilisateur = $id;
    }

    public function getIdUtilisateur()
    {
        return $this->idUtilisateur;
    }

    public function insert()
    {
        $query = "INSERT INTO categories(nom, id_user)
                    VALUES (:nom, :id_user)";
        $result = $this->pdo->prepare($query);
        $result->bindValue(":nom", $this->nom, PDO::PARAM_STR);
        $result->bindValue(":id_user", $this->idUtilisateur, PDO::PARAM_INT);

        $result->execute();
        $this->id = $this->pdo->lastInsertId();
        return $this;

    }

    public function select()
    {
        $query = "SELECT id_cat, nom FROM categories WHERE id_cat = :id_cat";
        $result = $this->pdo->prepare($query);
        $result->bindValue(":id_cat", $this->idCategorie, PDO::PARAM_INT);
        $result->execute();

        $data = $result->fetch();

        if($data)
        {
            $this->setIdCat($data['id_cat']);
            $this->setNom($data['nom']); 
        }
        return $this;
    }
    
    public function selectAll()
    {
        $query = "SELECT id_cat, nom FROM categories";
        $result = $this->pdo->prepare($query);
        $result->execute();

        $datas = $result->fetchAll();
        $tab = [];

        if($datas)
        {
            foreach($datas as $data)
            {
                $new = new Categorie();
                $new->setIdCat($data['id_cat']);
                $new->setNom($data['nom']);
                array_push($tab, $new);
            }
        }
        return $tab;
    }

    public function selectByUser()
    {
        $query = "SELECT id_cat, nom, id_user FROM categories WHERE id_user = :id_user OR id_user IS NULL";
        $result = $this->pdo->prepare($query);
        $result->bindValue(":id_user", $this->idUtilisateur, PDO::PARAM_INT);
        $result->execute();

        $datas = $result->fetchAll();
        $tab = [];

        if($datas)
        {
            foreach($datas as $data)
            {
                $new = new Categorie();
                $new->setIdCat($data['id_cat']);
                $new->setNom($data['nom']);
                $new->setIdUtilisateur($data['id_user']);
                array_push($tab, $new);
            }
        }
        return $tab;
    }

    public function update()
    {
        $query = "UPDATE categories SET nom = :nom WHERE id_cat = :id_cat AND id_user = :id_user";
        $result = $this->pdo->prepare($query);
        $result->bindValue(":id_cat", $this->idCategorie, PDO::PARAM_INT);
        $result->bindValue(":id_user", $this->idUtilisateur, PDO::PARAM_INT);
        $result->execute();

        return $this;
    }

    public function delete()
    {
        $query = "DELETE FROM categories WHERE id_cat = :id_cat AND id_user = :id_user";
        $result = $this->pdo->prepare($query);
        $result->bindValue(':id_user', $this->idUtilisateur, PDO::PARAM_INT);
        $result->bindValue(':id_cat', $this->idCategorie, PDO::PARAM_INT);

        $result->execute();
    }

    
}