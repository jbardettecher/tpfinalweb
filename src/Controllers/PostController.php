<?php
// app/Controllers/PostController.php

require_once 'src/Models/PostModel.php';
// Nécessite la classe CommentModel
require_once 'src/Models/CommentModel.php'; 

class PostController {
    private $postModel;
    private $commentModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->postModel = new PostModel();
        // Le CommentModel devra aussi être adapté pour utiliser votre Database.php
        // $this->commentModel = new CommentModel(); 
    }

    private function requireAuth() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    public function index() {
        $this->requireAuth();
        
        $posts = $this->postModel->getAllPostsWithUsers();
        
        // La récupération des commentaires est ici commentée pour simplifier sans CommentModel complet
        // foreach ($posts as &$post) {
        //     $post['comments'] = $this->commentModel->getCommentsByPostId($post['id']);
        // }
        
        include 'views/home.php'; 
    }

    public function create() {
        $this->requireAuth();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = trim($_POST['titre']);
            $contenu = trim($_POST['contenu']);
            $utilisateur_id = $_SESSION['user_id'];

            if (empty($titre) || empty($contenu)) {
                $error = "Le titre et le contenu ne peuvent pas être vides.";
            } else {
                if ($this->postModel->createPost($titre, $contenu, $utilisateur_id)) {
                    // Redirection pour éviter la re-soumission du formulaire
                    header('Location: /');
                    exit;
                } else {
                    $error = "Une erreur est survenue lors de la publication.";
                }
            }
        }
        include 'views/posts/create.php';
    }

    public function edit($id) {
        $this->requireAuth();
        $post = $this->postModel->getPostById($id);
        $error = '';
        
        if (!$post || $post['utilisateur_id'] != $_SESSION['user_id']) {
            header('Location: /');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = trim($_POST['titre']);
            $contenu = trim($_POST['contenu']);
            
            if ($this->postModel->updatePost($id, $titre, $contenu, $_SESSION['user_id'])) {
                 header('Location: /'); 
                 exit;
            } else {
                $error = "Erreur lors de la mise à jour.";
            }
        }
        include 'views/posts/edit.php';
    }

    public function delete($id) {
        $this->requireAuth();
        
        if ($this->postModel->deletePost($id, $_SESSION['user_id'])) {
            header('Location: /');
            exit;
        } else {
            header('Location: /'); // Échec de la suppression ou non-appartenance
            exit;
        }
    }
}