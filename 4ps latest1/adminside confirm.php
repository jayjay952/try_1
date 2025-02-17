<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Confirm</title>
    <link rel="stylesheet" href="adminside-confirm.css">
    <style>
        
        
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>4Ps Super Admin</h2>
            <nav>
                <ul>
                    <li><a href="superadmin.php">Dashboard</a></li>
                    <li><a href="adminsidemm.php">Manage Members</a></li>
                    <li><a href="adminsidemeeting.php">Meeting</a></li>
                    <li><a href="adminsideupdates.php">FDS Updates</a></li>
                    <li><a href="adminside 4psmm dashboard.php">4Ps Members Dashboard</a></li>
                    <li><a href="admin regform.php">Register New Admin</a></li>
                    <li><a href="" class="active">Confirm Changes</a></li>
                    <li><a href="homepagelogin.php">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Content Area -->
        <div class="content">
            <h1>Confirm Changes</h1>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Address</th>
                        <th>Family Size</th>
                        <th>Status</th>
                        <th>ID Number</th>
                        <th>Profile Picture</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <h3>List of members with changes in information</h3>
                        <td>John Doe</td>
                        <td>johndoe@example.com</td>
                        <td>1234567890</td>
                        <td>Sitio Ilaya</td>
                        <td>5</td>
                        <td>Active</td>
                        <td>20231234</td>
                        <td><img src="profile.jpg" alt="Profile Picture" width="50"></td>
                        <td class="action-buttons">
                            <button class="edit-btn">accep</button>
                            <button class="delete-btn">Deny</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
