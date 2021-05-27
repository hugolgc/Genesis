<?php

namespace Genesis;
use ReflectionMethod;
use Twig\Loader\FilesystemLoader;

class Link
{
  private $path;
  private $callback;
  private $matches = [];

  public function __construct(string $path, $callback)
  {
    $this->path = trim($path, '/');
    $this->callback = $callback;
  }

  public function match(string $url): bool
  {
    $url = trim($url, '/');
    $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
    $regex = "#^$path$#i";

    if (!preg_match($regex, $url, $matches)) return false;
    array_shift($matches); $this->matches = $matches; return true;
  }

  public function call(): void
  {
    switch (gettype($this->callback))
    {
      case 'string':
        $callback = explode('::', $this->callback);
        require_once '../controllers/' . $callback[0] . '.php';
        $call = new ReflectionMethod($callback[0], $callback[1]);
        $action = $call->invokeArgs(new $callback[0](new FilesystemLoader('../views')), $this->matches); break;

      case 'object': $action = call_user_func_array($this->callback, $this->matches); break;

      default: die('<pre>Error ~ use an object or an array</pre>');
    }

    switch (gettype($action))
    {
      case 'integer': case 'double': case 'string': echo $action; break;
      case 'array': case 'object': case 'boolean': var_dump($action); break;
    }
  }
}