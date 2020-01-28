<?php

namespace Models;

class Utilisateurcourant extends Utilisateur {

    protected static $instance = null;
    protected static $instanceAllowed = false;

    public static function getInstance() : self{
        if (!self::$instance){
            self::$instanceAllowed = true;
            self::$instance = new Utilisateurcourant();
            self::$instanceAllowed = false;
            self::$instance->setIdUtilisateur(isset($_SESSION['user']['idUtilisateur']) ? $_SESSION['user']['idUtilisateur']: '-1');
            self::$instance->setPseudo(isset($_SESSION['user']['pseudo']) ? $_SESSION['user']['pseudo']: '');
        }
        return self::$instance;
    }

    public function __construct(){
        if (!self::$instanceAllowed){
            throw new \Exception('forbidden');
        }
        parent::__construct();
    }

    public function isLogged() : bool{
        if (isset($_SESSION['user']['idUtilisateur'])){
            return true;
        }
        return false;
    }

    public function login($pseudo, $password) : self{
        
        $this->setPseudo($pseudo);
        $this->verify_user();
        
        if(password_verify($password, $this->getPassword())) {
            // Dans ce cas on est connecté, on place donc l'utilisateur en session
            $_SESSION['user']['idUtilisateur'] = $this->getIdUtilisateur();
            $_SESSION['user']['pseudo'] = $this->getPseudo();
            $_SESSION['user']['type'] = $this->getType();
        }

        return $this;
    }

    public function logout() : self{
        $_SESSION = array();
        $this->setIdUtilisateur(-1);
        $this->setPseudo('');
        return $this;
    }
}