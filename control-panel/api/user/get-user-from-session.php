<?php
session_start();

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    exit();
}

$user = $_SESSION['user'];

$user['password'] = null;

echo json_encode($user);
