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
    echo "User not found!";
    exit();
}

// Fetch all customers
$customer = new Customer($pdo);
$customers = $customer->getAllCustomers();

// Check if user is an admin
$is_admin = $currentUser['is_admin'] == 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>
    <link rel="stylesheet" href="css/style_admin.css">
    <style>
        .main-content {
            margin-left: 320px;
            margin-right: 120px;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: rgb(61, 161, 195);
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        a {
            color: rgb(61, 161, 195);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .actions a {
            margin-right: 10px;
        }
        .btn-edit {
            margin: 2px;
            background-color: rgb(50, 130, 160);
            color: white;
            padding: 10px;
            text-decoration: none;
            display: inline-block; /* Ensures the links stay inline */
            border-radius: 4px

        }

        .btn-delete {
            margin: 2px;
            background-color: #dc3545;
            color: white;
            padding: 10px;
            text-decoration: none;
            display: inline-block; /* Ensures the links stay inline */
            border-radius: 4px

        }
    </style>
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
            <li><a href="admin/manage_employees.php"><img src="image/user 3 1.png" alt="Employee Icon">Add Employee</a></li>
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
        <div>
            <h2>Employee List</h2>

            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Date of Birth</th>
                    <th>National ID</th>
                    <?php if ($is_admin) { ?>
                        <th>Actions</th>
                    <?php } ?>
                </tr>
                <?php foreach ($customers as $cust) { ?>
                    <tr>
                        <td><?= htmlspecialchars($cust['name']) ?></td>
                        <td><?= htmlspecialchars($cust['email']) ?></td>
                        <td><?= htmlspecialchars($cust['phone_number']) ?></td>
                        <td><?= htmlspecialchars($cust['address']) ?></td>
                        <td><?= htmlspecialchars($cust['date_of_birth']) ?></td>
                        <td><?= htmlspecialchars($cust['national_id']) ?></td>
                        <?php if ($is_admin) { ?>
                            <td  class="actions">
                                <a class="btn-edit" href="admin/edit_employee.php?id=<?= $cust['id'] ?>">Edit</a> 
                                <a class="btn-delete" href="admin/delete_employee.php?id=<?= $cust['id'] ?>">Delete</a>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <script src="/FCDS/js/my_js.js"></script>
</body>
</html>
