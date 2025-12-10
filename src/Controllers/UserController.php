<?php
require_once __DIR__ . '/../Models/UserModel.php';

class UserController {

    private UserModel $model;

    public function __construct() {
        session_start();
        $this->model = new UserModel();
    }

    // ----- Afficher le formulaire d'inscription -----
    public function showRegister() {
        $error = $_GET['error'] ?? null;
        require __DIR__ . '/../Views/user/register.php';
    }

    // ----- Traiter l'inscription -----
    public function register() {
        $nom = trim($_POST['nom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (!$nom || !$email || !$password) {
            $error = "Tous les champs sont obligatoires.";
            require __DIR__ . '/../Views/user/register.php';
            return;
        }

        $result = $this->model->register($nom, $email, $password);

        if ($result === true) {
            header("Location: /index.php?action=login&msg=Compte créé !");
            exit;
        } else {
            $error = $result;
            require __DIR__ . '/../Views/user/register.php';
        }
    }

    // ----- Connexion -----
    public function showLogin() {
        $error = $_GET['error'] ?? null;
        require __DIR__ . '/../Views/user/login.php';
    }

    public function login() {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $user = $this->model->login($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $error = "Email ou mot de passe incorrect.";
            require __DIR__ . '/../Views/user/login.php';
            return;
        }

        // On stocke l'utilisateur en session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nom'];
        $_SESSION['user_email'] = $user['email'];

        header("Location: /index.php?action=home");
        exit;
    }

    // ----- Déconnexion -----
    public function logout() {
        session_destroy();
        header("Location: /index.php?action=login");
        exit;
    }

    // ----- Profil -----
    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /index.php?action=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $email = $_POST['email'];
            $this->model->update($_SESSION['user_id'], $nom, $email);
            $_SESSION['user_name'] = $nom;
            $_SESSION['user_email'] = $email;
            $msg = "Profil mis à jour.";
        }

        $user = $this->model->getById($_SESSION['user_id']);
        require __DIR__ . '/../Views/user/profile.php';
    }
}
