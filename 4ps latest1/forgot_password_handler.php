<?php
// forgot_password_handler.php

// Database connection
$host = 'localhost';
$dbname = '4ps_system';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if email exists in the database
        $stmt = $pdo->prepare("SELECT id FROM members WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Generate a unique token
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Insert or update the token in the database
            $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expiry) VALUES (:email, :token, :expiry)
                                  ON DUPLICATE KEY UPDATE token = :token, expiry = :expiry");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':expiry', $expiry);
            $stmt->execute();

            // Send reset email
            $resetLink = "http://yourdomain.com/reset_password.php?token=$token";
            $subject = "Password Reset Request";
            $message = "Click the link below to reset your password:\n$resetLink\n\nThis link will expire in 1 hour.";
            $headers = "From: no-reply@yourdomain.com";

            if (mail($email, $subject, $message, $headers)) {
                echo "A password reset link has been sent to your email.";
            } else {
                echo "Failed to send the reset email. Please try again later.";
            }
        } else {
            echo "No account found with that email address.";
        }
    } else {
        echo "Invalid email address.";
    }
} else {
    echo "Invalid request method.";
}

?>
