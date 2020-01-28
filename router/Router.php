<?php

namespace Router;

class Router
{

    function router()
    {
        try {
            $route = (isset($_REQUEST['route'])) ? $_REQUEST['route'] : 'default_index';

            $route = explode("_", $route);
            $className = $route[0] . "Controller";
            if (class_exists("\Controllers\\$className")) {
                $controllerClass = "\Controllers\\$className";
                $controller = new $controllerClass();
                if (method_exists($controller, "$route[1]")) {
                    $method = $route[1];
                    $view = $controller->$method();
                    if (is_string($view)) {
                        echo $view;
                    }
                } else {
                    throw new \Exception("Page non trouvée (mtd).");
                }
            } else {
                throw new \Exception("Page non trouvée (cla).");
            }
        } catch (\Exception $e) {
            $params = [
                'view' => 'views/error.php',
                'datas' => [
                    'message' => $e->getMessage()
                ]
            ];
            $view = "views/template.php";
            $v = new \Views\View;
            echo $v->generate($view, $params);
        }
    }
}
