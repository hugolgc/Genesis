<?php

use Genesis\Api;
use SleekDB\Store;
use Twig\Environment as Controller;

class Main extends Controller
{
  /**
   * 
   * Affiche la page principale de Genesis !
   * 
   * 
   * @return string Page au format Twig
   * 
   */
  public function home(): string
  {
    return $this->render('home.html', [
      'message' => 'Welcome'
    ]);
  }

  /**
   * 
   * Dresse les informations des utilisateurs
   * 
   * 
   * @return string Page au format Twig
   * 
   */
  public function api(): string
  {
    /**
     * SleekDB (NOSQL PHP)
     * 
     * https://sleekdb.github.io/
     */
    $developerStore = new Store('users', '../models');
    
    $developer = [
      'name' => '@hugolgc',
      'stack' => ['Genesis', 'Symfony', 'Express', 'React', 'Angular'],
      'cv' => 'https://figma.com/file/KPvMlRjexQWLq3Xn0ouLwI/CV',
      'github' => 'https://github.com/hugolgc',
      'age' => 20
    ];

    if (empty($developerStore->findAll())) $developerStore->insert($developer);

    return Api::json($developerStore->findAll());
  }
}