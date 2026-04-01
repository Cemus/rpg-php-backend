<?php

namespace Routes;

use Config\Router;

$router = Router::getInstance();

$router->add('GET', '/', function () {
    require __DIR__ . '/../views/home.php';
}, []);