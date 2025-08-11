<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #3b82f6, #8b5cf6);
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: Arial, sans-serif;
    }

    .auth-container {
      background: #ffffff;
      padding: 2rem;
      border-radius: 15px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .auth-container h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #4f46e5;
    }

    .auth-container .form-control {
      border-radius: 10px;
    }

    .auth-container button {
      width: 100%;
      border-radius: 10px;
    }

    .auth-container p {
      text-align: center;
      margin-top: 1rem;
    }

    .auth-container a {
      color: #3b82f6;
      text-decoration: none;
    }

    .auth-container a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="auth-container">
    <h2>Se connecter</h2>
    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="index.php?controller=auth&action=handleLogin">
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Mot de passe</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Connexion</button>
    </form>
    <p>Pas encore inscrit ? <a href="index.php?controller=auth&action=register">Créer un compte</a></p>
  </div>
</body>

</html>