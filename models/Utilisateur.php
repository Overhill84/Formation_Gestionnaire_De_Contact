<?php

namespace Models;

use PDO;

class Utilisateur extends DbConnect
{

    protected $idUtilisateur;
    protected $pseudo;
    protected $password;
    protected $type;

    public function __construct()
    {
        parent::__construct();
        $this->idUtilisateur = -1;
        $this->pseudo = '';
        $this->password = '';
    }

    public function getIdUtilisateur(): int
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(int $id)
    {
        $this->idUtilisateur = $id;
    }

    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo)
    {
        $this->pseudo = $pseudo;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $passwd)
    {
        $this->password = $passwd;
    }

    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function insert()
    {

        $query = "INSERT INTO users(pseudo, password) 
                    VALUES (:pseudo, :password)";
        $result = $this->pdo->prepare($query);
        $result->bindValue(':pseudo', $this->pseudo, PDO::PARAM_STR);
        $result->bindValue(':password', $this->password, PDO::PARAM_STR);

        $result->execute();
        $this->id = $this->pdo->lastInsertId();
        return $this;
    }

    public function verify_user(): self
    {

        $query = "SELECT id_user, password, type FROM users WHERE pseudo = :pseudo";
        $result = $this->pdo->prepare($query);
        $result->bindValue(':pseudo', $this->pseudo, PDO::PARAM_STR);
        $result->execute();

        $data = $result->fetch();

        if ($data) {
            $this->password = $data['password'];
            $this->idUtilisateur = $data['id_user'];
            $this->type = $data['type'];
        }
        return $this;
    }

    public function verify_admin($id)
    {
        $this->setIdUtilisateur($id);
        $check = $this->select();
        if($check->getType() === 'admin')
        {
            return true;
        }

    }

    public function delete()
    {
        $query = "DELETE FROM users WHERE id_user = :id_user";
        $result = $this->pdo->prepare($query);
        $result->bindValue(':id_user', $this->idUtilisateur, PDO::PARAM_INT);
        $result->execute();
    }

    public function update()
    {
        $query = "UPDATE users SET pseudo = :pseudo, password = :password WHERE id_user = :id_user";
        $result = $this->pdo->prepare($query);
        $result->bindValue(':id_user', $this->idUtilisateur, PDO::PARAM_INT);
        $result->bindValue(':pseudo', $this->pseudo, PDO::PARAM_STR);
        $result->bindValue(':password', $this->password, PDO::PARAM_STR);
        $result->bindValue(":type", $this->type, PDO::PARAM_STR);
        $result->execute();
    }
    
    public function updateAdmin()
    {
        $query = "UPDATE users SET pseudo = :pseudo, type = :type WHERE id_user = :id_user";
        $result = $this->pdo->prepare($query);
        $result->bindValue(':id_user', $this->idUtilisateur, PDO::PARAM_INT);
        $result->bindValue(':pseudo', $this->pseudo, PDO::PARAM_STR);
        $result->bindValue(':password', $this->password, PDO::PARAM_STR);
        $result->bindValue(":type", $this->type, PDO::PARAM_STR);
        $result->execute();
    }

    public function selectAll()
    {
        $query = "SELECT id_user, pseudo, type FROM users";

        $result = $this->pdo->prepare($query);
        $result->execute();

        $datas = $result->fetchAll();
        $tab = [];

        if ($datas) {
            foreach ($datas as $data) {
                $new = new Utilisateur();
                $new->setIdUtilisateur($data['id_user']);
                $new->setPseudo($data['pseudo']);
                $new->setType($data['type']);
                array_push($tab, $new);
            }
        }
        return $tab;
    }

    public function select()
    {
        $query = "SELECT id_user, pseudo, type FROM users WHERE id_user = :id_user";

        $result = $this->pdo->prepare($query);
        $result->bindValue(":id_user", $this->idUtilisateur, PDO::PARAM_INT);
        $result->execute();

        $data = $result->fetch();

        if ($data) {
            $this->setIdUtilisateur($data['id_user']);
            $this->setPseudo($data['pseudo']);
            $this->setType($data['type']);
        }
        return $this;
    }
}
