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
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm w-100">
                            <img src="/uploads/articles/<?= htmlspecialchars(basename($u['image'])) ?>"
                                class="card-img-top w-100 img-fluid"
                                alt="Image de l'article"
                                style="height: 200px; object-fit: cover;">

                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title"><?= htmlspecialchars($u['titre']) ?></h5>
                                    <p class="card-text">
                                        <?= strlen($u['contenu']) > 100
                                            ? substr(htmlspecialchars($u['contenu']), 0, 200) . '... 
                                            <a href="index.php?controller=article&action=show&id=' . $u['id'] . '">Voir plus</a>'
                                            : htmlspecialchars($u['contenu']) ?>
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center small text-muted mt-2">
                                    <p>
                                        <span id="emoji-count-<?= $u['id'] ?>">
                                            <?php if ($dernierLike = $this->likeModel->getDernierLike($u['id'])): ?>
                                                <?= htmlspecialchars($dernierLike['code']) ?>
                                            <?php else: ?>

                                            <?php endif; ?>
                                        </span>
                                        <span id="like-code-<?= $u['id'] ?>">
                                            <?php if ($dernierLike = $this->likeModel->getDernierLike($u['id'])): ?>
                                                👍
                                            <?php else: ?>

                                            <?php endif; ?>
                                        </span>
                                        <span id="user-code-<?= $u['id'] ?>">
                                            <?php if ($dernierLike = $this->likeModel->getDernierLike($u['id'])): ?>
                                                <?= htmlspecialchars($dernierLike['nom']) ?>
                                            <?php else: ?>
                                                Aucun réaction
                                            <?php endif; ?>
                                        </span>et
                                        <span id="total-emojilike-code-<?= $u['id'] ?>">
                                            <?= $emojiCountsByArticle[$u['id']] ?? 0 ?>
                                        </span>réaction -
                                        <span id="comment-code-<?= $u['id'] ?>"><?= $u['comments_count'] ?? 0 ?></span><span> comm...</span>
                                    </p>

                                </div>

                                <!-- Liste commentaire -->
                                <?php if (!empty($u['comments_count']) && $u['comments_count'] > 0): ?>
                                    <div id="comments-list-<?= $u['id'] ?>"></div>
                                <?php endif; ?>


                                <div class="mt-1 d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-primary btn-sm voir-comment"
                                        data-article-id="<?= $u['id'] ?>"><span id="comment-count-<?= $u['id'] ?>">💬 <?= $u['comments_count'] ?? 0 ?> Voir</span></button>
                                    <?php
                                    $userLiked = isset($_SESSION['user']) && $likesModel->userLikes($user['id'], $u['id']);
                                    ?>
                                    <?php if (!$userLiked) : ?>
                                        <button type="button"
                                            class="btn btn-outline-secondary btn-sm like-btn text-secondary"
                                            data-article-id="<?= $u['id'] ?>"
                                            data-action="store">
                                            👍<span id="likes-count-<?= $u['id'] ?>"><?= $u['likes_count'] ?? 0 ?></span>

                                        </button>
                                    <?php else: ?>
                                        <button type="button"
                                            class="btn btn-outline-success btn-sm like-btn"
                                            data-article-id="<?= $u['id'] ?>"
                                            data-action="delete">
                                            👍 <span id="likes-count-<?= $u['id'] ?>"> <?= $u['likes_count'] ?? 0 ?></span>

                                        </button>
                                    <?php endif; ?>
                                    <div class="position-relative">
                                        <?php
                                        $userEmoji = $emojiModel->UnEmojiParUser($u['id'], $user['id']);
                                        ?>
                                        <button type="button"
                                            class="btn btn-outline-danger btn-sm"
                                            id="emojiBtn-<?= $u['id'] ?>"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Cliquez pour choisir un emoji">
                                            <?= $userEmoji['code'] ?? "😀" ?>
                                        </button>

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

                                    <div class="position-relative">
                                        <?php if ($user && $user['id'] == $u['user_id']): ?>
                                            <button type="button" class="btn btn-outline-success btn-sm" id="param-<?= $u['id'] ?>">⚙️ paramètre</button>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-outline-success btn-sm" id="param-<?= $u['id'] ?>">💬 Commenter</button>
                                        <?php endif; ?>

                                        <div class="card shadow position-absolute border-4"
                                            id="btnSM-<?= $u['id'] ?>"
                                            style="display:none; bottom: 110%; right: 0; width: 330px; z-index: 1000;">

                                            <!-- Header with Close Icon -->
                                            <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                                <strong>Actions</strong>
                                                <button type="button" class="btn-close" aria-label="Close" data-close-popup="<?= $u['id'] ?>"></button>
                                            </div>
                                            <div class="card-body bg-white">
                                                <?php if ($user && $user['id'] == $u['user_id']): ?>
                                                    <div class="mb-3 d-flex justify-content-center">
                                                        <a href="index.php?controller=article&action=edit&id=<?= $u['id'] ?>" class="btn btn-outline-warning btn-sm text-dark me-3">✏️ Modifier</a>
                                                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-<?= $u['id'] ?>">🗑️ Supprimer</button>
                                                    </div>
                                                <?php endif; ?>
                                                <!-- Comment Form -->
                                                <form class="comment-form" data-article-id="<?= $u['id'] ?>">
                                                    <input type="hidden" name="article_id" value="<?= $u['id'] ?>">
                                                    <div class="form-group">
                                                        <textarea name="comment" style="border:2px solid #ccc;" rows="3" class="form-control mb-2" placeholder="Votre commentaire..." required></textarea>
                                                        <button type="submit" class="btn btn-primary btn-sm w-100">💬 Commenter</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Commentaire -->
                    <div class="modal fade" id="modalComments-<?= $u['id'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Commentaires</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body" id="modal-comments-body-<?= $u['id'] ?>">
                                    Chargement...
                                </div>
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