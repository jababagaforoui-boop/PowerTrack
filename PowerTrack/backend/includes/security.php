<?php
// Start session safely
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

// Protect page for logged-in users
function protect_page() {
    if(!isset($_SESSION['user'])) {
        header("Location: ../frontend/login.html");
        exit();
    }
}

// Sanitize input
function sanitize($data) {
    return htmlspecialchars(strip_tags($data));
}

// Generate CSRF token
function csrf_token() {
    if(empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Verify CSRF token
function verify_csrf($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'],$token);
}
?>