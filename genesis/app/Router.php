<?php

class Router
{
  private $url;
  private $method;
  private $routes = [];

  public function __construct(?string $url = null)
  {
    $this->url = ($url === null) ? $_GET['url'] : $url;
    $this->method = $_SERVER['REQUEST_METHOD'];
  }

  public function get(string $path, $callback): void
  {
    $this->routes['GET'][] = new Server($path, $callback);
  }

  public function post(string $path, $callback): void
  {
    $this->routes['POST'][] = new Server($path, $callback);
  }

  public function put(string $path, $callback): void
  {
    $this->routes['PUT'][] = new Server($path, $callback);
  }

  public function delete(string $path, $callback): void
  {
    $this->routes['DELETE'][] = new Server($path, $callback);
  }

  public function server($callback = null): void
  {
    if (!isset($this->routes[$this->method])) die('<pre>Error ~ no route found</pre>');

    foreach ($this->routes[$this->method] as $server)
      if ($server->match($this->url)) { $server->call(); exit; }

    if ($callback !== null) { (new Server('*', $callback))->call(); exit; }

    die('<pre>Error ~ no route found</pre>');
  }
}
