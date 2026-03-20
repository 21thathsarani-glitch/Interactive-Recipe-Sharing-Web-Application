<?php require_once 'includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - SavoryHub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">

  <nav class="navbar navbar-expand-lg custom-navbar sticky-top">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <img src="Images/logo.png" alt="SavoryHub Logo" height="40">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
        style="border-color: transparent;">
        <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link scroll-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link scroll-link active" href="about.php">About Us</a></li>
          <li class="nav-item"><a class="nav-link scroll-link" href="recipes.php">Recipe Details</a></li>
          <li class="nav-item"><a class="nav-link scroll-link" href="submit.php">Add Recipe</a></li>
          <li class="nav-item"><a class="nav-link scroll-link" href="contact.php">Contact Us</a></li>
          <?php if (is_logged_in()): ?>
              <li class="nav-item user-only"><a class="nav-link scroll-link" href="dashboard.php">Dashboard</a></li>
              <li class="nav-item user-only"><a class="nav-link scroll-link" href="auth/logout.php" id="logoutBtn">Logout</a></li>
          <?php else: ?>
              <li class="nav-item guest-only"><a class="nav-link scroll-link" href="auth/login.php">Login</a></li>
              <li class="nav-item guest-only"><a class="nav-link scroll-link" href="auth/register.php">Register</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <section class="container my-5">
    <h1 class="text-center mb-5 text-white" style="font-size: 2.5rem; font-weight: bold;">About Us</h1>

    <div class="row align-items-center mb-5">
      <div class="col-md-6 mb-4 mb-md-0">
        <img src="Images/about.jpg" alt="About SavoryHub" class="img-fluid rounded"
          style="height: 600px; object-fit: cover;">
      </div>
      <div class="col-md-6">
        <h2 class="text-warning mb-3" style="font-size: 1.8rem;">Why Choose Us</h2>
        <p class="lead text-light">A simple and user-friendly recipe web application created for food lovers. Our
          platform is designed to help people discover delicious homemade recipes and share their own cooking ideas with
          others.</p>
        <p class="lead text-light">We believe cooking should be enjoyable and accessible to everyone. Whether you are a
          beginner or an experienced cook, our website provides a place to explore new dishes, learn recipes, and
          contribute your own creations.</p>
        <p class="lead text-light">Our goal is Build a community where people can connect through their
          love of food and cooking.</p>
        <h4 class="text-warning mt-4">Our Mission</h4>
        <p class="lead text-light">To make cooking fun and easy for everyone!</p>
      </div>
    </div>

    <div class="text-center mb-5">
      <h2 class="mb-3 text-white">Testimonials</h2>
      <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner pb-5">
          <div class="carousel-item active">
            <div class="row justify-content-center">
              <div class="col-md-6">
                <div class="card h-100 shadow-sm border text-center p-4 rounded-4"
                  style="border-color: #cfd3d8 !important;">
                  <div class="card-body">
                    <div class="mb-3 d-flex justify-content-center">
                      <img src="Images/t1.jpg" alt="Arun K" class="rounded-circle border border-2 border-secondary"
                        style="width: 60px; height: 60px; object-fit: cover;">
                    </div>
                    <p class="card-text text-light opacity-75 mb-4 fs-5 fst-italic">"I love how simple it is to submit
                      my own recipes. I feels like a small cooking community"</p>
                    <h5 class="card-title mb-0 text-white">Aruni k</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="row justify-content-center">
              <div class="col-md-6">
                <div class="card h-100 shadow-sm border text-center p-4 rounded-4"
                  style="border-color: #cfd3d8 !important;">
                  <div class="card-body">
                    <div class="mb-3 d-flex justify-content-center">
                      <img src="Images/t2.jpg" alt="Sehani Silva"
                        class="rounded-circle border border-2 border-secondary"
                        style="width: 60px; height: 60px; object-fit: cover;">
                    </div>
                    <p class="card-text text-light opacity-75 mb-4 fs-5 fst-italic">"SavoryHub helped me discover
                      amazing homemade recipes. The websie is esy to useful and very helpful for beginners."</p>
                    <h5 class="card-title mb-0 text-white">Kasun Chamara</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="row justify-content-center">
              <div class="col-md-6">
                <div class="card h-100 shadow-sm border text-center p-4 rounded-4"
                  style="border-color: #cfd3d8 !important;">
                  <div class="card-body">
                    <div class="mb-3 d-flex justify-content-center">
                      <img src="Images/t3.jpg" alt="Kasun Chamara"
                        class="rounded-circle border border-2 border-secondary"
                        style="width: 60px; height: 60px; object-fit: cover;">
                    </div>
                    <p class="card-text text-light opacity-75 mb-4 fs-5 fst-italic">"Great collection of recipes and
                      beautiful design. I found many dishes to cook my family"</p>
                    <h5 class="card-title mb-0 text-white">Shehani Silva</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="row justify-content-center">
              <div class="col-md-6">
                <div class="card h-100 shadow-sm border text-center p-4 rounded-4"
                  style="border-color: #cfd3d8 !important;">
                  <div class="card-body">
                    <div class="mb-3 d-flex justify-content-center">
                      <img src="Images/t4.jpg" alt="Niroshan D." class="rounded-circle border border-2 border-secondary"
                        style="width: 60px; height: 60px; object-fit: cover;">
                    </div>
                    <p class="card-text text-light opacity-75 mb-4 fs-5 fst-italic">"I love trying out new recipes from
                      here every weekend! The ingredients are always accessible."</p>
                    <h5 class="card-title mb-0 text-white">Niroshan D.</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="row justify-content-center">
              <div class="col-md-6">
                <div class="card h-100 shadow-sm border text-center p-4 rounded-4"
                  style="border-color: #cfd3d8 !important;">
                  <div class="card-body">
                    <div class="mb-3 d-flex justify-content-center">
                      <img src="Images/t5.png" alt="Amaya Fernando"
                        class="rounded-circle border border-2 border-secondary"
                        style="width: 60px; height: 60px; object-fit: cover;">
                    </div>
                    <p class="card-text text-light opacity-75 mb-4 fs-5 fst-italic">"The instructions are so clear, even
                      my kids can follow them to make easy snacks!"</p>
                    <h5 class="card-title mb-0 text-white">Amal Fernando</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="carousel-indicators" style="bottom: 0;">
          <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="0"
            class="active bg-secondary rounded-circle" style="height: 10px; width: 10px;" aria-current="true"></button>
          <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="1"
            class="bg-secondary rounded-circle" style="height: 10px; width: 10px;"></button>
          <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="2"
            class="bg-secondary rounded-circle" style="height: 10px; width: 10px;"></button>
          <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="3"
            class="bg-secondary rounded-circle" style="height: 10px; width: 10px;"></button>
          <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="4"
            class="bg-secondary rounded-circle" style="height: 10px; width: 10px;"></button>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
          <i class="bi bi-chevron-left text-white fs-1"></i>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
          <i class="bi bi-chevron-right text-white fs-1"></i>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </section>

  <footer class="custom-footer text-white py-4 mt-auto">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
      <div class="mb-3 mb-md-0 text-center text-md-start">
        &copy; 2026 SavoryHub. All right reserved.<br>
        Designed and Developed by SavoryHub.
      </div>
      <div class="d-flex gap-3">
        <a href="#" class="text-white text-decoration-none fs-4"><i class="bi bi-facebook"></i></a>
        <a href="#" class="text-white text-decoration-none fs-4"><i class="bi bi-twitter-x"></i></a>
        <a href="#" class="text-white text-decoration-none fs-4"><i class="bi bi-instagram"></i></a>
        <a href="#" class="text-white text-decoration-none fs-4"><i class="bi bi-youtube"></i></a>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
