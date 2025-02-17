<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password is empty
$dbname = "4ps_system"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is sent
if ($_SERVER["REQUEST_METHOD"] || "POST") {
    // Retrieve form inputs
    $fullName = trim($_POST['name']);
    $userName = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Validate required fields
    if (empty($fullName) || empty($userName) || empty($email) || empty($password) || empty($confirmPassword) || empty($role)) {
        die("All fields are required.");
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Validate passwords match
    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if username already exists
    $checkUsernameSql = "SELECT id FROM user WHERE username = ?";
    $checkStmt = $conn->prepare($checkUsernameSql);
    if ($checkStmt) {
        $checkStmt->bind_param("s", $userName);
        $checkStmt->execute();
        $checkStmt->store_result();
        if ($checkStmt->num_rows > 0) {
            die("Username is already taken.");
        }
        $checkStmt->close();
    } else {
        die("Error checking username: " . $conn->error);
    }

    // Check if email already exists
    $checkEmailSql = "SELECT id FROM user WHERE email = ?";
    $checkStmt = $conn->prepare($checkEmailSql);
    if ($checkStmt) {
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();
        if ($checkStmt->num_rows > 0) {
            die("Email is already registered.");
        }
        $checkStmt->close();
    } else {
        die("Error checking email: " . $conn->error);
    }

    // Use prepared statements to prevent SQL injection
    $sql = "INSERT INTO userr (name, username, email, password, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssss", $fullName, $userName, $email, $hashedPassword, $role);

        // Execute the query
        if ($stmt->execute()) {
            echo "Admin Registered Successfully!";
            // Redirect to a confirmation page or login page
            header("Location: admin regform.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        die("Error preparing the statement: " . $_stmt->error);
    }

    // Close the connection
    $conn->close();
} else {
    die("Invalid request method.");
}
?>
