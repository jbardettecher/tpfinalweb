<?php
require_once __DIR__ . '/../Models/PostModel.php';
require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/CommentModel.php';

class SearchController {

    public function live() {
        require __DIR__ . '/../Views/search/live.php';
    }

    public function ajax() {
        header('Content-Type: application/json');
        $q = trim($_GET['q'] ?? '');

        if ($q === '') {
            echo json_encode([]);
            exit;
        }

        $postModel = new PostModel();
        $userModel = new UserModel();
        $commentModel = new CommentModel();

        $results = [
            "users" => $userModel->search($q),
            "posts" => $postModel->search($q),
            "comments" => $commentModel->search($q),
        ];

        echo json_encode($results);
        exit;
    }
}
