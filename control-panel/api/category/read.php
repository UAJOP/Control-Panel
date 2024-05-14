<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/common/database.php";

if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    http_response_code(405);
    exit();
}

$user = $_SESSION['user'];

if (!isset($user)) {
    http_response_code(401);
    exit();
}

$conn = getConnection();

$sql = "SELECT * FROM product_category";

$result = $conn->query($sql);


header('Content-Type: application/json');


if ($result->num_rows > 0) {
    $users = array();
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    echo json_encode($users);
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to read categories."));
}
