<?php ob_start(); ?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <h3 class="mb-3">Inscription</h3>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="/index.php?action=register">
      <div class="mb-3">
        <label>Nom</label>
        <input name="nom" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Mot de passe</label>
        <input type="password" name="password" class="form-control" required minlength="5">
      </div>

      <button class="btn btn-primary w-100">Créer un compte</button>

      <div class="mt-3 text-center">
        <a href="/index.php?action=login">Déjà un compte ? Se connecter</a>
      </div>
    </form>
  </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
