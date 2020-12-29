<?php

class View
{

  public function send($content, $template = 'default')
  {
    if ($template === FALSE) echo $content;
    else
    {
      if (!file_exists($this->templateFile($template))) die("Le template '$template' n'existe pas.");
      else require $this->templateFile($template);
    }
  }

  public function render($view, $data = NULL, $template = 'default')
  {
    if (!file_exists($this->viewFile($view))) die("La vue '$view' n'existe pas.");
    else
    {
      ob_start();
      require $this->viewFile($view);
      $content = ob_get_clean();

      if ($template === FALSE) echo $content;
      else
      {
        if (!file_exists($this->templateFile($template))) die("Le template '$template' n'existe pas.");
        else require $this->templateFile($template);
      }
    }
  }

  public function json($content)
  {
    header('Content-Type: application/json');
    echo json_encode($content);
  }

  private function viewFile($view)
  {
    return "../views/$view.php";
  }

  private function templateFile($template)
  {
    return "../views/templates/$template.php";
  }

}
