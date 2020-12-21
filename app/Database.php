<?php

class Database
{
  private $db_name;
  private $db_host;
  private $db_user;
  private $db_pass;
  private $connect;

  public function __construct($db_name, $db_host = 'localhost', $db_user = 'root', $db_pass = 'root')
  {
    $this->db_name = $db_name;
    $this->db_host = $db_host;
    $this->db_user = $db_user;
    $this->db_pass = $db_pass;
  }

  private function getPDO()
  {
    if ($this->connect === NULL)
    {
      $connect = new PDO("mysql:dbname=$this->db_name;host=$this->db_host", $this->db_user, $this->db_pass);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->connect = $connect;
    }

    return $this->connect;
  }

  public function get($statement, $only = FALSE)
  {
    $req = $this->getPDO()->query($statement);
    $res = ($only === TRUE) ? $req->fetch(PDO::FETCH_OBJ) : $req->fetchAll(PDO::FETCH_OBJ);

    return $res;
  }

  public function set($statement)
  {
    $this->getPDO()->query($statement);
  }

  public function count($statement)
  {
    if ($statement) return (gettype($statement) === 'object') ? count(get_object_vars($statement)) : count($statement);
    else return 0;
  }

  public function check($statement)
  {
    return ($this->count($statement) === 0) ? FALSE : TRUE;
  }

  public function store($table, $only = FALSE)
  {
    $req = $this->getPDO()->query("SELECT * FROM $table");
    $res = ($only === TRUE) ? $req->fetch(PDO::FETCH_OBJ) : $req->fetchAll(PDO::FETCH_OBJ);

    return $res;
  }

  public function find($table, $value, $field = 'id')
  {
    return $this->getPDO()->query("SELECT * FROM $table WHERE $field = '$value'")->fetch(PDO::FETCH_OBJ);
  }

  public function findAll($table, $value, $field = 'email')
  {
    return $this->getPDO()->query("SELECT * FROM $table WHERE $field = '$value'")->fetchAll(PDO::FETCH_OBJ);
  }
}
