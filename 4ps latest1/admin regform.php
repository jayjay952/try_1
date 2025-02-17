<?php
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

// Fetch all admins and super admins from the database
$stmt = $pdo->prepare("SELECT * FROM user WHERE role IN ('admin', 'super admin')");
$stmt->execute();
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="admin regform.css">
    <style>
        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

       
    </style>
</head>

<body>

    <div class="admin-container">
        <aside class="sidebar">
            <h2 class="top-textash">4Ps Super Admin</h2>
            <nav class="dash">
                <ul>
                    <li><a href="superadmin.php">Dashboard</a></li>
                    <li><a href="adminsidemm.php">Manage Members</a></li>
                    <li><a href="adminsidemeeting.php">Meeting</a></li>
                    <li><a href="adminsideupdates.php">FDS Updates</a></li>
                    <li><a href="admin regform.php" class="active">Register New Admin</a></li>
                    <li><a href="sup-attendance.php"> Attendance</a></li>
                    <li><a href="index.php">Logout</a></li>
                </ul>
            </nav>
        </aside>
    </div>

    <div class="container mt-5">
        <h4 class="text-center">Register New Admin</h4>
        <form id="adminRegistrationForm" action="adminRegister.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">User Name</label>
                <input type="text" class="form-control" id="name" name="username" placeholder="Enter full name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
            </div>
            <div class="mb-3 password-container">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                <span style="margin-right: 155px;margin-top:10px" class="toggle-password" onclick="togglePasswordVisibility('password')">&#128065;</span >
            </div>
            <div class="mb-3 password-container">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password" required>
                <span style="margin-right: 155px;margin-top:10px" class="toggle-password" onclick="togglePasswordVisibility('confirm_password')">&#128065;</span>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role">
                    <option value="admin">Admin</option>
                    <option value="super admin">Super Admin</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Register Admin</button>
        </form>


        <div class="admin-list">
        <h2>Registered Admins</h2>
    <table>
        <thead>
            <tr>
                
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($admins) > 0): ?>
                <?php foreach ($admins as $admin): ?>
                    <tr>
                        
                        <td><?= htmlspecialchars($admin['name']) ?></td>
                        <td><?= htmlspecialchars($admin['email']) ?></td>
                        <td><?= htmlspecialchars($admin['role']) ?></td>
                        <td><span class="delete-btn" onclick="deleteAdmin(<?= $admin['id'] ?>)">Delete</span></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No registered admins found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        function deleteAdmin(adminId) {
            if (confirm('Are you sure you want to delete this admin?')) {
                fetch(`deleteAdmin.php?id=${adminId}`, { method: 'GET' })
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            alert('Admin deleted successfully');
                            location.reload(); // Reload the page to update the table
                        } else {
                            alert('Failed to delete admin');
                        }
                    });
            }
        }
    </script>

</body>

</html>