<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize_input($_POST['name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $message = sanitize_input($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        $error = "Please fill in all the required fields.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
            if ($stmt->execute([$name, $email, $message])) {
                $success = "Thank you! Your message has been sent successfully.";
            } else {
                $error = "An error occurred while sending your message. Please try again.";
            }
        } catch (PDOException $e) {
            $error = "Database Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us - SavoryHub</title>
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
          <li class="nav-item"><a class="nav-link scroll-link" href="submit.php">Add Recipe</a></li>
          <li class="nav-item"><a class="nav-link scroll-link active" href="contact.php">Contact Us</a></li>
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

  <section class="container my-5"
    style="background: url('Images/bg.jpg') center/cover no-repeat; background-attachment: fixed; position: relative; padding: 4rem 2rem; border-radius: 10px;">
    <div
      style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(44, 48, 52, 0.85); border-radius: 10px;">
    </div>
    <div style="position: relative; z-index: 2;">
      <h2 class="text-center mb-4" style="color: #f39c12; font-weight: bold;">Contact Us</h2>
      <div class="row justify-content-center">
        <!-- Left column: contact information -->
        <div class="col-md-6 mb-4">
          <div class="p-4 bg-light rounded text-dark">
            <h4 class="mb-3">Get in Touch</h4>
            <p><i class="bi bi-geo-alt-fill me-2"></i>123 Savory Lane, Galle Town, Sri Lanka</p>
            <p><i class="bi bi-envelope-fill me-2"></i>info@savoryhub.com</p>
            <p><i class="bi bi-telephone-fill me-2"></i>+94 91 234 5678</p>
          </div>
        </div>
        <!-- Right column: contact form -->
        <div class="col-md-6">
          <?php if ($success): ?>
              <div class="alert alert-success"><?php echo $success; ?></div>
          <?php endif; ?>
          <?php if ($error): ?>
              <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
          <?php endif; ?>

          <form id="contactForm" method="POST" action="contact.php" novalidate>
            <div class="mb-3">
              <input type="text" class="form-control" name="name" id="contactName" placeholder="Your Name" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
              <div class="invalid-feedback">Please enter your name.</div>
            </div>
            <div class="mb-3">
              <input type="email" class="form-control" name="email" id="contactEmail" placeholder="Your Email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
              <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>
            <div class="mb-3">
              <textarea class="form-control" name="message" id="contactMessage" rows="5" placeholder="Your Message" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
              <div class="invalid-feedback">Please enter your message.</div>
            </div>
            <button type="submit" class="btn btn-primary w-100" style="background:#f39c12; border:none;">Send
              Message</button>
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
