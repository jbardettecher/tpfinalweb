<?php
require_once __DIR__ . '/Database.php';

class PostModel {
    private PDO $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function createPost($titre, $contenu, $utilisateur_id): bool {
        $sql = "INSERT INTO posts (titre, contenu, utilisateur_id)
                VALUES (:titre, :contenu, :uid)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':contenu', $contenu);
        $stmt->bindParam(':uid', $utilisateur_id);

        return $stmt->execute();
    }

    public function getAllPosts(): array {
        $sql = "SELECT p.*, u.nom AS auteur FROM posts p
                JOIN users u ON u.id = p.utilisateur_id
                ORDER BY p.date_publication DESC";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
