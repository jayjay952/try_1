<?php
// Database connection
$pdo = new PDO("mysql:host=localhost;dbname=4ps_system", "root", "");

// Handle form submission to update attendance and status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $memberId = $_POST['member_id'];
    $attendanceCount = isset($_POST['attendance']) ? count($_POST['attendance']) : 0;

    // Determine the status based on attendance
    $newStatus = $attendanceCount >= 3 ? 'Inactive' : 'Active';

    // Update the status in the database
    $stmt = $pdo->prepare("UPDATE user SET status = :status WHERE id = :id");
    $stmt->execute(['status' => $newStatus, 'id' => $memberId]);

    header("Location: sup-attendance.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <style>
        /* Reset default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }

        h1, h2, h3 {
            color: #2c3e50;
            margin-bottom: 15px;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #34495e;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar h2.am-mmdash {
            color: #ecf0f1;
            font-size: 24px;
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar nav ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar nav ul li {
            margin: 10px 0;
        }

        .sidebar nav ul li a {
            color: #ecf0f1;
            text-decoration: none;
            font-size: 18px;
            display: block;
            padding: 10px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .sidebar nav ul li a:hover, .sidebar nav ul li a.active {
            background-color: #1abc9c;
        }

        /* Main content area */
        .container {
            margin-left: 270px;
            padding: 40px;
            max-width: 100%;
        }

        .container h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        /* Success and error messages */
        p {
            font-size: 14px;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        p.success {
            color: green;
            background-color: #dff0d8;
        }

        p.error {
            color: red;
            background-color: #f2dede;
        }

        /* Attendance Table */
        .attendance-table-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .attendance-table-container h3 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #34495e;
            color: #fff;
            font-size: 16px;
        }

        table td {
            font-size: 14px;
        }

        table tr:hover {
            background-color: #ecf0f1;
        }

        button {
            background-color: #1abc9c;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #16a085;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <h2 class="am-mmdash">4Ps Super Admin</h2>
        <nav>
            <ul>
                <li><a href="superadmin.php">Dashboard</a></li>
                <li><a href="adminsidemm.php">Manage Members</a></li>
                <li><a href="adminsidemeeting.php">Meeting</a></li>
                <li><a href="adminsideupdates.php">FDS Updates</a></li>
                <li><a href="admin regform.php">Register New Admin</a></li>
                <li><a href="sup-attendance.php" class="active">Attendance </a></li>
                <li><a href="index.php">Logout</a></li>
            </ul>
        </nav>
    </aside>


    <div class="container">
        <h1>Attendance</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Mark Attendance</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch all members
                $stmt = $pdo->query("SELECT * FROM user WHERE archive = 0 AND role NOT IN ('admin', 'super admin')");
                foreach ($stmt as $row) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td id='status_" . $row['id'] . "'>" . htmlspecialchars($row['status']) . "</td>
                        <td>
                            <form action='' method='POST'>
                                <input type='hidden' name='member_id' value='" . $row['id'] . "'>
                                <input type='checkbox' name='attendance[]' value='1'> Absence 1
                                <input type='checkbox' name='attendance[]' value='2'> Absence 2
                                <input type='checkbox' name='attendance[]' value='3'> Absence 3
                                <button type='submit'>Update</button>
                            </form>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    
    
</body>
</html>
