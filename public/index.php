<?php

require '../genesis/autoload.php';

$app = new Router;

$app->get('/',          ['Main', 'welcome']);
$app->get('/:message',  ['Main', 'display']);

$app->server();