<?php ob_start(); ?>

<h3>Recherche</h3>

<input id="live-search" class="form-control mb-3" placeholder="Rechercher...">

<div id="results"></div>

<script src="/js/search.js"></script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
