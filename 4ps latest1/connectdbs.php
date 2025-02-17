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
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form inputs
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $id_number = trim($_POST['id_number']);
    $address = trim($_POST['address']);
    $family_size = (int)$_POST['family_size'];
    $status = $_POST['status'];
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate passwords match
    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit();
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Use prepared statements to prevent SQL injection
    $sql = "INSERT INTO user (name, email, mobile, id_number, address, family_size, status, username, password) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param(
            "sssssssss", 
            $name, $email, $mobile, $id_number, $address, $family_size, $status, $username, $hashedPassword
        );

        // Execute the query
        if ($stmt->execute()) {
            echo "Member Registered Successfully!";
            // Redirect to login page after successful registration
            header("Location: adminsidemm.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
            header("Location: index.php");
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $conn->error;
        header("Location: index.php");
    }

    // Close the connection
    $conn->close();
}
?>
