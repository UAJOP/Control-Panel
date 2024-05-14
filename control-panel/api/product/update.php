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

$conn = getConnection();

$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'];
$name = $data['name'];
$description = $data['description'];
$company_price = $data['company_price'];
$sale_price = $data['sale_price'];
$category_id = $data['category_id'];

$conn = getConnection();

$sql = "UPDATE product SET name=?, description=?, company_price=?, sale_price=?, category_id=? WHERE id=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssddii", $name, $description, $company_price, $sale_price, $category_id, $id);

header('Content-Type: application/json');

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(array("message" => "Ürün güncellendi."));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Ürün güncelleme başarısız."));
}
?>
