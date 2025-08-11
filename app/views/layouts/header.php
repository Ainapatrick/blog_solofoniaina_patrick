<?php
session_start();
$user = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Mon Blog</title>
  <link rel="stylesheet" href="/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="#">MonBlog</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php //var_dump($user); die; ?>
          <?php if ($user): ?>
            <li class="nav-item"><a class="nav-link" href="index.php?controller=article&action=index">Articles</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?controller=categorie&action=index">Catégories</a></li>
            <?php if ($user['role'] === 'admin'): ?>
              <li class="nav-item"><a class="nav-link" href="index.php?controller=user&action=index">Users</a></li>
            <?php endif; ?>
          <?php endif; ?>
        </ul>

        <div class="d-flex align-items-center">
          <?php if (!$user): ?>
            <a class="btn btn-outline-light me-2" href="index.php?controller=auth&action=login">Login</a>
            <a class="btn btn-light" href="index.php?controller=auth&action=register">Register</a>
          <?php else: ?>
            <div class="dropdown">
              <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="../images/coco2.jpg" alt="profile" width="32" height="32" class="rounded-circle me-2">
                <strong class="text-red"><?= htmlspecialchars($user['nom']) ?></strong>
              </a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser">
                <li><a class="dropdown-item" href="#">Paramètres</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="index.php?controller=auth&action=logout">Se déconnecter</a></li>
              </ul>
            </div>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </nav>