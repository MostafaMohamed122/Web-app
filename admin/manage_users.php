<?php 
session_start();
include_once('../config/db.php');
include_once('../models/User.php');
$user = new User($pdo);

// Redirect if the user is not logged in or not an admin
if (!isset($_SESSION['user_id']) || !$user->isAdmin($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Handle form submission to add a new user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $isAdmin = isset($_POST['is_admin']) ? 1 : 0;
    $profileImage = $_FILES['profile_image'] ?? null;

// Handle profile image upload and save URL
$profileImageUrl = null;
if ($profileImage && $profileImage['error'] == UPLOAD_ERR_OK) {
    // Define the upload directory path relative to your web root
    $uploadDir = '/FCDS/uploads/'; // The relative URL
    $fileName = uniqid() . '-' . basename($profileImage['name']);
    $uploadFilePath = 'D:\\XAMPP\\htdocs' . $uploadDir . $fileName; // Absolute file path for server

    // Move the uploaded file to the correct directory on the server
    if (move_uploaded_file($profileImage['tmp_name'], $uploadFilePath)) {
        // Save the relative URL of the image in the database
        $profileImageUrl = $uploadDir . $fileName;
    } else {
        // Handle any error that occurs during file upload
        echo "File upload failed. Error: " . $profileImage['error'];
    }
}


    // Add user
    $user->signUp($username, $password, $isAdmin, $profileImageUrl);
    header('Location: manage_users.php');
    exit();
}

// Fetch current user details
$currentUser = $user->getUserById($_SESSION['user_id']);

// Fetch all users
$users = $user->getAllUsers();
$is_admin = $currentUser['is_admin'] == 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../css/style_admin.css">
    <style>
        /* Existing styles */
        table {
            width: 70%;
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
        .form-container input[type="password"],
        .form-container input[type="checkbox"],
        .form-container input[type="file"] {
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
        /* Hide the file input */
#profile_image {
    display: none;
}

/* Style the custom file upload label */
.custom-file-upload {
    cursor: pointer;
    display: inline-block;
}

.custom-file-upload img {
    width: 150px;
    height: 150px;
    border-radius: 50%; /* Makes it circular */
    object-fit: cover; /* Ensures the image fills the container without distortion */
    border: 2px solid #ccc;
    transition: 0.3s;
}

.custom-file-upload img:hover {
    border-color: #007bff;
}
.btn-edit {
    background-color: rgb(50, 130, 160);
    color: white;
    padding: 10px;
    text-decoration: none;
}

.btn-delete {
    background-color: #dc3545;
    color: white;
    padding: 10px;
    text-decoration: none;
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
            <?php if ($is_admin) { ?>
            <li><a href="../admin/manage_employees.php"><img src="../image/user 3 1.png" alt="Patient Icon">Add Employee</a></li>
            <li><a id="Lab_Technical" href="../admin/manage_users.php"><img src="../image/Group.png" alt="Lab Technical Icon">Manage Users</a></li> 
            <?php } ?>
            <li><a href="../view_employee.php"><img src="../image/user 3 1.png" alt="Receptionist Icon">View Employee Data</a></li>
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
            <h2>Add User</h2>
            <form method="POST" enctype="multipart/form-data">
                
            <label for="profile_image"style="display: flex; justify-content: center; align-items: center;"><img src="/FCDS/image/Add Image.png"style="max-width: 300px; max-height: 300px; display: block;" alt="Upload Photo" id="preview" /></label>
                <input type="file" name="profile_image" id="profile_image" accept="image/*" >

                <label for="username">Username</label>
                <input type="text" name="username" required>

                
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                
                <p id="error-message" style="color: red; display: none;"></p>

                <label for="is_admin"style="display: flex; justify-content: center; align-items: center;">Is Admin</label>
                <input type="checkbox" class="isadmin" name="is_admin">

                <button type="submit">Add User</button>
            </form>
        </div>

        <h2 style="text-align: center; margin-top: 40px;">Manage Users</h2>
        <table>
            <tr>
                <th>Username</th>
                <th>Admin</th>
                <th>Profile Image</th>
                <th>Action</th>
            </tr>
            <?php foreach ($users as $usr): ?>
                <tr>
                    <td><?= htmlspecialchars($usr['username']) ?></td>
                    <td><?= $usr['is_admin'] == 1 ? 'Yes' : 'No' ?></td>
                    <td>
                        <?php if ($usr['profile_image_url']): ?>
                            <img src="<?= $usr['profile_image_url'] ?>" alt="Profile Image" style="width: 50px; height: 50px; border-radius: 50%;">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>
                    <td>
                        <a class="btn-edit" href="edit_user.php?id=<?= $usr['id'] ?>">Edit</a> 
                        <a class="btn-delete" href="delete_user.php?id=<?= $usr['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <script src="/FCDS/js/my_js.js"></script>
    <script>

                document.getElementById('profile_image').addEventListener('change', function (event) {
                    const preview = document.getElementById('preview');
                    const file = event.target.files[0];

                    if (file) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            preview.src = e.target.result; // Update the image source to the selected file
                        };

                        reader.readAsDataURL(file); // Read the file as a data URL
                    }
                });


                document.querySelector('form').addEventListener('submit', function (event) {
                const passwordInput = document.querySelector('input[name="password"]');
                const errorMessage = document.getElementById('error-message');

                if (passwordInput.value.length < 6) {
                    event.preventDefault(); // Prevent form submission

                    // Update the existing error message and display it
                    errorMessage.textContent = 'Password must be at least 6 characters long.';
                    errorMessage.style.display = 'block';
                } else {
                    // Hide the error message if the password is valid
                    errorMessage.style.display = 'none';
                }
            });




    </script>
</body>
</html>
