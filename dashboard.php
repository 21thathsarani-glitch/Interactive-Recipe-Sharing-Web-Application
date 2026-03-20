<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

require_login(); // Ensure user is logged in

$user_id = $_SESSION['user_id'];

// Fetch user's recipes
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$recipes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - SavoryHub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body class="d-flex flex-column min-vh-100 bg-light text-dark">

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
          <li class="nav-item"><a class="nav-link scroll-link" href="about.php">About Us</a></li>
          <li class="nav-item"><a class="nav-link scroll-link" href="recipes.php">Recipe Details</a></li>
          <li class="nav-item"><a class="nav-link scroll-link" href="submit.php">Add Recipe</a></li>
          <li class="nav-item"><a class="nav-link scroll-link" href="contact.php">Contact Us</a></li>
          <li class="nav-item user-only"><a class="nav-link scroll-link active" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item user-only"><a class="nav-link scroll-link" href="auth/logout.php" id="logoutBtn">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="container my-5 flex-grow-1">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <hr>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 text-black">
            <h4>Your Submitted Recipes</h4>
            <?php if (count($recipes) > 0): ?>
                <div class="row mt-3">
                    <?php foreach ($recipes as $recipe): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm border-0">
                                <img src="<?php echo htmlspecialchars($recipe['image']); ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Recipe Image">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-dark"><?php echo htmlspecialchars($recipe['title']); ?></h5>
                                    <p class="card-text text-muted"><?php echo htmlspecialchars(substr($recipe['description'], 0, 80)) . '...'; ?></p>
                                    <small class="text-muted mt-auto mb-2">Submitted on: <?php echo date('M d, Y', strtotime($recipe['created_at'])); ?></small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info border-0 shadow-sm">
                    You haven't submitted any recipes yet. <a href="submit.php" class="alert-link">Add one now!</a>
                </div>
            <?php endif; ?>
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
