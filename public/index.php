<?php

require '../app/Autoload.php';

//$connect = new Database('db_name');
$translate = new Translate();

if ($page === 'index')
{
  $view->render('home', $translate);
}
else
{
  $view->send('Aucun contrôleur associé à cette route');
}
