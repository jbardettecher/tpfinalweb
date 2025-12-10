<?php ob_start(); ?>

<h2 class="mb-3">Toutes les publications</h2>

<?php foreach ($posts as $p): ?>
  <div class="card mb-3">
    <div class="card-body">
      <h4><?= htmlspecialchars($p['titre']) ?></h4>
      <p class="text-muted small">Par <?= htmlspecialchars($p['auteur']) ?> – <?= $p['date_publication'] ?></p>
      <p><?= nl2br(htmlspecialchars(substr($p['contenu'], 0, 250))) ?>...</p>

      <a href="/index.php?action=post&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary">Voir</a>

      <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $p['utilisateur_id']): ?>
        <a href="/index.php?action=delete_post&id=<?= $p['id'] ?>"
           class="btn btn-sm btn-outline-danger"
           onclick="return confirm('Supprimer ?')">Supprimer</a>
      <?php endif; ?>
    </div>
  </div>
<?php endforeach; ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
