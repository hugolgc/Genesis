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
    
    return ($this->check($res)) ? $res : FALSE;
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

    return ($this->check($res)) ? $res : FALSE;
  }

  public function find($table, $value, $field = 'id')
  {
    $res = $this->getPDO()->query("SELECT * FROM $table HAVING $field = " . '"' . $value . '"')->fetch(PDO::FETCH_OBJ);
    return ($this->check($res)) ? $res : FALSE;
  }

  public function findAll($table, $value, $field = 'email')
  {
    $res = $this->getPDO()->query("SELECT * FROM $table HAVING $field = " . '"' . $value . '"')->fetchAll(PDO::FETCH_OBJ);
    return ($this->check($res)) ? $res : FALSE;
  }

  public function add($table, $data)
  {
    $statement = "INSERT INTO $table VALUES (";
    $i = 0; foreach ($data as $value)
    { if ($value === null) $statement .= 'null';
      elseif ($value === true) $statement .= 1;
      elseif ($value === false) $statement .= 0;
      else $statement .= '"' . $value . '"'; $i++;
      if ($i < count($data)) $statement .= ',';
    } $statement .= ')';
    
    $this->getPDO()->query($statement);
  }

  public function newId()
  {
    return $this->getPDO()->lastInsertId();
  }

  public function edit($table, $data, $field = 'id', $value = 'no_value')
  {
    $count = (gettype($data) === 'object') ? count(get_object_vars($data)) : count($data);
    $fields = $this->getPDO()->query("DESCRIBE $table")->fetchAll(PDO::FETCH_ASSOC);
    $statement = "UPDATE $table SET "; $index = NULL;

    $i = 0; foreach ($data as $column)
    {
      if ($fields[$i]['Field'] === $field) $index = (gettype($data) === 'object') ? $field : $i;
      $statement .= $fields[$i]['Field'] . ' = ';
      if ($column === NULL) $statement .= 'null';
      elseif ($column === TRUE) $statement .= 1;
      elseif ($column === FALSE) $statement .= 0;
      else $statement .= '"' . $column . '"'; $i++;
      if ($i < $count) $statement .= ',';
    }

    if ($index === NULL) die("Le champ '$field' n'existe pas.");
    elseif ($value === 'no_value')
    {
      $value = (gettype($data) === 'object') ? $data->$index : $data[$index];
      $condition = '"' . $value . '"';
    }
    elseif ($value === NULL) $condition = 'null';
    elseif ($value === TRUE) $condition = 1;
    elseif ($value === FALSE) $condition = 0;
    else $condition = '"' . $value . '"';
    $statement .= " WHERE $field = $condition";
    
    $this->getPDO()->query($statement);
  }

  public function throw($table, $value, $field = 'id')
  {
    $this->getPDO()->query("DELETE FROM $table WHERE $field = " . '"' . $value . '"');
  }

  public function throwAll($table)
  {
    $this->getPDO()->query("DELETE FROM $table");
  }
}
