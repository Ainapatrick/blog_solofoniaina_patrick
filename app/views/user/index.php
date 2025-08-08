<h1>Liste des utilisateurs</h1>
<a href="?controller=user&action=create">Ajouter un utilisateur</a>
<table class="">
    <tr><th>Nom</th><th>Email</th></tr>
    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= htmlspecialchars($u['nom']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
