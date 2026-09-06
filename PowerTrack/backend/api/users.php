<?php
include '../config/db.php';
include '../includes/functions.php';
session_start();

$action = $_GET['action'] ?? '';

if($action == 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $address = sanitize($_POST['address']);

    $stmt = $conn->prepare("INSERT INTO users (name,email,password,address) VALUES (?,?,?,?)");
    if($stmt->execute([$name,$email,$password,$address])) {
        echo json_encode(['status'=>'success','message'=>'User registered']);
    } else {
        echo json_encode(['status'=>'error','message'=>'Registration failed']);
    }
}

if($action == 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($password,$user['password'])) {
        $_SESSION['user'] = $user;
        echo json_encode(['status'=>'success','message'=>'Login successful']);
    } else {
        echo json_encode(['status'=>'error','message'=>'Invalid credentials']);
    }
}

if($action == 'logout') {
    session_destroy();
    echo json_encode(['status'=>'success','message'=>'Logged out']);
}
?>