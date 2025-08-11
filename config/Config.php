<?php

class Config
{
    private $host = "localhost";
    private $dbname = "blog_patrick";
    private $user = "debian-sys-maint";
    private $mdp = "NouveauMotDePasse";
    private $pdo;
    private $charset = 'utf8mb4';

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=".$this->charset, $this->user, $this->mdp);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}
