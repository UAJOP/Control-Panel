<?php

session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/common/database.php";

if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
    http_response_code(405);
    exit();
}

$user = $_SESSION['user'];

if (!isset($user) || $user['role_id'] != 1) {
    http_response_code(401);
    exit();
}


$conn = getConnection();

$id = $_GET['id'];

$sql = "DELETE FROM user WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);


header('Content-Type: application/json');


if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(array("message" => "Kullanıcı silindi."));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Kullanıcı silinemedi."));
}
?>
