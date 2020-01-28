<?php
    session_start();

    require "conf/autoload.php";
    require 'conf/global.php';

    $router = new \Router\Router;
    $router->router();