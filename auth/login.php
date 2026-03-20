<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

require_guest('../'); // Only guests can login

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = sanitize_input($_POST['identifier'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($identifier) || empty($password)) {
        $error = "Both username/email and password are required.";
    } else {
        // Fetch user by username or email
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$identifier, $identifier]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Valid credentials
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            // Redirect to dashboard
            header("Location: ../dashboard.php");
            exit();
        } else {
            $error = "Invalid username/email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SavoryHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="d-flex flex-column min-vh-100 bg-dark text-white">

    <nav class="navbar navbar-expand-lg custom-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <img src="../Images/logo.png" alt="SavoryHub Logo" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                style="border-color: transparent;">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link scroll-link" href="../index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link scroll-link" href="../about.php">About Us</a></li>
                    <li class="nav-item"><a class="nav-link scroll-link" href="../recipes.php">Recipe Details</a></li>
                    <li class="nav-item"><a class="nav-link scroll-link" href="../submit.php">Add Recipe</a></li>
                    <li class="nav-item"><a class="nav-link scroll-link" href="../contact.php">Contact Us</a></li>
                    <?php if (is_logged_in()): ?>
                        <li class="nav-item user-only"><a class="nav-link scroll-link" href="../dashboard.php">Dashboard</a></li>
                        <li class="nav-item user-only"><a class="nav-link scroll-link" href="logout.php" id="logoutBtn">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item guest-only"><a class="nav-link scroll-link active" href="login.php">Login</a></li>
                        <li class="nav-item guest-only"><a class="nav-link scroll-link" href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <section class="container my-5 flex-grow-1 d-flex align-items-center justify-content-center">
        <div class="card bg-secondary text-white p-5 shadow-lg rounded-4 border-0"
            style="max-width: 450px; width: 100%;">
            <h2 class="text-center mb-4 text-warning fw-bold">Login to SavoryHub</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form id="loginForm" method="POST" action="login.php" novalidate>
                <div class="mb-3">
                    <label for="loginIdentifier" class="form-label">Username or Email</label>
                    <input type="text" class="form-control" name="identifier" id="loginIdentifier" placeholder="Enter your username or email" required value="<?php echo isset($_POST['identifier']) ? htmlspecialchars($_POST['identifier']) : ''; ?>">
                    <div class="invalid-feedback text-warning">Please enter your username or email.</div>
                </div>
                <div class="mb-4">
                    <label for="loginPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="loginPassword" placeholder="Enter your password" required>
                    <div class="invalid-feedback text-warning">Please enter your password.</div>
                </div>
                <button type="submit" class="btn btn-warning w-100 mb-4 text-dark fw-bold fs-5 py-2" style="background:#f39c12; border:none;">Login</button>
                <div class="text-center">
                    <p class="mb-0 text-light opacity-75">Don't have an account? <a href="register.php" class="text-warning text-decoration-none fw-bold">Register here</a></p>
                </div>
            </form>
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
    <script src="../js/script.js"></script>
</body>
</html>
