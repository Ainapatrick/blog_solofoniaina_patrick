<?php include '../app/views/layouts/header.php'; ?>

<section class="hero-image d-flex align-items-center justify-content-center text-center text-white">
  <div class="overlay"></div>
  <div class="content">
    <h1 class="display-4">Bienvenue sur notre site</h1>
    <p class="lead">Un site de réservation moderne avec PHP (MVC) & Bootstrap</p>
    <a href="?controller=auth&action=register" class="btn btn-primary btn-lg mt-3">Créer un compte</a>
  </div>
</section>

<section class="px-5 py-5 bg-light">
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <img src="../images/coco.jpeg" class="card-img-top" alt="Interface intuitive">
        <div class="card-body text-center">
          <h5 class="card-title">Interface Intuitive</h5>
          <p class="card-text">Une interface simple et moderne pour une navigation fluide dans l’application.</p>
          <a href="#" class="btn btn-outline-primary">Découvrir</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <img src="../images/coco2.jpg" class="card-img-top" alt="Interface intuitive">
        <div class="card-body text-center">
          <h5 class="card-title">Gestion Efficace</h5>
          <p class="card-text">Gérez vos données en toute simplicité grâce à notre système performant.</p>
          <a href="#" class="btn btn-outline-success">Voir plus</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <img src="../images/coco1.jpg" class="card-img-top" alt="Interface intuitive">
        <div class="card-body text-center">
          <h5 class="card-title">Support 24/7</h5>
          <p class="card-text">Notre équipe vous accompagne à tout moment pour assurer votre satisfaction.</p>
          <a href="#" class="btn btn-outline-danger">Contactez-nous</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include '../app/views/layouts/footer.php'; ?>