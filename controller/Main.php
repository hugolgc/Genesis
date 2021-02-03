<?php

class Main extends View
{
  public function welcome()
  {
    $gradient = ['sunset', 'magenta', 'wild'];

    $this->render('home', [
      'random' => $gradient[array_rand($gradient)]
    ]);
  }

  public function display(string $message)
  {
    $this->render('display', [
      'message' => $message
    ]);
  }
}