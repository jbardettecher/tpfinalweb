
<?php
require_once 'Database.php';

class CommentModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function addComment($postId, $userId, $content) {
        $query = "INSERT INTO comments (post_id, user_id, content, created_at) 
                  VALUES (:post_id, :user_id, :content, NOW())";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':post_id' => $postId,
            ':user_id' => $userId,
            ':content' => htmlspecialchars($content)
        ]);
    }
    
    public function getCommentsByPostId($postId) {
        $query = "SELECT c.id, c.content, c.created_at, u.username 
                  FROM comments c 
                  JOIN users u ON c.user_id = u.id 
                  WHERE c.post_id = :post_id 
                  ORDER BY c.created_at DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([':post_id' => $postId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>