<?php

class Translate
{
  private $translations;
  private $language;

  public function __construct($languages = array('fr', 'en', 'es', 'de'), $default = 'fr', $config = '../app/config/translations.json')
  {
    if (!is_array($languages)) die("Le paramètres des languages n'est pas un tableau");
    if (!in_array($default, $languages)) die('Le language par défaut doit se trouver dans les languages proposés');
    if (!file_exists($config)) die('Configuration de traduction non trouvée');
    ob_start(); require $config; $this->translations = json_decode(ob_get_clean());
    $browser = (string) (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && $_SERVER['HTTP_ACCEPT_LANGUAGE'] !== '') ? strtok(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']), ',') : '';
    $browser = (!empty($_GET['lang'])) ? $_GET['lang'] : $browser;
    $this->language = (in_array($browser, $languages)) ? $browser : $default;
  }

  public function display($wording, $lang = FALSE)
  { $result = 0; $target = ($lang) ? $lang : $this->language;
    foreach ($this->translations as $translation => $languages)
      if (strval($wording) === $translation)
      {
        foreach ($languages as $language => $value) if ($language === $target) { return $value; $result++; break; }
        break;
      }
    if ($result === 0) die("Pas de traduction pour le language '$target' dans '$wording'");
  }

  public function page($page = 'index')
  {
    return "?lang=$this->language&p=$page";
  }

  public function getLang()
  {
    return $target;
  }

  public function setLang($lang)
  {
    $this->language = strval($lang);
  }
}
