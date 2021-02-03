<?php

require dirname(__DIR__) . '/app/Genesis.php';

$app = new Router;

$app->get('/',          ['Main', 'welcome']);
$app->get('/:message',  ['Main', 'display']);

$app->server();