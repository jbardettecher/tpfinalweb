<?php
require_once __DIR__ . '/../Models/CommentModel.php';

class CommentController {
    private CommentModel $commentModel;

    public function __construct() {
        session_start();
        $this->commentModel = new CommentModel();
    }

    // Affiche la page d'un post avec ses commentaires
    public function showPost($id) {
        require_once __DIR__ . '/../Models/PostModel.php';
        $postModel = new PostModel();
        $post = $postModel->getPostById($id);
        $comments = $this->commentModel->getCommentsForPost($id);
        require __DIR__ . '/../Views/posts/show.php';
    }

    // Création classique (non-AJAX fallback)
    public function add() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /index.php?action=login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post_id = $_POST['post_id'] ?? null;
            $content = $_POST['content'] ?? null;
            if ($post_id && $content) {
                $this->commentModel->createComment($content, $_SESSION['user_id'], $post_id);
            }
        }
        // redirige vers le post
        header('Location: /index.php?action=post&id=' . intval($post_id));
        exit;
    }
}
