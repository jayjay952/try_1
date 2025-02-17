<?php
session_start();

$host = 'localhost';
$dbname = '4ps_system';
$username = 'root';
$password = '';

try {
    // Establish a connection to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username_input = trim($_POST['username']);
        $password_input = $_POST['password'];

        // Check if the user exists
        $stmt = $pdo->prepare("
            SELECT id, name, email, username, password, status, mobile, address, family_size, id_number, role 
            FROM user 
            WHERE username = ?
        ");
        $stmt->execute([$username_input]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Check if status is inactive
            if ($user['status'] === 'inactive') {
                header("Location: oops.html");
                exit();
            }

            // Verify the password
            if (password_verify($password_input, $user['password'])) {
                // Successful login
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['status'] = $user['status'];
                $_SESSION['mobile'] = $user['mobile'];
                $_SESSION['address'] = $user['address'];
                $_SESSION['family_size'] = $user['family_size'];
                $_SESSION['id_number'] = $user['id_number'];
                $_SESSION['role'] = $user['role'];

                // Redirect based on the user's role
                switch ($_SESSION['role']) {
                    case 'super admin':
                        header("Location: superadmin.php");
                        break;
                    case 'admin':
                        header("Location: secadmin.php");
                        break;
                    case 'user':
                        header("Location: userpagehome.php");
                        break;
                    default:
                        $_SESSION['error'] = "Invalid role. Please contact the administrator.";
                        header("Location: index.php");
                }
                exit();
            }
        }
    }
} catch (PDOException $e) {
    // Log the error for debugging (optional)
    error_log("Database error: " . $e->getMessage());
}

// Redirect back to the login page if login fails
header("Location: index.php");
exit();
