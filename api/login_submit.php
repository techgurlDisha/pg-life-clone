<?php
require("../includes/database_connect.php");

header('Content-Type: application/json');

$email = trim($_POST['email']);
$password = trim($_POST['password']);

// Check if email exists
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) == 0) {
    echo json_encode(["success" => false, "message" => "Invalid email or password!"]);
    exit;
}

$user = mysqli_fetch_assoc($result);

// Password verify
if (!password_verify($password, $user['password'])) {
    echo json_encode(["success" => false, "message" => "Invalid email or password!"]);
    exit;
}

// Login successful
session_start();
$_SESSION["user_id"] = $user["id"];
$_SESSION["full_name"] = $user["full_name"];

echo json_encode(["success" => true, "message" => "Login successful!"]);
mysqli_close($conn);
?>
