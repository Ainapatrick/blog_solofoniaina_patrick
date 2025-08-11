<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #4f46e5, #3b82f6);
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: Arial, sans-serif;
    }

    .register-card {
      background: white;
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      width: 100%;
      max-width: 400px;
      animation: fadeIn 0.6s ease-in-out;
    }

    .register-card h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      font-weight: bold;
      color: #4f46e5;
    }

    .form-control {
      border-radius: 10px;
    }

    .btn-custom {
      background: linear-gradient(90deg, #4f46e5, #3b82f6);
      border: none;
      color: white;
      border-radius: 10px;
      padding: 0.6rem;
      font-weight: bold;
      transition: 0.3s;
    }

    .btn-custom:hover {
      background: linear-gradient(90deg, #3b82f6, #4f46e5);
      transform: scale(1.02);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="register-card">
    <h2>Register</h2>
    <form method="POST" action="index.php?controller=auth&action=storeRegister">
      <div class="mb-3">
        <label class="form-label">Nom</label>
        <input type="text" name="nom" class="form-control" placeholder="Votre nom" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="exemple@mail.com" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Mot de passe</label>
        <input type="password" name="password" class="form-control" placeholder="********" required>
      </div>
      <button type="submit" class="btn btn-custom w-100">S'inscrire</button>
    </form>
    <p>vous êtes inscrit ? <a href="index.php?controller=auth&action=login">se connecter</a></p>
  </div>
</body>
</html>
