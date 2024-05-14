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

$id = $data['id'];
$username = $data['username'];
$email = $data['email'];
$password = $data['password'];
$first_name = $data['first_name'];
$last_name = $data['last_name'];
$full_address = $data['full_address'];
$role_id = $data['role_id'];



$conn = getConnection();

$sql = "UPDATE user SET username = ?, email = ?, first_name = ?, last_name = ?, full_address = ?, role_id = ? WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssii", $username, $email, $first_name, $last_name, $full_address, $role_id, $id);

if($password != null) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE user SET password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $password, $id);
}

header('Content-Type: application/json');

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(array("message" => "Kullanıcı güncellendi."));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Kullanıcı güncelleme başarısız."));
}
