<?php

session_start();
if (!isset($_SESSION['logged'])) $_SESSION['logged'] = FALSE;
spl_autoload_register(function ($class) { require "../app/$class.php"; });
$page = (!empty($_GET['p'])) ? $_GET['p'] : 'index';
$id = (!empty($_GET['id'])) ? $_GET['id'] : 0;
$post = (!empty($_POST)) ? $_POST : NULL;
$files = (!empty($_FILES)) ? $_FILES : NULL;
$view = new View();

function page($page = 'index') { return "?p=$page"; }
function single($id) { return "?p=single&id=$id"; }
function css($style) { return "assets/css/$style"; }
function js($script) { return "assets/js/$script"; }
function src($file) { return "assets/src/$file"; }
function secure($string) { return htmlspecialchars(addslashes($string)); }
function location($page = 'index') { header("location: ?p=$page"); }
function trash($name, $target = '../public/assets/src/') { unlink($target . $name); }
function sessionDestroy() { $_SESSION = array();
  if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000, $params["path"],
      $params["domain"], $params["secure"], $params["httponly"]);
  } session_destroy();
}
