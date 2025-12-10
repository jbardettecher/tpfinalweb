<?php
// endpoints AJAX: located at /src/Controllers/AjaxController.php
require_once __DIR__ . '/../Models/CommentModel.php';
require_once __DIR__ . '/../Models/ReactionModel.php';
require_once __DIR__ . '/../Models/VoteModel.php'; // optional if exists
session_start();

$action = $_GET['a'] ?? null;
header('Content-Type: application/json; charset=utf-8');

if ($action === 'addComment') {
    $postId = intval($_POST['post_id'] ?? 0);
    $content = trim($_POST['content'] ?? '');
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['ok'=>false,'msg'=>'Not authenticated']); exit;
    }
    if ($content === '' || $postId<=0) {
        echo json_encode(['ok'=>false,'msg'=>'Invalid input']); exit;
    }
    $cm = new CommentModel();
    $ok = $cm->createComment($content, $_SESSION['user_id'], $postId);
    if ($ok) {
        echo json_encode(['ok'=>true,'msg'=>'Comment added']);
    } else {
        echo json_encode(['ok'=>false,'msg'=>'DB error']);
    }
    exit;
}

if ($action === 'toggleLike') {
    if (!isset($_SESSION['user_id'])) { echo json_encode(['ok'=>false,'msg'=>'Not auth']); exit; }
    $postId = intval($_POST['post_id'] ?? 0);
    $rm = new ReactionModel();
    $ok = $rm->toggleLike($_SESSION['user_id'], $postId);
    $count = $rm->countForPost($postId);
    echo json_encode(['ok'=>$ok,'count'=>$count]);
    exit;
}

// Votes (if VoteModel implemented)
if ($action === 'voteComment') {
    if (!isset($_SESSION['user_id'])) { echo json_encode(['ok'=>false,'msg'=>'Not auth']); exit; }
    $commentId = intval($_POST['comment_id'] ?? 0);
    $vote = intval($_POST['vote'] ?? 0); // 1 or -1
    if ($vote !== 1 && $vote !== -1) { echo json_encode(['ok'=>false,'msg'=>'Invalid vote']); exit; }
    if (!file_exists(__DIR__ . '/../Models/VoteModel.php')) {
        echo json_encode(['ok'=>false,'msg'=>'Vote model missing']); exit;
    }
    require_once __DIR__ . '/../Models/VoteModel.php';
    $vm = new VoteModel();
    $ok = $vm->castVote($_SESSION['user_id'], $commentId, $vote);
    echo json_encode(['ok'=>$ok]);
    exit;
}

echo json_encode(['ok'=>false,'msg'=>'Unknown action']);
exit;
