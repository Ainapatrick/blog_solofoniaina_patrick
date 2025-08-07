<?php
class Config {
    public function __construct()
    {
        $host = "localhost";
        $dbname = "blog_patrick";
        $user = "debian-sys-maint";
        $mdp = "NouveauMotDePasse";
    }

    public function connection_db(){
        //$pdo = new PDO("mysql: host="$this->host);
    }
}