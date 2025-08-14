<?php
class Likes
{
    private $pdo;

    public function __construct()
    {
        $db = new Config();
        $this->pdo = $db->getConnection();
    }

    // enregistrer le j'aime par user connecté
    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT IGNORE INTO likes (user_id, article_id) VALUES (?, ?)");
        $stmt->execute([$data['user_id'], $data['article_id']]);
    }

    // supprimer le j'aime par user connecté
    public function delete($userId, $articleId) {
        $stmt = $this->pdo->prepare("DELETE FROM likes WHERE user_id = ? AND article_id = ?");
        $stmt->execute([$userId, $articleId]);
    }

    public function userLikes($userId, $articleId) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM likes WHERE user_id = ? AND article_id = ?");
        $stmt->execute([$userId, $articleId]);
        return $stmt->fetchColumn() > 0;
    }

    public function countByArticle($articleId) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM likes WHERE article_id = ?");
        $stmt->execute([$articleId]);
        return (int)$stmt->fetchColumn();
    }

    public function countEmojiAndLikeByArticle() {
        $sql = "
            SELECT 
                a.id AS article_id,
                COUNT(DISTINCT l.id) + COUNT(DISTINCT e.id) AS total
            FROM articles a
            LEFT JOIN likes l ON a.id = l.article_id
            LEFT JOIN emojis e ON a.id = e.article_id
            GROUP BY a.id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDernierLike($articleId)
    {
        $stmt = $this->pdo->prepare("
            SELECT l.*, u.nom, e.code FROM likes l
            JOIN users u ON l.user_id = u.id
            JOIN emojis e ON l.article_id = e.article_id
            WHERE l.article_id = ?
            ORDER BY l.created_at DESC
            LIMIT 1
        ");
        $stmt->execute([$articleId]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }


}