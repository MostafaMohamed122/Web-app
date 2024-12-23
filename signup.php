<?php
session_start();
include_once('config/db.php');
include_once('models/User.php');
$user = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $isAdmin = 0; // Default for normal users

    $user->signUp($username, $password, $isAdmin);
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lab Tech</title>
<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/sign.css">    
<style>
    .navbar .btn-Sign_in {
    padding: 0.5rem 1rem;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.navbar .btn-Sign_up {
    padding: 0.5rem 1rem;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
    </style>
</head>
<body>
<header class="navbar">
        <div class="container">
            <div class="logo">
                <img src="image/logo.png" alt="Lab Tech Logo">
                <span>Lab Tech</span>
            </div>
            <nav>
                <a href="/FCDS/index.php">Home</a>
                <a href="/FCDS/index.php#features">Features</a>
                <a href="/FCDS/contact.html">Contact us</a>
            </nav>
            <div>
                <button class="btn-Sign_up" onclick="window.location.href='signup.php';">Sign Up</button>
                <button class="btn-Sign_in" onclick="window.location.href='login.php';">Sign In</button>
            </div>
        </div>
    </header>

    <div class="container1">
        <!-- Section 1: Welcome -->
        <div class="welcome-section">
            <h1>Welcome to <span>Lab Tech</span></h1>
            <p>
                We are delighted to have you join our community. Lab Tech is dedicated to providing top-notch 
                medical services and support to ensure your health and well-being. Whether you are here for 
                medical consultations, managing your health records, or staying informed about the latest in 
                medical advancements, we are here to assist you every step of the way.
            </p>
        </div>
        <!-- Section 2: Sign up Form -->
        <div class="signin-section">
            <h2>Sign up</h2>
            <form method="POST">
                <div class="input-group">
                    <i class="icon1"></i>
                    <input type="text" name="username" placeholder="      E-mail">
                </div>
                <div class="input-group">
                    <i class="icon2"></i>
                    <input type="password" id="password" name="password" placeholder="      password" required>
                                   
                <p id="error-message" style="color: red; display: none;"></p>
                </div>
                <button type="submit" class="btn">Save</button>
            </form>
        </div>
    </div>
    
    <footer>
        <div class="container">
        <p>&copy; 2024 Lab Tech. All rights reserved.</p>
        </div>
    </footer>

    <script>

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
