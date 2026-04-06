<?php

namespace Routes;

use Config\Container;
use Config\Router;

$router = Router::getInstance();

$router->add('POST', '/register', function () {
    $controller = Container::getUserController();
    $controller->register();
}, []);

$router->add('POST', '/login', function () {
    $controller = Container::getUserController();
    $controller->login();
}, []);