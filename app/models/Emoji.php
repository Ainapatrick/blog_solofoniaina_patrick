<?php
class Emoji
{
    private $pdo;

    public function __construct()
    {
        $db = new Config();
        $this->pdo = $db->getConnection();
    }
    
    // store le nouveau emoji
    public function store($articleId, $userId, $emojiCode)
    {
        $stmt = $this->pdo->prepare("INSERT INTO emojis (article_id, user_id, code) VALUES (?, ?, ?)");
        $stmt->execute([$articleId, $userId, $emojiCode]);
    }

    //find emoji si il est existe dans le base par article et user
    public function findByArticleUserAndCode($articleId, $userId)
    {
        $sql = "SELECT * FROM emojis WHERE article_id = :article_id AND user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':article_id' => $articleId,
            ':user_id' => $userId,
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //compter le total de tous les emoji enregistées par article
    public function countAllEmojisByArticle($articleId)
    {
        $sql = "SELECT COUNT(*) as emojiCount FROM emojis WHERE article_id = :article_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':article_id' => $articleId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //mise àjour si il est existe
    public function update($articleId, $userId, $emojiCode)
    {
        $stmt = $this->pdo->prepare("UPDATE emojis SET article_id = :article_id, user_id =:user_id, code=:code  WHERE user_id = :user_id AND article_id = :article_id");
        $stmt->bindValue(':article_id', $articleId);
        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':code', $emojiCode);
        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':article_id', $articleId);
        $stmt->execute();
    }
}
