<?php
session_start();
include_once('../config/db.php');
include_once('../models/employee.php');
$customer = new Customer($pdo);

// Fetch customer data by ID
if (isset($_GET['id'])) {
    $customerId = $_GET['id'];
    $sql = "SELECT * FROM customers WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$customerId]);
    $cust = $stmt->fetch();
}

// Redirect if no valid customer ID is provided
if (!$cust) {
    header('Location: manage_employees.php');
    exit();
}

// Fetch current user details for sidebar
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
    $currentUser = $stmt->fetch();
} else {
    header('Location: ../login.php');
    exit();
}

// Handle form submission to update customer details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $address = $_POST['address'];
    $dateOfBirth = $_POST['date_of_birth'];
    $nationalId = $_POST['national_id'];

    $sql = "UPDATE customers 
            SET name = ?, email = ?, phone_number = ?, address = ?, date_of_birth = ?, national_id = ?, updated_at = NOW() 
            WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $email, $phoneNumber, $address, $dateOfBirth, $nationalId, $customerId]);

    header('Location: manage_employees.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <link rel="stylesheet" href="../css/style_admin.css">
    <style>
        .form-container {
            width: 50%;
            margin: 40px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: Arial, sans-serif;
        }

        .form-container h2 {
            text-align: center;
            color: #333;
        }

        .form-container label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="date"],
        .form-container textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .form-container button {
            background-color: rgb(61, 161, 195);
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .form-container button:hover {
            background-color: rgb(50, 130, 160);
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="../image/logo.png" alt="Logo">
            <span>Lab Tech</span>
        </div>
        <ul>
            <li><a href="../dashboard.php"><img src="../image/Vector (2).png" alt="Dashboard Icon">Dashboard</a></li>
            <li><a href="../admin/manage_employees.php"><img src="../image/user 3 1.png" alt="Employee Icon">Add Employee</a></li>
            <li><a id="Lab_Technical" href="../admin/manage_users.php"><img src="../image/Group.png" alt="Users Icon">Manage Users</a></li>
            <li><a href="../view_employee.php"><img src="../image/user 3 1.png" alt="Employee Icon">View Employee Data</a></li>
            <li><br></li>
            <li><a href="../logout.php"><img src="/FCDS/image/Vector (3).png" alt="logout">Logout</a></li>
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


        </div>

        <div class="form-container">
            <h2>Edit Employee</h2>
            <form method="POST">
                <label for="name">Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($cust['name']) ?>" required>

                <label for="email">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($cust['email']) ?>" required>

                <label for="phone_number">Phone Number</label>
                <input type="text" name="phone_number" value="<?= htmlspecialchars($cust['phone_number']) ?>" required>

                <label for="address">Address</label>
                <textarea name="address" required><?= htmlspecialchars($cust['address']) ?></textarea>

                <label for="date_of_birth">Date of Birth</label>
                <input type="date" name="date_of_birth" value="<?= htmlspecialchars($cust['date_of_birth']) ?>" required>

                <label for="national_id">National ID</label>
                <input type="text" name="national_id" value="<?= htmlspecialchars($cust['national_id']) ?>" required>

                <button type="submit">Update Customer</button>
            </form>
        </div>

</body>
</html>
