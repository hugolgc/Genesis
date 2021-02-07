<?php

class Upload
{
  private $file;
  private $limit;
  private $rename;
  private $extensions;
  private $target;
  private $report;

  private $error;
  private $name;
  private $size;
  private $tmp_name;

  public function __construct($file, bool $rename = TRUE, float $limit = 2, array $extensions = array('jpg', 'jpeg', 'png'), string $target = '../public/assets/src/')
  {
    $this->file = $file;
    $this->limit = floatval($limit) * 1000000;
    $this->rename = $rename;
    $this->extensions = $extensions;
    $this->target = $target;

    $this->error = $this->file['error'];
    $this->name = $this->file['name'];
    $this->size = $this->file['size'];
    $this->tmp_name = $this->file['tmp_name'];

    $this->upload();
  }

  private function error()
  {
    return ($this->error === 0) ? TRUE : FALSE;
  }

  private function check()
  {
    return (getimagesize($this->tmp_name)) ? TRUE : FALSE;
  }

  private function size()
  {
    return ($this->size > $this->limit) ? TRUE : FALSE;
  }

  private function extension()
  {
    $extension = pathinfo($this->name, PATHINFO_EXTENSION);
    return (in_array($extension, $this->extensions)) ? $extension : FALSE;
  }

  private function generate()
  {
    $fonts = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $maximum = strlen($fonts); $new = '';
    for ($i = 0; $i < 10; $i++) $new .= $fonts[rand(0, $maximum -1)];
    return $new;
  }

  private function rename()
  {
    do { $this->name = $this->generate() . '.' . $this->extension(); }
    while ($this->exist());
  }

  private function exist()
  {
    return (file_exists($this->target . $this->name)) ? TRUE : FALSE;
  }

  private function upload()
  {
    $report = array();
    if (!$this->error()) array_push($report, 'Erreur durant le transfert.');
    if (!$this->check()) array_push($report, 'Le fichier est endommagé.');
    if ($this->size()) array_push($report, 'Le fichier est trop volumineux.');
    if (!$this->extension()) array_push($report, 'Ce type de fichier n\'est pas accepté.');

    if ($this->rename === FALSE) { if ($this->exist()) array_push($report, 'Le fichier existe déjà.'); }
    else $this->rename();

    if (empty($report)) { if (!move_uploaded_file($this->tmp_name, $this->target . $this->name)) array_push($report, 'Erreur dans l\'exportation du fichier.'); $this->report = $report; }
    else return $this->report = $report;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getReport()
  {
    return $this->report;
  }
}
