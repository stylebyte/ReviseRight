<?php
session_start();
include "config.php";
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit();
}

$action = $_POST['action'] ?? '';

if ($action == "register") {

    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo json_encode(["status" => "error", "message" => "Passwords do not match"]);
        exit();
    }

    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email already exists"]);
        exit();
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $conn->query("INSERT INTO users (full_name, email, password)
                  VALUES ('$full_name', '$email', '$hashed')");

    echo json_encode(["status" => "success", "message" => "Registration successful"]);
    exit();
}


if ($action == "login") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");

    if ($result->num_rows == 0) {
        echo json_encode(["status" => "error", "message" => "User not found"]);
        exit();
    }

    $user = $result->fetch_assoc();
  
    if (!password_verify($password, $user['password'])) {
        echo json_encode(["status" => "error", "message" => "Invalid password"]);
        exit();
    }

    $_SESSION['user_id'] = $user['id'];

echo json_encode([
    "status" => "success",
    "message" => "Login successful",
    "session_test" => $_SESSION['user_id']
]);
exit();
}
?>