<?php
class CommentController
{
    private $commentModel;

    public function __construct()
    {
        $this->commentModel = new Commentaire();
        session_start();
    }

    // enregistrement de commentaire
    public function store()
    {
        if (!isset($_SESSION['user'])) {
            http_response_code(403);
            echo json_encode(['error' => 'Not logged in']);
            exit;
        }
        $userId = $_SESSION['user']['id'];
        $articleId = $_POST['article_id'] ?? null;
        $comment = trim($_POST["comment"] ?? '');

        if (!$articleId || !$comment) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid data']);
            exit;
        }

        // Sauvegarde le nouveau commentaire
        $this->commentModel->create([
            'user_id' => $userId,
            'article_id' => $articleId,
            'contenu' => $comment
        ]);

        $comments = $this->commentModel->getDernierArticle($userId, $articleId);
        $countComment = $this->commentModel->countComment($articleId);

        echo json_encode([
            'article_id'  => $comments["article_id"],
            'user'        => htmlspecialchars($_SESSION['user']['nom']),
            'comment'     => htmlspecialchars($comments['contenu']),
            'created_at'  => $comments["created_at"],
            'comment_count' => $countComment,
            'nom_user' => $_SESSION['user']['name']
        ]);
        exit;
    }

    // affichage de liste commentaire par article
    public function listByArticle()
    {
        $articleId = $_GET['id'] ?? null;
        if (!$articleId) {
            http_response_code(400);
            echo json_encode(['error' => 'No article ID']);
            exit;
        }

        $comments = $this->commentModel->getByArticle($articleId);
        echo json_encode($comments);
        exit;
    }

    //suppression de commentaire
    public function delete()
    {
        $userId = $_SESSION['user']['id'];
        $articleId = $_GET['id'] ?? null;
        if ($articleId) {
            $this->commentModel->delete($userId, $articleId);
        }

        header("Location: index.php?controller=article&action=index");
        exit;
    }
}
