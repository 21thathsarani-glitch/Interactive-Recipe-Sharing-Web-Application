<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

require_guest('../'); // Only guests can register

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitize_input($_POST['full_name'] ?? '');
    $username = sanitize_input($_POST['username'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Server-side validation
    if (empty($full_name) || empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } else {
        // Check if username or email exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $error = "Username or Email already exists.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (full_name, username, email, password) VALUES (?, ?, ?, ?)");
            
            try {
                if ($stmt->execute([$full_name, $username, $email, $hashed_password])) {
                    $success = "Registration successful! You can now <a href='login.php' class='text-warning text-decoration-underline'>Login</a>.";
                } else {
                    $error = "Something went wrong. Please try again.";
                }
            } catch (PDOException $e) {
                $error = "Database error: " . $e->getMessage();
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
    <title>Register - SavoryHub</title>
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
                        <li class="nav-item guest-only"><a class="nav-link scroll-link" href="login.php">Login</a></li>
                        <li class="nav-item guest-only"><a class="nav-link scroll-link active" href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <section class="container my-5 flex-grow-1 d-flex align-items-center justify-content-center">
        <div class="card bg-secondary text-white p-5 shadow-lg rounded-4 border-0"
            style="max-width: 500px; width: 100%;">
            <h2 class="text-center mb-4 text-warning fw-bold">Create an Account</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $success; ?>
                </div>
            <?php else: ?>
                <form id="registerForm" method="POST" action="register.php" novalidate>
                    <div class="mb-3">
                        <label for="registerName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="full_name" id="registerName" placeholder="Enter your full name" required value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>">
                        <div class="invalid-feedback text-warning">Please enter your name.</div>
                    </div>
                    <div class="mb-3">
                        <label for="registerUserName" class="form-label">User Name</label>
                        <input type="text" class="form-control" name="username" id="registerUserName" placeholder="Choose a user name" required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                        <div class="invalid-feedback text-warning">Please enter a user name.</div>
                    </div>
                    <div class="mb-3">
                        <label for="registerEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" id="registerEmail" placeholder="Enter your email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        <div class="invalid-feedback text-warning">Please enter a valid email address.</div>
                    </div>
                    <div class="mb-3">
                        <label for="registerPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="registerPassword" placeholder="Create a password" required minlength="6">
                        <div class="invalid-feedback text-warning">Password must be at least 6 characters long.</div>
                    </div>
                    <div class="mb-4">
                        <label for="registerConfirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password" id="registerConfirmPassword" placeholder="Confirm your password" required>
                        <div class="invalid-feedback text-warning" id="confirmPasswordError">Passwords do not match.</div>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 mb-4 text-dark fw-bold fs-5 py-2" style="background:#f39c12; border:none;">Register</button>
                    <div class="text-center">
                        <p class="mb-0 text-light opacity-75">Already have an account? <a href="login.php" class="text-warning text-decoration-none fw-bold">Login here</a></p>
                    </div>
                </form>
            <?php endif; ?>
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
