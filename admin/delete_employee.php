<?php
session_start();
include_once('../config/db.php');
include_once('../models/employee.php');
$customer = new Customer($pdo);

if (isset($_GET['id'])) {
    $customerId = $_GET['id'];
    $sql = "DELETE FROM customers WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$customerId]);
    header('Location: ../view_employee.php');
}
