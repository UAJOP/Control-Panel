<?php

include $_SERVER['DOCUMENT_ROOT'] . "/common/database.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['username']) || !isset($data['password'])) {
    http_response_code(400);
    exit();
}

$username = $data['username'];
$password = $data['password'];

$conn = getConnection();

$stmt = $conn->prepare("SELECT * FROM user WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $username, $username);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    http_response_code(404);
    exit();
}

$row = $result->fetch_assoc();

if (!password_verify($password, $row['password'])) {
    http_response_code(401);
    exit();
}

if($row['role_id'] == 3 || $row['role_id'] == 4){
    http_response_code(403);
    exit();
}

session_start();

$_SESSION['user'] = $row;

header("Location: /dashboard");
exit();
