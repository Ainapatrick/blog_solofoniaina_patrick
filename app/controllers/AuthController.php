<?php
class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
        session_start();
    }

    public function login() {
        include __DIR__ . '/../views/auth/login.php';
    }

    public function register() {
        include __DIR__ . '/../views/auth/register.php';
    }

    public function storeRegister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $this->userModel->create($nom, $email, $password);
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
    }

    public function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->findByEmail($email);
            //var_dump(password_verify($password, $user['password']));
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'name' => $user['nom'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                ];
                $_SESSION['success'] = "Article bien enregistré.";
                header("Location: index.php?controller=article&action=index");
                exit;
            } else {
                $error = "Email ou mot de passe incorrect";
                include __DIR__ . '/../views/auth/login.php';
            }
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php");
        exit;
    }
}
