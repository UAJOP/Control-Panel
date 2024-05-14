<?php

session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/common/database.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    exit();
}

$user = $_SESSION['user'];

if (!isset($user) || $user['role_id'] != 1) {
    http_response_code(401);
    exit();
}


$data = json_decode(file_get_contents('php://input'), true);

$username = $data['username'];
$email = $data['email'];
$password = $data['password'];
$first_name = $data['first_name'];
$last_name = $data['last_name'];
$full_address = $data['full_address'];
$role_id = $data['role_id'];

$password = password_hash($password, PASSWORD_DEFAULT);

$conn = getConnection();

$sql = "INSERT INTO user (username, email, password, first_name, last_name, full_address, role_id) VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssi", $username, $email, $password, $first_name, $last_name, $full_address, $role_id);


header('Content-Type: application/json');


if ($stmt->execute()) {
    http_response_code(201);
    echo json_encode(array("message" => "Kullanıcı yaratıldı."));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Kullanıcı yaratılamadı."));
}
