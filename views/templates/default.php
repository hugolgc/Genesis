<!DOCTYPE html>
<html lang="<?= $data->getLang() ?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genesis</title>
    <link rel="shortcut icon" href="<?= src('favicon.ico') ?>">
    <link rel="stylesheet" href="<?= css('genesis') ?>">
  </head>
  <body class="genesis">
    <h1>Genesis</h1>
    <nav>
      <a href="<?= lang('fr') ?>"><?= $data->display('example', 'fr') ?></a>
      <a href="<?= lang('en') ?>"><?= $data->display('example', 'en') ?></a>
      <a href="<?= lang('es') ?>"><?= $data->display('example', 'es') ?></a>
      <a href="<?= lang('de') ?>"><?= $data->display('example', 'de') ?></a>
    </nav>
    <?= $content ?>
    <script src="<?= js('jquery') ?>"></script>
  </body>
</html>
