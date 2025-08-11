<?php include '../app/views/layouts/header.php'; ?>

<div class="container py-5">
  <h2>✏️ Modifier l’article</h2>
  <form method="POST" action="index.php?controller=article&action=update&id=<?= $article['id'] ?>" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="titre" class="form-label">Titre</label>
      <input type="text" class="form-control" name="titre" id="titre" value="<?= htmlspecialchars($article['titre']) ?>" required>
    </div>
    <div class="mb-3">
      <label for="contenu" class="form-label">Contenu</label>
      <textarea class="form-control" name="contenu" id="contenu" rows="5" required><?= htmlspecialchars($article['contenu']) ?></textarea>
    </div>
    <div class="mb-3">
      <label for="image" class="form-label">Image (laisser vide si inchangé)</label>
      <input type="file" class="form-control" name="image" id="image">
      <?php if (!empty($article['image'])): ?>
        <div class="mt-2">
          <img src="/<?= htmlspecialchars($article['image']) ?>" alt="Image actuelle" style="height: 150px; object-fit: cover;">
        </div>
      <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
    <a href="index.php?controller=article&action=index" class="btn btn-secondary">← Retour</a>
  </form>
</div>

<?php include '../app/views/layouts/footer.php'; ?>
