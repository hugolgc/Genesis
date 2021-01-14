<?php

require '../app/Autoload.php';

//$connect = new Database('db_name');

if ($page === 'index')
{
  $view->render('home', new Translate());
}
else
{
  $view->send('Aucun contrôleur associé à cette route');
}
