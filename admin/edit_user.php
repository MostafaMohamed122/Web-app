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

// Fetch user data by ID
if (isset($_GET['id'])) {
    $userId = $_GET['id'];  // Use the selected user ID for editing
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
    $usr = $stmt->fetch();
} else {
    // If no user ID is passed, redirect to the manage users page
    header('Location: manage_users.php');
    exit();
}

// Query to get logged-in user details
$currentUserId = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $currentUserId, PDO::PARAM_INT);
$stmt->execute();
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

$is_admin = $currentUser['is_admin'] == 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $isAdmin = isset($_POST['is_admin']) ? 1 : 0;

    // If password is not empty, hash it and include it in the update query
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET username = ?, password = ?, is_admin = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $hashedPassword, $isAdmin, $userId]);
    } else {
        // If password is empty, exclude it from the update query
        $sql = "UPDATE users SET username = ?, is_admin = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $isAdmin, $userId]);
    }


    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        // Get the uploaded file's original path
        $fileTmpPath = $_FILES['profile_image']['tmp_name'];
        $fileName = $_FILES['profile_image']['name'];
        $filePath = 'uploads/' . $fileName;  // Relative path to the 'uploads' directory
    
        // Move the file to the desired location
        $uploadDir = '../uploads/';
        if (move_uploaded_file($fileTmpPath, $uploadDir . $fileName)) {
            // Now insert only the relative path into the database (without the root part)
            $relativeFilePath = '\\FCDS\\uploads\\' . $fileName;
            $user->updateProfileImage($userId, $relativeFilePath); // Pass the file path as a string
        } else {
            // Handle error in case file move fails
            echo "Error uploading file.";
        }
    }
    
    

    // Redirect back after successful update
    header('Location: manage_users.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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
        .form-container input[type="checkbox"] {
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

        <div class="form-container">
            <h2>Edit User</h2>
            <form method="POST" enctype="multipart/form-data">
            <label for="profile_image" style="display: flex; justify-content: center; align-items: center; ">Profile Image</label>

                <!-- Display current profile image if available -->
                <?php if ($usr['profile_image_url']): ?>
                    <div style="display: flex; justify-content: center; align-items: center;">
                        <img src="<?= htmlspecialchars($usr['profile_image_url']) ?>" alt="Current Profile Image" style="width: 400px; height: auto;">
                    </div>
                <?php endif; ?>

            <label for="profile_image"style="display: flex; justify-content: center; align-items: center;"><img src="/FCDS/image/Add Image.png"style="max-width: 400px; hight:auto; display: block;" alt="Upload Photo" id="preview" /></label>
                <input type="file" name="profile_image" id="profile_image" accept="image/*" >

            
                <label for="username">Username</label>
                <input type="text" name="username" value="<?= htmlspecialchars($usr['username']) ?>" required>
                <label for="password">Password</label>
                    <input type="password" id="password" name="password" >
                
                <p id="error-message" style="color: red; display: none;"></p>

                <label for="is_admin" style="display: flex; justify-content: center; align-items: center;">Is Admin</label>
                <input type="checkbox" name="is_admin" <?= $usr['is_admin'] ? 'checked' : '' ?>>

                <button type="submit">Update User</button>
            </form>

        </div>
    </div>
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

            // Only check password length if it's not empty
            if (passwordInput.value.length > 0 && passwordInput.value.length < 6) {
                event.preventDefault(); // Prevent form submission

                // Update the existing error message and display it
                errorMessage.textContent = 'Password must be at least 6 characters long.';
                errorMessage.style.display = 'block';
            } else {
                // Hide the error message if the password is valid or empty
                errorMessage.style.display = 'none';
            }
        });



    </script>
</body>
</html>
