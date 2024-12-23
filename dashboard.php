<?php
session_start();
include_once('config/db.php');
include_once('models/employee.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get user ID from session
$userId = $_SESSION['user_id'];

// Query to get user details
$query = "SELECT * FROM users WHERE id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmt->execute();
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$currentUser) {
    // Handle case where user is not found
    echo "User not found!";
    exit();
}

// Fetch all customers
$customer = new Customer($pdo);
$customers = $customer->getAllCustomers();

// Check if user is an admin (use is_admin field)
$is_admin = $currentUser['is_admin'] == 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style_admin.css">
</head>
<body>
<div class="sidebar">
        <div class="logo">
            <img src="image/logo.png" alt="Logo">
            <span>Lab Tech</span>
        </div>
        <ul>
            <li><a href="dashboard.php"><img src="image/Vector (2).png" alt="Dashboard Icon">Dashboard</a></li>
            <?php if ($is_admin) { ?>
            <li><a href="admin/manage_employees.php"><img src="image/user 3 1.png" alt="Patient Icon">Add Employee</a></li>
            <li><a id="Lab_Technical" href="admin/manage_users.php"><img src="image/Group.png" alt="Lab Technical Icon">Manage Users</a></li> 
            <?php } ?>
            <li><a href="view_employee.php"><img src="image/user 3 1.png" alt="Receptionist Icon">View Employee Data</a></li>
            <li><br></li>
            <li><a href="logout.php"><img src="/FCDS/image/Vector (3).png" alt="logout">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
    <div class="header">
    <div class="user-info" style="display: inline-block; margin-left: auto;">
        <!-- Display logged-in user's profile image -->
        <?php if (!empty($currentUser['profile_image_url'])): ?>
            <img src="<?= htmlspecialchars($currentUser['profile_image_url']) ?>" alt="User Profile" style="border-radius: 50%; width: 100px; height: 100px;">
        <?php else: ?>
            <!-- Default image if the user hasn't uploaded one -->
            <img src="/FCDS/image/Ellipse 37.png" alt="Default User Profile" style="border-radius: 50%; width: 50px; height: 50px;">
        <?php endif; ?>
        <div>
            <strong><?= htmlspecialchars($currentUser['username']) ?></strong><br>
            <span><?= $currentUser['is_admin'] ? 'Admin' : 'User' ?></span>
        </div>
    </div>
</div>

    
<script src="/FCDS/js/my_js.js"></script>
</body>
</html>
