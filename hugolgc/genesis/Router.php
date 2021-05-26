<?php

namespace Genesis;

class Router
{
  private $url;
  private $method;
  private $routes = [];

  public function __construct()
  {
    $this->url = $_GET['url'];
    $this->method = $_SERVER['REQUEST_METHOD'];
  }

  public function get(string $path, $callback): void
  {
    $this->routes['GET'][] = new Link($path, $callback);
  }

  public function post(string $path, $callback): void
  {
    $this->routes['POST'][] = new Link($path, $callback);
  }

  public function put(string $path, $callback): void
  {
    $this->routes['PUT'][] = new Link($path, $callback);
  }

  public function delete(string $path, $callback): void
  {
    $this->routes['DELETE'][] = new Link($path, $callback);
  }

  public function start($callback = null): void
  {
    if (!isset($this->routes[$this->method])) die('<pre>Error ~ no route found</pre>');

    foreach ($this->routes[$this->method] as $route)
      if ($route->match($this->url)) { $route->call(); exit; }

    if ($callback !== null) { (new Link('*', $callback))->call(); exit; }

    die('<pre>Error ~ no route found</pre>');
  }
}