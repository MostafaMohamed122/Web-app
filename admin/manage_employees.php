<?php
session_start();
require_once('../config/db.php');
require_once('../models/employee.php');

// Redirect if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Get user ID from session
$userId = $_SESSION['user_id'];

// Fetch user details
$query = "SELECT * FROM users WHERE id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmt->execute();
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle case where user is not found
if (!$currentUser) {
    die("User not found!");
}

// Initialize Customer object and fetch customers
$customer = new Customer($pdo);
$customers = $customer->getAllCustomers();

// Check if user is an admin
$isAdmin = $currentUser['is_admin'] == 1;

// Handle form submission to add a new customer
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $address = $_POST['address'];
    $dateOfBirth = $_POST['date_of_birth'];
    $nationalId = $_POST['national_id'];

    $customer->createCustomer($name, $email, $phoneNumber, $address, $dateOfBirth, $nationalId);
    header('Location: manage_employees.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/style_admin.css">
    <style>
table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
}

th, td {
    padding: 12px;
    text-align: left;
    border: 1px solid #ddd;
}

th {
    background-color: rgb(61, 161, 195);
    color: white;
    font-weight: bold;
    text-transform: uppercase;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #ddd;
}

caption {
    font-size: 1.5em;
    margin: 10px;
    font-weight: bold;
    color: #333;
}

.form-container {
    width: 70%;
    margin: auto;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.form-container h1, h2 {
    text-align: center;
    color: #333;
}

label {
    font-weight: bold;
    display: block;
    margin-top: 10px;
}

input, select {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

button {
    background-color: rgb(61, 161, 195);
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    font-size: 16px;
    display: block;
    margin: auto;
}

button:hover {
    background-color: rgb(50, 130, 160);
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
            <?php if ($isAdmin): ?>
                <li><a href="../admin/manage_employees.php"><img src="../image/user 3 1.png" alt="Employee Icon">Add Employee</a></li>
                <li><a id="Lab_Technical" href="../admin/manage_users.php"><img src="../image/Group.png" alt="Users Icon">Manage Users</a></li>
            <?php endif; ?>
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

        <div class="form-container">
            <h1>Add Employee</h1>
            <form method="POST">
                <label for="name">Name</label>
                <input type="text" name="name" required>

                <label for="email">Email</label>
                <input type="email" name="email" required>

                <label for="phone_number">Phone Number</label>
                <input type="text" name="phone_number" required>

                <label for="address">Address</label>
                <input type="text" name="address" required>

                <label for="date_of_birth">Date of Birth</label>
                <input type="date" name="date_of_birth" required>

                <label for="national_id">National ID</label>
                <input type="text" name="national_id" required>

                <button type="submit">Add Employee</button>
            </form>

            <h2>Employee List</h2>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Date of Birth</th>
                    <th>National ID</th>
                </tr>
                <?php foreach ($customers as $cust): ?>
                    <tr>
                        <td><?= htmlspecialchars($cust['name']) ?></td>
                        <td><?= htmlspecialchars($cust['email']) ?></td>
                        <td><?= htmlspecialchars($cust['phone_number']) ?></td>
                        <td><?= htmlspecialchars($cust['address']) ?></td>
                        <td><?= htmlspecialchars($cust['date_of_birth']) ?></td>
                        <td><?= htmlspecialchars($cust['national_id']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>   <script src="/FCDS/js/my_js.js"></script>

</body>
</html>
