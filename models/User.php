<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function signUp($username, $password, $isAdmin, $profileImageUrl = null) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // Insert the user into the database, including the profile image URL
        $sql = "INSERT INTO users (username, password, is_admin, profile_image_url) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username, $hashedPassword, $isAdmin, $profileImageUrl]);
    
        echo "User inserted into the database.<br>";
    }
    
         
    
    public function signIn($username, $password) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function isAdmin($userId) {
        $sql = "SELECT is_admin FROM users WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        return $user['is_admin'] == 1;
    }

    public function getUserById($userId) {
        $query = "SELECT * FROM users WHERE id = :user_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfileImage($userId, $filePath)
{
    // Ensure that file path is properly handled as a string
    if (is_string($filePath)) {
        $sql = "UPDATE users SET profile_image_url = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$filePath, $userId]);
    } else {
        // Handle error if the file path is not a string
        throw new Exception('Invalid file path.');
    }
}

       
}
?>
