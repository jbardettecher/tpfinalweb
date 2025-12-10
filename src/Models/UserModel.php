<?php
require_once __DIR__ . '/Database.php';

class UserModel {
    private PDO $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Créer un utilisateur
    public function register($nom, $email, $password) {
        // Vérifier email unique
        $check = $this->conn->prepare("SELECT id FROM users WHERE email = :email");
        $check->bindParam(':email', $email);
        $check->execute();

        if ($check->fetch()) {
            return "Cet email est déjà utilisé.";
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("
            INSERT INTO users (nom, email, password, date_inscription)
            VALUES (:nom, :email, :password, NOW())
        ");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hash);

        return $stmt->execute() ? true : "Erreur lors de l'inscription.";
    }

    // Vérifier connexion
    public function login($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nom, $email) {
        $stmt = $this->conn->prepare("UPDATE users SET nom = :nom, email = :email WHERE id = :id");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
