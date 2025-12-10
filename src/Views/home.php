<?php
// wrap content into layout
ob_start();
?>
<div class="row">
  <div class="col-md-8">
    <h2>Fil d'actualités</h2>
    <?php foreach ($posts as $p): ?>
      <div class="card mb-3">
        <div class="card-body">
          <h5><?= htmlspecialchars($p['titre']) ?></h5>
          <p class="text-muted small">Par <?= htmlspecialchars($p['auteur']) ?> - <?= $p['date_publication'] ?></p>
          <p><?= nl2br(htmlspecialchars(substr($p['contenu'], 0, 400))) ?></p>
          <a href="/index.php?action=post&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary">Voir</a>
          <button onclick="toggleLike(<?= $p['id'] ?>, this)" class="btn btn-sm btn-outline-danger">❤ <?= $p['id'] /* placeholder */ ?></button>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="col-md-4">
    <?php if (!empty($_SESSION['user_id'])): ?>
      <div class="card p-3 mb-3">
        <a href="/index.php?action=create_post" class="btn btn-success w-100">Créer une publication</a>
      </div>
    <?php else: ?>
      <div class="alert alert-info">Connectez-vous pour publier et commenter.</div>
    <?php endif; ?>
  </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
