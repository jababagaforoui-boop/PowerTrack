<?php
function sanitize($data) {
    return htmlspecialchars(strip_tags($data));
}

function calculate_energy($wattage, $hours) {
    return ($wattage * $hours) / 1000; // kWh
}

function calculate_cost($energy, $rate_per_kwh) {
    return $energy * $rate_per_kwh;
}

function is_logged_in() {
    session_start();
    return isset($_SESSION['user']);
}

function require_login() {
    session_start();
    if(!isset($_SESSION['user'])) {
        header("Location: ../frontend/login.html");
        exit();
    }
}
?>