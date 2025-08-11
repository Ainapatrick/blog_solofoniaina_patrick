<?php
class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function index() {
        $users = $this->userModel->getAll();
        include __DIR__ . '/../views/user/index.php';
    }

    public function create() {
        include __DIR__ . '/../views/user/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $this->userModel->create($nom, $email, $password);
            header('Location: index.php?controller=user&action=index');
            exit;
        }
    }
}
