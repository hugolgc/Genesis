<?php

namespace Genesis;

class Api
{
  public static function json($data): string
  {
    header('Content-Type: application/json');
    return json_encode($data);
  }
}