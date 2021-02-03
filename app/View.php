<?php

class View
{
  private $options = ['extension' => '.html'];
  private $view;

  public function __construct()
  {
    $this->view = new Mustache_Engine([
      'pragmas' => [Mustache_Engine::PRAGMA_BLOCKS],
      'loader' => new Mustache_Loader_FilesystemLoader(dirname(__DIR__) . '/views', $this->options),
      'partials_loader' => new Mustache_Loader_FilesystemLoader(dirname(__DIR__) . '/views/layouts', $this->options)
    ]);
  }

  public function send(string $view, array $data = [])
  {
    echo (new Mustache_Engine)->render($view, $data);
  }

  public function render(string $view, array $data = [])
  {
    echo $this->view->render($view, $data);
  }

  public function json($data)
  {
    header('Content-Type: application/json');
    echo json_encode($data);
  }

  public function xml($data, string $tag = 'root')
  {
    header('Content-Type: application/xml');
    $xml = new SimpleXMLElement("<$tag/>");
    array_walk_recursive($data, array ($xml, 'addChild'));
    print $xml->asXML();
  }
}