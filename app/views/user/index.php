<?php include '../app/views/layouts/header.php'; ?>

<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary">Liste des utilisateurs</h2>
    <a href="?controller=user&action=create" class="btn btn-success">+ Ajouter un utilisateur</a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-bordered align-middle">
      <thead class="table-primary">
        <tr>
          <th scope="col">Nom</th>
          <th scope="col">Email</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $u): ?>
          <tr>
            <td><?= htmlspecialchars($u['nom']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include '../app/views/layouts/footer.php'; ?>
