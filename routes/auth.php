<?php

namespace Routes;

use Config\Router;
use Config\Database;
use Controllers\UserController;
use Models\User;

$router = Router::getInstance();

$router->add('POST', '/register', function () {
    $pdo = Database::connect();
    $userModel = new User($pdo);
    $controller = new UserController($userModel);
    $controller->register();
}, []);

$router->add('POST', '/login', function () {
    $pdo = Database::connect();
    $userModel = new User($pdo);
    $controller = new UserController($userModel);
    $controller->login();
}, []);