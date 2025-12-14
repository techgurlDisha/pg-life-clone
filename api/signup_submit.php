<?php
require("../includes/database_connect.php");

header('Content-Type: application/json');

$full_name = trim($_POST['full_name']);
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$college_name = trim($_POST['college_name']);
$gender = trim($_POST['gender']);

// Secure password hashing
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if email already exists
$sql = "SELECT id FROM users WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    echo json_encode(["success" => false, "message" => "This email id is already registered with us!"]);
    exit;
}

// Insert user
$sql = "INSERT INTO users (email, password, full_name, phone, gender, college_name)
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssssss", $email, $hashed_password, $full_name, $phone, $gender, $college_name);
$success = mysqli_stmt_execute($stmt);

if ($success) {
    echo json_encode(["success" => true, "message" => "Your account has been created successfully!"]);
} else {
    echo json_encode(["success" => false, "message" => "Something went wrong!"]);
}

mysqli_close($conn);
?>
