<?php

namespace Controllers;

class Controller
{
    function __construct()
    {
        $this->_makeToken();
    }

    function redirectIfNotLogged($where = null)
    {
        if (!\Models\Utilisateurcourant::getInstance()->isLogged()) {
            if ($where) {
                header("Location: $where");
            } else {
                header("Location:index.php");
            }
            exit();
        }
    }

    protected function _makeToken()
    {
        if(!isset($_SESSION['token']))
        {
        $_SESSION['token'] = sha1(uniqid());
        }
    }

    protected function _checkToken($superGlobale)
    {
        if($_SESSION['token'] != $superGlobale["token"]) 
        {
            throw new \Exception('Token invalide');
        }
    }

    static function getToken()
    {
        return $_SESSION['token'];
    }

    static public function generateHiddenToken()
    {
        return "<input type='hidden' name='token' value='{$_SESSION['token']}'>";
    }

    static public function generateGetToken()
    {
        return "token={$_SESSION['token']}";
    }
}
