<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/database.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    exit();
}

session_start();

$user = $_SESSION['user'];

if (!isset($user)) {
    http_response_code(401);
    exit();
}

$conn = getConnection();

$monthlyNewOrders = $conn
    ->query("SELECT * FROM order_ WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)")
    ->num_rows;

$customerCount = $conn
    ->query("SELECT * FROM user WHERE role_id = 4")
    ->num_rows;

$monthlyRevenue = $conn
    ->query("SELECT SUM(order_product.quantity * order_product.sale_price) AS total FROM order_ LEFT JOIN order_product ON order_.id = order_product.order_id WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)")
    ->fetch_assoc()['total'];

$monthlyProductsSold = $conn
    ->query("SELECT SUM(order_product.quantity) AS total FROM order_ LEFT JOIN order_product ON order_.id = order_product.order_id WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)")
    ->fetch_assoc()['total'];

$salesThroughYear = $conn
    ->query("SELECT MONTH(created_at) AS month, SUM(order_product.quantity * order_product.sale_price) AS total FROM order_ LEFT JOIN order_product ON order_.id = order_product.order_id WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY MONTH(created_at)")
    ->fetch_all(MYSQLI_ASSOC);

$monthlyMostSoldProducts = $conn
    ->query("SELECT product.name, SUM(order_product.quantity) AS total FROM order_ LEFT JOIN order_product ON order_.id = order_product.order_id LEFT JOIN product ON order_product.product_id = product.id WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY product.id ORDER BY total DESC LIMIT 5")
    ->fetch_all(MYSQLI_ASSOC);

$monthlyLeastSoldProducts = $conn
    ->query("SELECT product.name, SUM(order_product.quantity) AS total FROM order_ LEFT JOIN order_product ON order_.id = order_product.order_id LEFT JOIN product ON order_product.product_id = product.id WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY product.id ORDER BY total ASC LIMIT 5")
    ->fetch_all(MYSQLI_ASSOC);

$latestOrders = $conn
    ->query("SELECT order_.id, order_.created_at, user.username AS customer, SUM(order_product.quantity * order_product.sale_price) AS total FROM order_ LEFT JOIN order_product ON order_.id = order_product.order_id LEFT JOIN user ON order_.user_id = user.id GROUP BY order_.id ORDER BY order_.created_at DESC LIMIT 5")
    ->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/json');

echo json_encode([
    "numOrders" => $monthlyNewOrders,
    "numCustomers" => $customerCount,
    "revenue" => $monthlyRevenue,
    "productsSold" => $monthlyProductsSold,
    "sales" => $salesThroughYear,
    "mostSold" => $monthlyMostSoldProducts,
    "leastSold" => $monthlyLeastSoldProducts,
    "latestOrders" => $latestOrders
]);
