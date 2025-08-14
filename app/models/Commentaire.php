<?php
class Commentaire
{
    private $pdo;

    public function __construct()
    {
        $db = new Config();
        $this->pdo = $db->getConnection();
    }

    //creation de nouveau commentaire
    public function create($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO commentaires (article_id, user_id,contenu) VALUES (?, ?, ?)");
        $stmt->execute([$data['article_id'], $data['user_id'], $data['contenu']]);
    }

    public function getByArticle($articleId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM commentaires c INNER JOIN users u ON u.id =c.user_id WHERE c.article_id = $articleId" );
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get dernier commentaire dans un article
    public function getDernierCommArticle($userId, $articleId)
    {
        $stmt = $this->pdo->prepare("
            SELECT c.*, u.nom 
            FROM commentaires c
            JOIN users u ON u.id = c.user_id
            WHERE c.article_id = ?
            ORDER BY c.created_at DESC
            LIMIT 1
        ");
        $stmt->execute([$articleId]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    // get compte commentaire dans un article
    public function countComment($articleId)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM commentaires WHERE article_id = ?");
        $stmt->execute([$articleId]);
        return (int)$stmt->fetchColumn();
    }

    // suppression de commentaire dans un article
    public function delete($userId, $articleId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM commentaires WHERE user_id = ? AND article_id = ?");
        $stmt->execute([$userId, $articleId]);
    }
}
