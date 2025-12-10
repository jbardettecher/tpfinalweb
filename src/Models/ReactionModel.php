<?php
require_once __DIR__ . '/Database.php';

class ReactionModel {
    private PDO $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function toggleLike($userId, $postId): bool {
        $check = $this->pdo->prepare("SELECT id FROM reactions WHERE utilisateur_id = :u AND post_id = :p");
        $check->execute([':u' => $userId, ':p' => $postId]);

        if ($check->fetch()) {
            $del = $this->pdo->prepare("DELETE FROM reactions WHERE utilisateur_id = :u AND post_id = :p");
            return $del->execute([':u' => $userId, ':p' => $postId]);
        } else {
            $ins = $this->pdo->prepare("INSERT INTO reactions (utilisateur_id, post_id) VALUES (:u, :p)");
            return $ins->execute([':u' => $userId, ':p' => $postId]);
        }
    }

    public function countForPost($postId): int {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total FROM reactions WHERE post_id = :p");
        $stmt->execute([':p' => $postId]);
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
