<?php include '../app/views/layouts/header.php'; ?>

<section class="py-5 bg-light">
  <div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3 sticky-top bg-light py-2" style="z-index: 1020;">
      <a href="index.php?controller=article&action=index" class="btn btn-secondary">← Retour</a>
      
      <p><small class="text-muted">👤 Auteur: <?= htmlspecialchars($article['user_id']) ?></small></p>
    </div>
    
    <h2 class="m-0"><?= htmlspecialchars($article['titre']) ?></h2>
    <img src="<?= htmlspecialchars($article['image']) ?>" class="img-fluid mb-3" alt="Image de l'article">
    <p><?= nl2br(htmlspecialchars($article['contenu'])) ?></p>

  </div>
</section>


<?php include '../app/views/layouts/footer.php'; ?>
