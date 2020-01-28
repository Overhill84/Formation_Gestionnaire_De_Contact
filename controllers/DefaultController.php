<?php

namespace Controllers;

class DefaultController extends Controller
{
    function index()
{
    if (!\Models\Utilisateurcourant::getInstance()->isLogged()) {
        $view ='views/default/index.php';
        $params = ['view' => $view,
                    'datas' => [
                        

                    ]];
        $v = new \Views\View;
        return $v->generate('views/template.php', $params);
    } else {
        header("Location:index.php?route=contact_index");
        exit();
    }
}

}