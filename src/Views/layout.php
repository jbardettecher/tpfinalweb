<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Intranet Social</title>
  <link href="/css/style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand bg-white border-bottom mb-4">
  <div class="container">
    <a class="navbar-brand" href="/index.php?action=home">Intranet</a>
    <div>
      <?php if (!empty($_SESSION['user_id'])): ?>
        <span class="me-2">Bonjour, <?= htmlspecialchars($_SESSION['user_name'] ?? '') ?></span>
        <a class="btn btn-outline-secondary btn-sm" href="/index.php?action=logout">Se déconnecter</a>
      <?php else: ?>
        <a class="btn btn-primary btn-sm" href="/index.php?action=login">Se connecter</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<div class="container">
  <?php if (isset($content)) echo $content; ?>
</div>

<script src="/js/script.js"></script>
</body>
</html>
