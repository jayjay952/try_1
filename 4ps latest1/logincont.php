<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "4ps_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password' AND status = 'active'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Role-based redirection
        switch ($user['role']) {
            case 'user':
                header("Location: userpagehome.html");
                break;
            case 'admin':
                header("Location: secadmin.html");
                break;
            case 'superadmin':
                header("Location: superadmin.html");
                break;
            default:
                echo "<script>alert('Unknown role.'); window.location.href='index.html';</script>";
        }
    } else {
        echo "<script>alert('Invalid credentials or account inactive.');
         window.location.href='index.html';</script>";
    }
}

$conn->close();
?>
