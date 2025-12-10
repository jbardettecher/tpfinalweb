<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR . 'UserModel.php';

class UserController
{

  private $userModel;
  public function __construct()
  {
    $userModel = new UserModel();
    $this->userModel = $userModel;
  }

  function inscription()
  {
    require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'register.php');
  }

  function enregistrer()
  {
    // Use 'nom' and 'email' only
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $passwordRaw = isset($_POST['password']) ? $_POST['password'] : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    if ($nom === '' || $passwordRaw === '' || $email === '') {
      echo "Tous les champs (nom, email, mot de passe) sont requis.";
      return;
    }

    $password = password_hash($passwordRaw, PASSWORD_DEFAULT);

    if (isset($_GET['id'])) {
      $ajoutOk = $this->userModel->update($_GET['id'], $nom, $password, $email);
    } else {
      $ajoutOk = $this->userModel->add($nom, $password, $email, date('Y-m-d H:i:s'));
    }
    if ($ajoutOk) {
      header('Location: ?c=user&a=connexion');
      exit();
    } else {
      echo "Erreur lors de l'enregistrement de l'utilisateur.";
    }
  }

  function connexion()
  {
    require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'login.php');
  }

  function verifieConnexion()
  {
    // Accept login by 'nom' or by 'email'
    $loginInput = '';
    if (isset($_POST['nom'])) {
      $loginInput = trim($_POST['nom']);
    } elseif (isset($_POST['email'])) {
      $loginInput = trim($_POST['email']);
    }

    $pwd = null;
    if (isset($_POST['password'])) {
      $pwd = $_POST['password'];
    } elseif (isset($_POST['pwd'])) {
      $pwd = $_POST['pwd'];
    }

    if ($loginInput === '' || $pwd === null) {
      echo "Nom/email ou mot de passe manquant.";
      return;
    }

    // If the login contains an @, treat it as an email
    if (strpos($loginInput, '@') !== false) {
      $user = $this->userModel->findBy(['email' => $loginInput]);
    } else {
      $user = $this->userModel->findBy(['nom' => $loginInput]);
    }

    if ($user && password_verify($pwd, $user[0]['password'])) {
      $_SESSION['id'] = $user[0]['id'];
      $_SESSION['nom'] = $user[0]['nom'];
      $_SESSION['email'] = $user[0]['email'];
      $_SESSION['isAdmin'] = isset($user[0]['isAdmin']) ? $user[0]['isAdmin'] : 0;
      header('Location: ?c=home');
      exit();
    } else {
      echo "Nom/email ou mot de passe incorrect.";
    }
  }

  function deconnexion()
  {
    session_unset();
    session_destroy();
    header('Location: ?c=home');
    exit();
  }

  function profil()
  {
    if (!isset($_SESSION['id'])) {
      header('Location: ?c=user&a=connexion');
      exit();
    }
    $user = $this->userModel->find($_SESSION['id']);
    require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'profile.php');
  }
}
