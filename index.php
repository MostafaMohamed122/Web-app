<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Tech</title>
    <link rel="stylesheet" href="css/styles.css">
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
.video-container {
    position: relative;
    width: 50%;
    max-width: 800px;
    border: 5px solid #007BFF;
    border-radius: 15px;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    overflow: hidden;
}

video {
    width: 100%;
    height: auto;
    border-radius: 10px;
    margin-bottom: -8px;
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

    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Management Panel</h1>
                <p>Welcome to our Management Panel! This panel provides you with powerful tools and features to manage
                    operations, users, and content easily and efficiently. The Management Panel allows you to:</p>
                <button class="btn-learn-more" onclick="window.location.href='#features';">Learn More</button>

            </div>
            <div class="video-container">
                <video src="\FCDS\image\video.mp4" autoplay loop muted></video>
            </div>
        </div>
    </section>

    <section class="why-choose-us">
        <div class="container">
            <h2>Why You Choose Us?</h2>
            <div class="features-grid">
                <div class="feature-item">
                    <img src="image/Vectors1.png" alt="Support Icon">
                    <h3>User Management</h3>
                    <p>Add new users, update existing user information, and remove inactive users.</p>
                </div>
                <div class="feature-item">
                    <img src="image/Vectorss.png" alt="Save Time Icon">
                    <h3>Content Management</h3>
                    <p>Create, edit, and delete content easily, including articles, posts, and files.</p>
                </div>
                <div class="feature-item">
                    <img src="image/Vectors3.png" alt="Reliable Icon">
                    <h3>Statistics and Reports</h3>
                    <p>Get detailed reports and statistics on site performance, users, and content.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <div class="container">
            <h2>Features</h2>
            <p class="features-description">
                Our Management Panel ensures a simple and user-friendly interface, allowing you to focus on what truly
                matters: managing your operations efficiently and achieving your goals.
            </p>
            <div class="features-grid">
                <div class="feature">
                    <img src="image/D1.jpg" alt="AI Report Generation">
                    <h3>Intuitive Dashboard</h3>
                    <p>A user-friendly dashboard that provides quick access to key functions and metrics.</p>
                </div>
                <div class="feature">
                    <img src="image/D2.jpg" alt="Patient Result Portal">
                    <h3>Role-Based Access Control</h3>
                    <p>Define roles and permissions to ensure users have access to only the features they need.</p>
                </div>
                <div class="feature">
                    <img src="image/D3.jpg" alt="Real-Time Chatbot Assistance">
                    <h3>Automated Notifications</h3>
                    <p>Set up automated email or SMS notifications for various events and actions.</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2024 Lab Tech. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>