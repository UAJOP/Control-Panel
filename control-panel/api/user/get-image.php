<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/common/database.php";

if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    http_response_code(405);
    exit();
}

$username = urldecode($_GET['username']);

$conn = getConnection();

$stmt = $conn->prepare("SELECT profile_picture FROM user WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $username, $username);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    http_response_code(404);
    exit();
}

$row = $result->fetch_assoc();
if ($row['profile_picture'] == null) {
    http_response_code(404);
    exit();
}
$path = $_SERVER['DOCUMENT_ROOT'] . '/upload/pfp/' . $row['profile_picture'];
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

echo $base64;

$conn->close();

