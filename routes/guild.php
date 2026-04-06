<?php
namespace Routes;

use Config\Container;
use Config\Router;
use Middlewares\AuthMiddleware;

$router = Router::getInstance();

$router->add('POST', '/create-guild', function ($request) {
    $controller = Container::getGuildController();
    $controller->createGuild($request);
}, [[AuthMiddleware::class, 'handle']]);