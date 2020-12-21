<section>
  <h2>Index</h2>

  <?php foreach ($data as $article): ?>

    <article>
      <h3><?= $article->titre ?></h3>
      <p><?= $article->contenu ?></p>
      <a href="<?= single($article->id) ?>">Voir</a>
    </article>

  <?php endforeach; ?>

</section>