<?php
include 'config/db.php';

// Admin credentials to create
$username = 'admin';
$password = 'your_secure_password'; // Change this to your desired password

try {
    // Check if username already exists
    $check = $pdo->prepare("SELECT id FROM admins WHERE username = ?");
    $check->execute([$username]);
    
    if ($check->rowCount() > 0) {
        echo "Error: Username already exists!";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the admin
    $stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $hashed_password]);

    echo "Admin created successfully!";
    echo "<br>Username: " . $username;
    echo "<br>Password: " . $password;
    echo "<br><br>Please delete this file after creating the admin for security reasons.";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?> 