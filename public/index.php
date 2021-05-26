<?php

require_once '../vendor/autoload.php';

$router = new Genesis\Router;

$router->get('/', 'Main::home');

$router->get('/api', 'Main::api');

$router->start();