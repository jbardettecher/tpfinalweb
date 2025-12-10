<?php ob_start(); ?>

<h2>Mon Profil</h2>

<div class="card p-3">
  <p><strong>Nom :</strong> <?= htmlspecialchars($user['nom']) ?></p>
  <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
  <p><strong>Date d'inscription :</strong> <?= $user['date_inscription'] ?></p>

  <hr>

  <h4>Modifier mes informations</h4>

  <?php if (!empty($msg)): ?>
    <div class="alert alert-info"><?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>

  <form method="post" action="/index.php?action=profile">
    <div class="mb-3">
      <label>Nom</label>
      <input name="nom" class="form-control" value="<?= htmlspecialchars($user['nom']) ?>">
    </div>

    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>">
    </div>

    <button class="btn btn-success">Mettre à jour</button>
  </form>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
