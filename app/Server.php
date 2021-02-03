<?php

class Server
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
    array_shift($matches); $this->matches = $matches;

    return true;
  }

  public function call(): void
  {
    switch (gettype($this->callback))
    {
      case 'array':
        require_once dirname(__DIR__) . '/controller/' . $this->callback[0] . '.php';
        $call = new ReflectionMethod($this->callback[0], $this->callback[1]);
        $call->invokeArgs(new $this->callback[0](), $this->matches);
        break;

      case 'object': call_user_func_array($this->callback, $this->matches); break;

      default: die('<pre>Error ~ use an object or an array</pre>');
    }
  }
}
