
<?php
session_start();
header('Content-Type: application/json');

require_once '../Models/CommentModel.php';
require_once '../Models/Database.php';

$action = $_POST['action'] ?? '';

if ($action === 'add_comment') {
    addComment();
} elseif ($action === 'get_comments') {
    getComments();
}

function addComment() {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Vous devez être connecté']);
        return;
    }
    
    $postId = $_POST['post_id'] ?? null;
    $commentText = $_POST['comment_text'] ?? null;
    $userId = $_SESSION['user_id'];
    
    if (!$postId || !$commentText) {
        echo json_encode(['success' => false, 'message' => 'Données manquantes']);
        return;
    }
    
    $commentModel = new CommentModel();
    $result = $commentModel->addComment($postId, $userId, $commentText);
    
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Commentaire ajouté']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout']);
    }
}

function getComments() {
    $postId = $_POST['post_id'] ?? null;
    
    if (!$postId) {
        echo json_encode([]);
        return;
    }
    
    $commentModel = new CommentModel();
    $comments = $commentModel->getCommentsByPostId($postId);
    
    echo json_encode($comments);
}
?>