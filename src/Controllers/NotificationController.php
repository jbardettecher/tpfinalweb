<?php
require_once __DIR__ . '/../Models/NotificationModel.php';

class NotificationController {
    private $model;

    public function __construct() {
        session_start();
        $this->model = new NotificationModel();
    }

    public function list() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /index.php?action=login");
            exit;
        }

        $notifications = $this->model->getUserNotifications($_SESSION['user_id']);
        require __DIR__ . '/../Views/notifications/list.php';
    }

    public function markAll() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /index.php?action=login");
            exit;
        }

        $this->model->markAllAsRead($_SESSION['user_id']);
        header("Location: /index.php?action=notifications");
        exit;
    }
}
