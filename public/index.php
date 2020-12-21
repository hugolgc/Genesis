<?php

require '../app/Autoload.php';

$connect = new Database('blog');

if ($page === 'index')
{
  $view->render('home', $connect->list('article'));
}
elseif ($page === 'single')
{
  $view->render('single', $connect->find('article', $id));
}
else
{
  $view->send('Aucun contrôleur associé à cette route');
}
