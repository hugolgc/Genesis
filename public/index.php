<?php

require dirname(__DIR__) . '/genesis/autoload.php';

$app = new Router;

$app->get('/',          ['Main', 'welcome']);
$app->get('/:message',  ['Main', 'display']);

$app->server();