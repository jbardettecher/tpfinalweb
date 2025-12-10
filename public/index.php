<?php
// Simple router for the app
require_once __DIR__ . '/../src/Controllers/UserController.php';
require_once __DIR__ . '/../src/Controllers/PostController.php';
require_once __DIR__ . '/../src/Controllers/CommentController.php';

$action = $_GET['action'] ?? 'home';

$userCtrl = new UserController();
$postCtrl = new PostController();
$commentCtrl = new CommentController();

switch ($action) {
    case 'home':
        $postCtrl->home();
        break;
    case 'index':
        $postCtrl->list();
        break;
    case 'create_post':
    case 'create':
        $postCtrl->create();
        break;
    case 'delete_post':
    case 'delete':
        $postCtrl->delete();
        break;
    case 'post':
        $id = intval($_GET['id'] ?? 0);
        if ($id) $commentCtrl->showPost($id);
        else { http_response_code(404); echo "Post not found."; }
        break;
    case 'add_comment':
        $commentCtrl->add();
        break;
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $userCtrl->register();
        else $userCtrl->showRegister();
        break;
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $userCtrl->login();
        else $userCtrl->showLogin();
        break;
    case 'logout':
        $userCtrl->logout();
        break;
    default:
        http_response_code(404);
        echo "404 Not Found";
        break;

    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userCtrl->register();
        } else {
            $userCtrl->showRegister();
        }
    break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userCtrl->login();
        } else {
            $userCtrl->showLogin();
        }
        break;

    case 'logout':
        $userCtrl->logout();
        break;

    case 'profile':
        $userCtrl->profile();
        break;

}
