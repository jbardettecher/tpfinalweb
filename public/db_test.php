<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR . 'Database.php';

$db = new Database();
$conn = $db->getConnection();

if ($conn) {
  echo "Connexion à la base OK.<br>";
  try {
    $stmt = $conn->query('SELECT VERSION()');
    $v = $stmt->fetch();
    echo "MySQL version: " . htmlspecialchars($v[0]);
  } catch (PDOException $e) {
    echo "Erreur lors de la requête de test: " . htmlspecialchars($e->getMessage());
  }
} else {
  echo "Échec de la connexion à la base. Vérifiez `src/Models/Database.php` et les logs PHP.<br>";
}
