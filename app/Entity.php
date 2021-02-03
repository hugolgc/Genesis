<?php

class Entity
{
  private $db_name;
  private $db_host;
  private $db_user;
  private $db_pass;
  private $connect = null;

  public function __construct(string $db_name, string $db_host = 'localhost', string $db_user = 'root', string $db_pass = 'root')
  {
    $this->db_name = $db_name;
    $this->db_host = $db_host;
    $this->db_user = $db_user;
    $this->db_pass = $db_pass;
  }

  private function getPDO(): PDO
  {
    if ($this->connect === null)
    {
      $connect = new PDO("mysql:dbname=$this->db_name;host=$this->db_host", $this->db_user, $this->db_pass);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); $this->connect = $connect;
    }

    return $this->connect;
  }

  public function get(string $statement, bool $fetch = false)
  {
    $req = $this->getPDO()->query($statement);
    $res = ($fetch === true) ? $req->fetch(PDO::FETCH_OBJ) : $req->fetchAll(PDO::FETCH_OBJ);

    return ($this->check($res)) ? $res : false;
  }

  public function set(string $statement): void
  {
    $this->getPDO()->query($statement);
  }

  public function count($statement): int
  {
    if ($statement) return (gettype($statement) === 'object') ? count(get_object_vars($statement)) : count($statement);
    else return 0;
  }

  public function check($statement): bool
  {
    return ($this->count($statement) === 0) ? false : true;
  }

  public function store(string $table, bool $only = false)
  {
    $req = $this->getPDO()->query("SELECT * FROM $table");
    $res = ($only === true) ? $req->fetch(PDO::FETCH_OBJ) : $req->fetchAll(PDO::FETCH_OBJ);

    return ($this->check($res)) ? $res : false;
  }

  public function find(string $table, $value, string $field = 'id')
  {
    $res = $this->getPDO()->query("SELECT * FROM $table HAVING $field = " . '"' . $value . '"')->fetch(PDO::FETCH_OBJ);
    return ($this->check($res)) ? $res : FALSE;
  }

  public function search(string $table, array $data, bool $fetch = true)
  {
    if (empty($data)) die('<pre>Error ~ no value entered for add()</pre>');
    $statement = "SELECT * FROM $table WHERE "; $i = 0;
    foreach ($data as $key => $value)
    { $i++; $statement .= "$key = :$key";
      $statement .= ($i < count($data)) ? ' AND ' : '';
    } $prepare = $this->getPDO()->prepare($statement); $prepare->execute($data);
    $res = ($fetch) ? $prepare->fetch(PDO::FETCH_OBJ) : $prepare->fetchAll(PDO::FETCH_OBJ);
    return ($this->check($res)) ? $res : false;
  }

  public function add(string $table, array $data): void
  {
    if (empty($data)) die('<pre>Error ~ no value entered for add()</pre>');
    $statement = "INSERT INTO $table VALUES ("; $i = 0;
    foreach ($data as $key => $value) $statement .= ($key < count($data) - 1) ? '?,' : '?';
    $statement .= ')'; $this->getPDO()->prepare($statement)->execute($data);
  }

  public function edit(string $table, $data, string $field = 'id', $content = 'no_value'): void
  {
    if (!in_array(gettype($data), ['array', 'object'])) die('<pre>Error ~ use an object or array for edit()</pre>');
    $fields = $this->get("DESCRIBE $table"); $statement = "UPDATE $table SET "; $data = (array) $data;
    foreach ($fields as $key => $value)
    {
      $statement .= "$value->Field = :$value->Field"; $statement .= ($key < count($data) - 1) ? ', ' : ' ';
    } $statement .= "WHERE $field = :reference_$field"; $this->getPDO()->prepare($statement)->execute(
      array_merge($data, ["reference_$field" => ($content === 'no_value') ? $data['id'] : $content]));
  }

  public function newId()
  {
    return $this->getPDO()->lastInsertId();
  }

  public function throw(string $table, $value, string $field = 'id'): void
  {
    $this->getPDO()->query("DELETE FROM $table WHERE $field = " . '"' . $value . '"');
  }

  public function throwAll(string $table): void
  {
    $this->getPDO()->query("DELETE FROM $table");
  }
}