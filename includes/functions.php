<?php
// includes/functions.php

session_start();

/**
 * Sanitize user input to prevent XSS and SQL Injection
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Check if the user is currently logged in
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Redirect unauthenticated users to the login page
 * @param string $base_path Relative path to the root directory
 */
function require_login($base_path = '') {
    if (!is_logged_in()) {
        header("Location: " . $base_path . "auth/login.php");
        exit();
    }
}

/**
 * Redirect authenticated users away from guest-only pages
 * @param string $base_path Relative path to the root directory
 */
function require_guest($base_path = '') {
    if (is_logged_in()) {
        header("Location: " . $base_path . "dashboard.php");
        exit();
    }
}
?>
