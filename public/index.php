<?php

require '../app/Autoload.php';

//$connect = new Database('db_name');

if ($page === 'index')
{
  $view->render('home');
}
else
{
  $view->send('Aucun contrôleur associé à cette route');
}
