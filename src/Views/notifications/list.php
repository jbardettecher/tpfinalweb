<?php ob_start(); ?>

<h3>Mes notifications</h3>

<div id="notifications">
  <?php foreach ($notifications as $n): ?>
    <div class="border rounded p-2 mb-2 <?= $n['is_read'] ? 'bg-light' : 'bg-warning-subtle' ?>">
      <p><strong><?= htmlspecialchars($n['type']) ?></strong></p>
      <p><?= htmlspecialchars($n['message']) ?></p>
      <small class="text-muted"><?= $n['created_at'] ?></small>
    </div>
  <?php endforeach; ?>
</div>

<a href="/index.php?action=notifications_mark_all" class="btn btn-secondary mt-3">Tout marquer comme lu</a>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
