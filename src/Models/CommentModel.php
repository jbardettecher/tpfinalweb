<?php
require_once __DIR__ . '/Database.php';

class CommentModel {
    private PDO $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function createComment($contenu, $uid, $post_id): bool {
        $sql = "INSERT INTO comments (contenu, utilisateur_id, post_id)
                VALUES (:c, :u, :p)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':c', $contenu);
        $stmt->bindParam(':u', $uid);
        $stmt->bindParam(':p', $post_id);

        return $stmt->execute();
    }

    public function getCommentsForPost($post_id): array {
        $sql = "SELECT c.*, u.nom as auteur 
                FROM comments c
                JOIN users u ON u.id = c.utilisateur_id
                WHERE c.post_id = :pid";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':pid' => $post_id]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
