<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Genesis</title>
    <link rel="shortcut icon" href="<?= src('icon.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= css('genesis.font.css') ?>">
  </head>
  <body class="font-genesis">
    <h1>Genesis</h1>
    <nav>
      <ul>
        <li>
          <a href="<?= page('index') ?>">Index</a>
        </li>
      </ul>
    </nav>
    <?= $content ?>
    <script charset="utf-8" src="<?= js('jquery.min.js') ?>"></script>
  </body>
</html>
