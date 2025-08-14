<?php
class LikesController {
    private $likesModel;
    private $emojiModel;

    public function __construct() {
        $this->likesModel = new Likes();
        $this->emojiModel = new Emoji();
        session_start();
    }

    // quand un user aimer l'article
    public function store() {
        header('Content-Type: application/json');
        if (!isset($_SESSION['user'])) {
            echo json_encode(['error' => 'Vous devez être connecté']);
            exit;
        }
        $userId = $_SESSION['user']['id'];
        $articleId = $_POST['article_id'] ?? null;

        if ($articleId) {
            if (!$this->likesModel->userLikes($userId, $articleId)) {
                $this->likesModel->create([
                    'user_id' => $userId,
                    'article_id' => $articleId
                ]);
            }
        }
        //likes cont total
        $count = $this->likesModel->countByArticle($articleId);

        echo json_encode([
            'article_id' => $articleId,
            'likes_count' => $count,
            'liked' => true,
            'user_nom' => $_SESSION['user']['name']
        ]);
        exit;
    }

    // quand l'utilisateur unlike l'aricle
    public function delete() {
        header('Content-Type: application/json');
        $userId = $_SESSION['user']['id'];
        $articleId = $_POST['article_id'] ?? null;

        if ($articleId) {
            $this->likesModel->delete($userId, $articleId);
        }
        $user_nom = "";
        $exist = $this->emojiModel->findByArticleUserAndCode($articleId, $userId);
        if ($exist) {
            $user_nom = $_SESSION['user']['name'];
        }else {
            $user_nom = "";
        }
        $count = $this->likesModel->countByArticle($articleId);

        echo json_encode([
            'article_id' => $articleId,
            'likes_count' => $count,
            'liked' => false,
            'user_nom' => $user_nom
        ]);
        exit;
    }
}