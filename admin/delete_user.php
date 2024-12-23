<?php
session_start();
include_once('../config/db.php');
include_once('../models/User.php');
$user = new User($pdo);

if (!isset($_SESSION['user_id']) || !$user->isAdmin($_SESSION['user_id'])) {
    header('Location: ../');
}

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
    header('Location: manage_users.php');
}
