<?php
require_once __DIR__ . '/Database.php';

class NotificationModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function createNotification($userId, $type, $message) {
        $sql = "INSERT INTO notifications (user_id, type, message, is_read, created_at)
                VALUES (:uid, :type, :msg, 0, NOW())";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':uid', $userId);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':msg', $message);

        return $stmt->execute();
    }

    public function getUserNotifications($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM notifications 
                                      WHERE user_id = :uid
                                      ORDER BY created_at DESC");
        $stmt->bindParam(':uid', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markAllAsRead($userId) {
        $stmt = $this->conn->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = :uid");
        $stmt->bindParam(':uid', $userId);
        return $stmt->execute();
    }

    public function countUnread($userId) {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) FROM notifications WHERE user_id = :uid AND is_read = 0"
        );
        $stmt->bindParam(':uid', $userId);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
