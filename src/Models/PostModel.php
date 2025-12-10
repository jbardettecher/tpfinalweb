<?php
// app/Models/PostModel.php

// Assurez-vous que le chemin d'accès à Database.php est correct
require_once 'Database.php'; 
// Assurez-vous d'avoir un UserModel.php si vous avez besoin d'informations utilisateur

class PostModel {
    private $db;

    public function __construct() {
        $database = new Database(); // Instanciation de votre classe Database
        $this->db = $database->getConnection();
        
        // Si la connexion échoue, $this->db sera null. Il faut s'assurer qu'elle est valide.
        if (!$this->db) {
            // Dans un environnement de production, vous lanceriez une exception ou logueriez l'erreur
            die("Erreur de connexion à la base de données.");
        }
    }

    /**
     * Crée un nouveau message dans la base de données.
     */
    public function createPost($titre, $contenu, $utilisateur_id) {
        $sql = "INSERT INTO posts (titre, contenu, utilisateur_id) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$titre, $contenu, $utilisateur_id]);
    }

    /**
     * Récupère tous les messages avec le nom de l'auteur, le compte de commentaires et de réactions.
     * Les posts sont ordonnés du plus récent au plus ancien.
     * NOTE: Nécessite les tables 'reactions' et 'comments'
     */
    public function getAllPostsWithUsers() {
        $sql = "SELECT 
                    p.*, 
                    u.nom AS auteur_nom,
                    COUNT(DISTINCT c.id) AS comment_count,
                    COUNT(DISTINCT r.id) AS reaction_count
                FROM posts p 
                JOIN users u ON p.utilisateur_id = u.id 
                LEFT JOIN comments c ON p.id = c.post_id
                LEFT JOIN reactions r ON p.id = r.post_id
                GROUP BY p.id
                ORDER BY p.date_publication DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Récupère un message par son ID.
     */
    public function getPostById($post_id) {
        $sql = "SELECT p.*, u.nom AS auteur_nom FROM posts p JOIN users u ON p.utilisateur_id = u.id WHERE p.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$post_id]);
        return $stmt->fetch();
    }

    /**
     * Met à jour un message, uniquement si l'utilisateur est l'auteur.
     */
    public function updatePost($post_id, $titre, $contenu, $utilisateur_id) {
        $sql = "UPDATE posts SET titre = ?, contenu = ? WHERE id = ? AND utilisateur_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$titre, $contenu, $post_id, $utilisateur_id]);
    }

    /**
     * Supprime un message, uniquement si l'utilisateur est l'auteur.
     */
    public function deletePost($post_id, $utilisateur_id) {
        $sql = "DELETE FROM posts WHERE id = ? AND utilisateur_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$post_id, $utilisateur_id]);
    }
}