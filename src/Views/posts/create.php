<?php ob_start(); ?>
<div class="row justify-content-center">
  <div class="col-md-8">
    <h3>Créer une publication</h3>
    <?php if (!empty($error)): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="/index.php?action=create_post">
      <div class="mb-3"><label>Titre</label><input name="titre" class="form-control" required></div>
      <div class="mb-3"><label>Contenu</label><textarea name="contenu" rows="6" class="form-control" required></textarea></div>
      <div class="text-end">
        <button class="btn btn-success">Publier</button>
        <a class="btn btn-secondary" href="/index.php?action=index">Annuler</a>
      </div>
    </form>
  </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
