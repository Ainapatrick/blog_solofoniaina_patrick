<?php include '../app/views/layouts/header.php'; ?>

<div class="container mt-5">
  <div class="row justify-content-center bg-grey">
    <div class="col-md-8">
      <h2 class="mb-4 text-center text-primary">📝 Créer un nouvel article</h2>

      <form method="POST" action="?controller=article&action=store" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">

        <div class="mb-3">
          <label for="titre" class="form-label">Titre</label>
          <input type="text" class="form-control" id="titre" name="titre" required>
        </div>

        <div class="mb-3">
          <label for="contenu" class="form-label">Contenu</label>
          <textarea class="form-control" id="contenu" name="contenu" rows="6" required></textarea>
        </div>

        <div class="mb-3">
          <label for="image" class="form-label">Image (jpg, png, webp...)</label>
          <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-primary">✅ Enregistrer</button>
        </div>

      </form>
    </div>
  </div>
</div>

<?php include '../app/views/layouts/footer.php'; ?>
