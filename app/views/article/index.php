<?php include '../app/views/layouts/header.php'; ?>
<section class="py-5 bg-dark text-white text-center">
    <div class="container">
        <h2 class="display-5">📝 Liste des Articles</h2>
        <p class="lead">Découvrez les articles publiés par toutes les utilisateurs</p>

        <?php if ($user): ?>
            <a href="index.php?controller=article&action=create" class="btn btn-outline-light mt-3">
                ➕ Créer un article
            </a>
        <?php endif; ?>
    </div>
</section>


<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <?php if (isset($user)): ?>
                <?php foreach ($articles as $u): ?>
                    <?php
                    //var_dump($user); 
                    //var_dump($likesModel);
                    ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm w-100">
                            <img src="/uploads/articles/<?= htmlspecialchars(basename($u['image'])) ?>"
                                class="card-img-top w-100 img-fluid"
                                alt="Image de l'article"
                                style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <h5 class="card-title"><?= htmlspecialchars($u['titre']) ?></h5>
                                <p class="card-text">
                                    <?= strlen($u['contenu']) > 100
                                        ? substr(htmlspecialchars($u['contenu']), 0, 200) . '... 
                                    <a href="index.php?controller=article&action=show&id=' . $u['id'] . '">Voir plus</a>'
                                        : htmlspecialchars($u['contenu']) ?>
                                </p>

                                <div class="d-flex justify-content-between align-items-center small text-muted mt-2">
                                    <span>
                                        <?= $u['comments_count'] ?? 0 ?>
                                        <a href="index.php?controller=article&action=comments&id=<?= $u['id'] ?>" class="btn btn-link btn-sm p-0">💬 voir</a>
                                        
                                    </span>
                                    <span>👍 <?= $u['likes_count'] ?? 0 ?></span>
                                    <div class="emojis">
                                        <?php
                                        $emojis = $emojiCountsByArticle[$u['id']] ?? [];
                                        foreach ($emojis as $e): ?>
                                            <span><?= $e['code'] === '❤️' ? '❤️' : htmlspecialchars($e['code']) ?> <?= $e['count'] ?></span>
                                        <?php endforeach; ?>

                                    </div>


                                </div>


                                <div class="mt-2 d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#commentModal-<?= $u['id'] ?>">
                                        💬 Commentaire
                                    </button>


                                    <?php if (!$likesModel->hasLiked($user['id'], $u['id'])): ?>
                                        <a href="index.php?controller=likes&action=store&id=<?= $u['id'] ?>" class="btn btn-outline-success btn-sm">👍 j'aime</a>
                                    <?php else: ?>
                                        <a href="index.php?controller=likes&action=delete&id=<?= $u['id'] ?>" class="btn btn-outline-danger btn-sm">👎 n'aime</a>
                                    <?php endif; ?>
                                    <div class="position-relative">
                                        <button type="button" class="btn btn-outline-danger btn-sm" id="emojiBtn-<?= $u['id'] ?>">
                                            ❤️ Emojis
                                        </button>

                                        <!-- Emoji -->
                                        <div class="emoji-picker border bg-white shadow rounded p-2 position-absolute"
                                            id="emojiPicker-<?= $u['id'] ?>"
                                            style="display:none; bottom: 100%; right: 0; width: 200px; z-index: 1000;">
                                            <button class="emoji-btn btn btn-light btn-sm m-1" data-emoji="😀">😀</button>
                                            <button class="emoji-btn btn btn-light btn-sm m-1" data-emoji="😂">😂</button>
                                            <button class="emoji-btn btn btn-light btn-sm m-1" data-emoji="😍">😍</button>
                                            <button class="emoji-btn btn btn-light btn-sm m-1" data-emoji="😢">😢</button>
                                            <button class="emoji-btn btn btn-light btn-sm m-1" data-emoji="😡">😡</button>
                                            <button class="emoji-btn btn btn-light btn-sm m-1" data-emoji="🥰">🥰</button>
                                            <button class="emoji-btn btn btn-light btn-sm m-1" data-emoji="☠️">☠️</button>
                                            <button class="emoji-btn btn btn-light btn-sm m-1" data-emoji="👹">👹</button>
                                            <button class="emoji-btn btn btn-light btn-sm m-1" data-emoji="🎑">🎑</button>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($user && $user['id'] == $u['user_id']): ?>
                                    <div class="mt-3 d-flex justify-content-around">
                                        <a href="index.php?controller=article&action=edit&id=<?= $u['id'] ?>" class="btn btn-warning btn-sm">✏️ Modifier</a>

                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-<?= $u['id'] ?>">
                                            🗑️ Supprimer
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Commentaire -->
                    <div class="modal fade" id="commentModal-<?= $u['id'] ?>" tabindex="-1" aria-labelledby="commentModalLabel-<?= $u['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="index.php?controller=comment&action=store" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="commentModalLabel-<?= $u['id'] ?>">Écrire un commentaire</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="article_id" value="<?= $u['id'] ?>">
                                        <textarea name="contenu" rows="4" class="form-control" placeholder="Votre commentaire..." required></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-primary">Envoyer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Supprimer -->
                    <div class="modal fade" id="deleteModal-<?= $u['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel-<?= $u['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="index.php?controller=article&action=delete&id=<?= $u['id'] ?>" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel-<?= $u['id'] ?>">Confirmer la suppression</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                    </div>
                                    <div class="modal-body">
                                        Voulez-vous vraiment supprimer l’article <strong><?= htmlspecialchars($u['titre']) ?></strong> ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php include '../app/views/layouts/footer.php'; ?>