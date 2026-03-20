<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

require_login(); // Ensure user is logged in to submit a recipe

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize_input($_POST['title'] ?? '');
    $description = sanitize_input($_POST['description'] ?? '');
    $ingredients = sanitize_input($_POST['ingredients'] ?? '');
    $instructions = sanitize_input($_POST['instructions'] ?? '');
    $user_id = $_SESSION['user_id'];

    if (empty($title) || empty($description) || empty($ingredients) || empty($instructions)) {
        $error = "All fields except the image are required.";
    } else {
        $imagePath = 'Images/default_recipe.jpg'; // fallback
        
        // Handle file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'Images/';
            // Ensure safe file name
            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetFile = $uploadDir . $fileName;
            
            // Allow certain file formats
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            if (in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $imagePath = $targetFile;
                } else {
                    $error = "Sorry, there was an error uploading your image.";
                }
            } else {
                $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }
        }

        if (empty($error)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO recipes (title, description, ingredients, instructions, image, user_id) VALUES (?, ?, ?, ?, ?, ?)");
                if ($stmt->execute([$title, $description, $ingredients, $instructions, $imagePath, $user_id])) {
                    $success = "Recipe submitted successfully!";
                } else {
                    $error = "An error occurred while saving the recipe.";
                }
            } catch (PDOException $e) {
                $error = "Database Error: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Submit Recipe - SavoryHub</title>
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
          <li class="nav-item"><a class="nav-link scroll-link" href="about.php">About Us</a></li>
          <li class="nav-item"><a class="nav-link scroll-link" href="recipes.php">Recipe Details</a></li>
          <li class="nav-item"><a class="nav-link scroll-link active" href="submit.php">Add Recipe</a></li>
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

  <section class="container my-5 text-center"
    style="background: url('Images/bg.jpg') center/cover no-repeat; background-attachment: fixed; position: relative; padding: 4rem 2rem; border-radius: 10px;">
    <div
      style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(44, 48, 52, 0.85); border-radius: 15px;">
    </div>
    <div style="position: relative; z-index: 2;">
      <h2 class="mb-4" style="color: #f39c12; font-weight: bold;">Submit Your Recipe</h2>

      <div class="row justify-content-center">
        <div class="col-md-6">
          <?php if ($success): ?>
              <div class="alert alert-success"><?php echo $success; ?></div>
          <?php endif; ?>
          <?php if ($error): ?>
              <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
          <?php endif; ?>

          <form id="submitRecipeForm" method="POST" action="submit.php" enctype="multipart/form-data" novalidate>
            <div class="mb-3 text-start">
              <input type="text" class="form-control" name="title" id="recipeName" placeholder="Recipe Name" required>
              <div class="invalid-feedback">Please provide a recipe name.</div>
            </div>
            <div class="mb-3 text-start">
              <textarea class="form-control" name="description" id="recipeDesc" placeholder="Recipe Description" rows="3" required></textarea>
              <div class="invalid-feedback">Please provide a description.</div>
            </div>
            <div class="mb-3 text-start">
              <textarea class="form-control" name="ingredients" id="recipeIngredients" placeholder="Ingredients (one per line recommended)" rows="3" required></textarea>
              <div class="invalid-feedback">Please list the ingredients.</div>
            </div>
            <div class="mb-3 text-start">
              <textarea class="form-control" name="instructions" id="recipeSteps" placeholder="How to Cook" rows="4" required></textarea>
              <div class="invalid-feedback">Please provide cooking steps.</div>
            </div>
            <div class="mb-3 text-start text-white">
              <label for="recipeImage" class="form-label">Recipe Image</label>
              <input class="form-control" type="file" name="image" id="recipeImage" accept="image/*" required>
              <div class="invalid-feedback">Please upload an image for your recipe.</div>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-2" style="background:#f39c12; border:none;">Submit
              Recipe</button>
          </form>
        </div>
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
