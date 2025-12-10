<?php
require_once __DIR__ . '/../Models/PostModel.php';
require_once __DIR__ . '/../Models/CommentModel.php';

class PostController {

    private PostModel $postModel;
    private CommentModel $commentModel;

    public function __construct() {
        session_start();
        $this->postModel = new PostModel();
        $this->commentModel = new CommentModel();
    }

    public function home() {
        $posts = $this->postModel->getAllPosts();
        require __DIR__ . '/../Views/home.php';
    }

    public function list() {
        $posts = $this->postModel->getAllPosts();
        require __DIR__ . '/../Views/posts/list.php';
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /index.php?action=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = $_POST['titre'] ?? null;
            $contenu = $_POST['contenu'] ?? null;
            $uid = $_SESSION['user_id'];

            if ($titre && $contenu) {
                $this->postModel->createPost($titre, $contenu, $uid);
                header("Location: /index.php?action=index");
                exit;
            } else {
                $error = "Tous les champs sont requis.";
                require __DIR__ . '/../Views/posts/create.php';
            }

        } else {
            require __DIR__ . '/../Views/posts/create.php';
        }
    }

    public function delete() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /index.php?action=login");
            exit;
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->postModel->deletePost($id, $_SESSION['user_id']);
        }

        header("Location: /index.php?action=index");
        exit;
    }
}