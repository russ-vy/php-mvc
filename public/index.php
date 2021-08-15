<?php

include_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../vendor/autoload.php';

session_start();
/**
 * Routing
 */
$router = new App\Core\Router();

// Add the routes
$router->add('', ['controller' => 'User', 'action' => 'index']);
// Admin
$router->add('admin', ['namespace' => 'Admin', 'controller' => 'Admin']);
$router->add('admin/{action}', ['namespace' => 'Admin', 'controller' => 'Admin']);
// Auth
$router->add('login', ['namespace' => 'Auth']);
$router->add('register', ['namespace' => 'Auth']);
$router->add('forgot-password', ['namespace' => 'Auth']);

$router->add('{controller}/{action}');

if (!empty($_GET['path'])) {
    $router->dispatch($_GET['path']);
} else {
    $router->dispatch($_SERVER['QUERY_STRING']);
}
