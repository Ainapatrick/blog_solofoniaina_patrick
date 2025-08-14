<?php
class Article
{
    private $pdo;

    public function __construct()
    {
        $db = new Config();
        $this->pdo = $db->getConnection();
    }

    public function getAll()
    {
        $sql = "
            SELECT 
                a.*,
                    (SELECT COUNT(*) 
                    FROM likes l 
                    WHERE l.article_id = a.id) AS likes_count,
                    
                    (SELECT COUNT(*) 
                    FROM commentaires c 
                    WHERE c.article_id = a.id) AS comments_count
                FROM articles a
                ORDER BY a.created_at DESC
            ";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO articles (titre, contenu, image, user_id) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['titre'],
            $data['contenu'],
            $data['image'],
            $data['user_id']
        ]);
    }

    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE articles SET titre = :titre, contenu = :contenu";
        if (!empty($data['image'])) {
            $sql .= ", image = :image";
        }
        $sql .= " WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':titre', $data['titre']);
        $stmt->bindValue(':contenu', $data['contenu']);
        if (!empty($data['image'])) {
            $stmt->bindValue(':image', $data['image']);
        }
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("SELECT image FROM articles WHERE id = ?");
        $stmt->execute([$id]);
        $imgarticle = $stmt->fetch();

        if ($imgarticle && !empty($imgarticle['image'])) {
            $imagePath = __DIR__ . '/../../public/' . $imgarticle['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $stmt = $this->pdo->prepare("DELETE FROM articles WHERE id = ?");
        $stmt->execute([$id]);
    }
}
