<?php ob_start(); ?>
<?php if ($post): ?>
  <div class="card mb-3">
    <div class="card-body">
      <h3><?= htmlspecialchars($post['titre']) ?></h3>
      <p class="text-muted small">Par <?= htmlspecialchars($post['auteur']) ?> - <?= $post['date_publication'] ?></p>
      <p><?= nl2br(htmlspecialchars($post['contenu'])) ?></p>
    </div>
  </div>

  <h5>Commentaires</h5>
  <div id="comments">
    <?php foreach ($comments as $c): ?>
      <div class="border rounded p-2 mb-2">
        <p class="mb-1"><strong><?= htmlspecialchars($c['auteur']) ?></strong> <small class="text-muted"><?= $c['date_commentaire'] ?></small></p>
        <p><?= nl2br(htmlspecialchars($c['contenu'])) ?></p>
      </div>
    <?php endforeach; ?>
  </div>

  <?php if (!empty($_SESSION['user_id'])): ?>
    <div class="mt-3">
      <textarea id="new-comment" class="form-control mb-2" rows="3" placeholder="Écrire un commentaire..."></textarea>
      <button class="btn btn-primary" onclick="addComment(<?= $post['id'] ?>, document.getElementById('new-comment'))">Commenter</button>
    </div>
  <?php else: ?>
    <div class="alert alert-info">Connectez-vous pour commenter.</div>
  <?php endif; ?>

<?php else: ?>
  <p>Publication introuvable.</p>
<?php endif; ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
