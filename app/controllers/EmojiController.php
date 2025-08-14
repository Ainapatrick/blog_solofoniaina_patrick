<?php
class EmojiController
{

    private $emojiModel;

    public function __construct()
    {
        $this->emojiModel = new Emoji();
        session_start();
    }

    // création de nouveau emoji ou echangement
    public function store()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            $articleId = $data['article_id'] ?? null;
            $emoji = $data['code'] ?? null;
            $user = $_SESSION['user'] ?? null;

            if (!$articleId || !$emoji) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid data']);
                return;
            }
            $existing = $this->emojiModel->findByArticleUserAndCode($articleId, $user['id']);
            if ($existing) {
                //update emoji
                $this->emojiModel->update($articleId, $user['id'], $emoji);
            }else{
                // enregistrer emoji
                $this->emojiModel->store($articleId, $user['id'], $emoji);
            }
            $emojiCounts = $this->emojiModel->countAllEmojisByArticle($articleId);

            http_response_code(200);
            echo json_encode([
                'status' => 'ok',
                'success' => true,
                'article_id' => $articleId,
                'nom_user' => $user["name"],
                'emoji' => $emoji,
                'count' =>$emojiCounts['emojiCount']
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur interne', 'message' => $e->getMessage()]);
        }
    }
}
