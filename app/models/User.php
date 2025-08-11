<?php
class User
{
    private $pdo;

    public function __construct()
    {
        $db = new Config();
        $this->pdo = $db->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($nom, $email, $password)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (nom, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$nom, $email, $password]);
    }


    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
