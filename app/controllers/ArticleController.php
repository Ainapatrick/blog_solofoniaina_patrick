<?php
class ArticleController
{
    private $articleModel;
    private $likeModel;
    private $emojiCounts;

    public function __construct()
    {
        $this->articleModel = new Article();
        $this->likeModel = new Likes();
        $this->emojiCounts = new Emoji();
        session_start();
    }

    // affichage aritcle et leurs reactions
    public function index()
    {
        session_start();
        $user = $_SESSION['user'] ?? null;
        $articles = $this->articleModel->getAll();
        $likesModel = $this->likeModel;
        $emojiCountsByArticle = [];
        //total likes + emojis
        $emojiLikeTotals = $this->likeModel->countEmojiAndLikeByArticle();

        // transformer associative array: [article_id => total]
        $emojiCountsByArticle = [];
        foreach ($emojiLikeTotals as $row) {
            $emojiCountsByArticle[$row['article_id']] = (int)$row['total'];
        }
        include __DIR__ . '/../views/article/index.php';
    }

    public function create()
    {
        include __DIR__ . '/../views/article/create.php';
    }

    public function store()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: ?controller=auth&action=login');
            exit;
        }
        // Récupération
        $titre = trim($_POST['titre']);
        $contenu = trim($_POST['contenu']);
        $user_id = $_SESSION['user']['id'];

        // Gestion de l'image
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $imageTmp = $_FILES['image']['tmp_name'];
            $imageName = time() . '_' . basename($_FILES['image']['name']);
            $uploadDir = __DIR__ . '/../../public/uploads/articles/';
            $uploadPath = $uploadDir . $imageName;
            // Déplacement
            if (!move_uploaded_file($imageTmp, $uploadPath)) {
                die('Erreur lors de l’upload de l’image.');
            }
        } else {
            die('Aucune image envoyée ou erreur.');
        }

        $article = new Article();
        $article->create([
            "titre" => $titre,
            'contenu' => $contenu,
            'image' => $uploadPath,
            'user_id' => $user_id,
        ]);

        header('Location: ?controller=article&action=index');
        exit;
    }


    public function show()
    {
        $id = $_GET['id'];
        $article = $this->articleModel->find($id);
        require '../app/views/article/show.php';
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            die("ID non trouvable.");
        }
        $article = $this->articleModel->find($id);
        if (!$article) {
            die("Article non trouvable.");
        }
        require '../app/views/article/edit.php';
    }

    public function update()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            die("ID d'article non trouvable");
        }

        $titre = $_POST['titre'] ?? '';
        $contenu = $_POST['contenu'] ?? '';
        $image = $_FILES['image'] ?? null;

        $article = $this->articleModel->find($id);
        $imagePath = $article['image'];

        if ($image && $image['error'] === 0) {
            $imageName = time() . '_' . basename($image['name']);
            $uploadPath = __DIR__ . '/../../public/uploads/articles/' . $imageName;

            if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
                $imagePath = '/uploads/articles/' . $imageName;
                $imagePathActuel = __DIR__ . '/../../public/' . $article['image'];
                //suppression de fichier actuel
                if (file_exists($imagePathActuel)) {
                    unlink($imagePathActuel);
                }
            }
        }

        $this->articleModel->update($id, [
            'titre' => $titre,
            'contenu' => $contenu,
            'image' => $imagePath ?? null,
        ]);

        header("Location: index.php?controller=article&action=index");
        exit;
    }

    //suppression d'un article
    public function delete()
    {
        $id = $_GET['id'];
        $article = $this->articleModel->delete($id);

        header("Location: index.php?controller=article&action=index");
        exit;
    }
}
