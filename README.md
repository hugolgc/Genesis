# Genesis

---

Genesis est un framework écrit en PHP avec le design pattern MVC. Il intègre un répertoire de base dans lequel vous ajoutez les outils nécessaires à votre projet.

Pour l'utiliser, vous aurez besoin de [Composer](https://getcomposer.org/) avec la version 7.3 de PHP. Copier et exécuter ce bloc de commande à l'emplacement souhaité du projet.

```jsx
git clone https://github.com/hugolgc/Genesis.git
cd Genesis && rm README.md
composer install && mv hugolgc vendor
```

## Quickstart

---

```php
# public/index.php

$router->get('/api', 'Main::api');

$router->get('/home', 'Home::index'); # nouvelle route

$router->start();
```

```php
# controllers/Home.php

class Home
{
  public function index(): string
  {
    return 'Hello App !';
  }
}
```

### Ajouter une vue

---

```php
use Twig\Environment as Controller;

class Home extends Controller
{
  public function index(): string
  {
    return $this->render('welcome.html', [
      'title' => 'Hello App !'
    ]);
  }
}
```

```html
# views/welcome.html

<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Genesis</title>
    <style>
      body {   
        background: #FAFAFA;
        font-family: sans-serif;
        color: #333;
      }
    </style>
  </head>
  <body>
    <h1>{{ title }}</h1>
  </body>
</html>
```

### Utiliser les paramètres d'url

---

```php
$router->get('/home/:id', 'Home::index');
```

```php
use Twig\Environment as Controller;

class Home extends Controller
{
  public function index(int $id): string
  {
    $title = "Hello App - $id";

    return $this->render('welcome.html', [
      'title' => $title
    ]);
  }
}
```

 

## Méthodes avancées

---

Voici une autre manière d'exécuter du code avec le routeur :

```php
$router->get('/home/:id', function (int $id): string {
  return "Hello App - $id";
});
```

Récupérer les données en utilisant la méthode POST :

```php
# Route accessible uniquement en POST

$router->post('/home', function (): string {
  return 'Hello App - ' . $_POST['name'];
});
```

Le routeur intègre 4 types de méthodes :

```php
$router->get(......);

$router->post(.....);

$router->put(......);

$router->delete(...);
```

Définir une route par défaut (l'url ne correspond à aucune route) :

```php
# Router::start() permet d'exécuter le router et sert aussi de redirection

$router->start();           # Aucune redirection

$router->start(function() { # Redirection vers l'url /home
  header('location: /home');
});
```

## Librairies

---

[Twig](https://twig.symfony.com/doc/3.x/)
[SleekDB](https://sleekdb.github.io/#/installation)
