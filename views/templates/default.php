<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Genesis</title>
    <link rel="shortcut icon" href="<?= src('favicon.ico') ?>">
    <link rel="stylesheet" href="<?= css('genesis') ?>">
  </head>
  <body class="genesis">
    <h1>Genesis</h1>
    <nav>
      <a href="<?= page('index') ?>">Index</a>
    </nav>
    <?= $content ?>
    <script src="<?= js('jquery') ?>"></script>
  </body>
</html>
