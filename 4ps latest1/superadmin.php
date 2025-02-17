<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: superadmin.php");
    exit();
}

// Retrieve user details from session
$name = $_SESSION['name'] ?? 'N/A';
$role = $_SESSION['role'] ?? 'N/A';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>
    <link rel="stylesheet" href="superadmin.css">
    <style>
        .active-member {
            background-color: #d4f7d4;
        }

        .inactive-member {
            background-color: #f7d4d4;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>4Ps Super Admin</h2>
            <div class="profile-picture-container">
             
            <h3 style="color:white">Hello! <?php echo htmlspecialchars($name); ?></h3>
            </div>
            <nav>
                <ul>
                    <li><a href="#" class="active">Dashboard</a></li>
                    <li><a href="adminsidemm.php">Manage Members</a></li>
                    <li><a href="adminsidemeeting.php">Meeting</a></li>
                    <li><a href="adminsideupdates.php">FDS Updates</a></li>
                    <li><a href="admin regform.php">Register New Admin</a></li>
                    <li><a href="sup-attendance.php"> Attendance Management</a></li>
                    <li><a href="index.php">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Super Admin Dashboard</h1>
                <p>Welcome, Super Admin! Manage the system and track the progress of the 4Ps program.</p>
            </header>

            <!-- Overview Section -->
            <section class="overview-section">
                <div class="card" onclick="showMembers('all')">
                    <h3>4Ps Total Members</h3>
                    <p id="totalMembers">0</p>
                </div>
                <div class="card" onclick="showMembers('active')">
                    <h3>Active Members</h3>
                    <p id="activeMembers">0</p>
                </div>
                <div class="card" onclick="showMembers('inactive')">
                    <h3>Inactive Members</h3>
                    <p id="inactiveMembers">0</p>
                </div>
                <div class="card">
                    <h3>Admin Members</h3>
                    <p id="adminMembers">0</p>
                </div>
                <div class="card">
                    <h3>Meeting Updates</h3>
                    <p id="Meeting">0</p>
                </div>
                <div class="card">
                    <h3>Fds Update</h3>
                    <p id="newUpdates">0</p>
                </div>
            </section>

            <!-- Table Section -->
            <section class="table-section">
                <h2>Registered Members List</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Family Size</th>
                            <th>ID Number</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="dashboardMembersList">
                        <?php
                        // Database connection
                        $host = 'localhost';
                        $dbname = '4ps_system';
                        $username = 'root';
                        $password = '';

                        try {
                            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            // Fetch members with role = 'user'
                            $stmt = $pdo->prepare("SELECT * FROM `user` WHERE `role` = 'user'");
                            $stmt->execute();
                            $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Fetch admin count
                            $adminStmt = $pdo->prepare("SELECT COUNT(*) as admin_count FROM `user` WHERE `role` = 'admin'");
                            $adminStmt->execute();
                            $adminCount = $adminStmt->fetch(PDO::FETCH_ASSOC)['admin_count'];

                            // Display members in the table
                            foreach ($members as $member) {
                                $rowClass = $member['status'] === 'active' ? 'active-member' : 'inactive-member';
                                echo "<tr class='$rowClass'>";
                                echo "<td>" . htmlspecialchars($member['name']) . "</td>";
                                echo "<td>" . htmlspecialchars($member['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($member['mobile']) . "</td>";
                                echo "<td>" . htmlspecialchars($member['address']) . "</td>";
                                echo "<td>" . htmlspecialchars($member['family_size']) . "</td>";
                                echo "<td>" . htmlspecialchars($member['id_number']) . "</td>";
                                echo "<td>" . htmlspecialchars(ucfirst($member['status'])) . "</td>";
                                echo "</tr>";
                            }
                        } catch (PDOException $e) {
                            echo "<tr><td colspan='7'>Error fetching members: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dashboard totals
            const totalMembersElem = document.getElementById('totalMembers');
            const activeMembersElem = document.getElementById('activeMembers');
            const inactiveMembersElem = document.getElementById('inactiveMembers');
            const adminMembersElem = document.getElementById('adminMembers');
            const fdsUpdatesElem = document.getElementById('newUpdates'); // Ensure this element ID matches your HTML
            const Meeting = document.getElementById('Meeting')
            // PHP values to JS variables
            const totalMembers = <?= count($members); ?>;
            const activeMembers = <?= count(array_filter($members, fn($m) => $m['status'] === 'active')); ?>;
            const inactiveMembers = <?= count(array_filter($members, fn($m) => $m['status'] === 'inactive')); ?>;
            const adminMembers = <?= $adminCount; ?>;

            // Fetch updates count from localStorage
            const updates = JSON.parse(localStorage.getItem('updates')) || [];
            const updatesCount = updates.length;
            const meeting = JSON.parse(localStorage.getItem('meetings')) || [];
            const updateMeetings = meeting.length

            // Update the dashboard cards
            totalMembersElem.textContent = totalMembers;
            activeMembersElem.textContent = activeMembers;
            inactiveMembersElem.textContent = inactiveMembers;
            adminMembersElem.textContent = adminMembers;
            fdsUpdatesElem.textContent = updatesCount; // Updates the FDS Updates card
            Meeting.textContent = updateMeetings
        });

        function showMembers(status) {
            const rows = document.querySelectorAll('#dashboardMembersList tr');
            rows.forEach(row => {
                if (status === 'all') {
                    row.classList.remove('hidden');
                } else if (status === 'active') {
                    row.classList.toggle('hidden', !row.classList.contains('active-member'));
                } else if (status === 'inactive') {
                    row.classList.toggle('hidden', !row.classList.contains('inactive-member'));
                }
            });
        }
    </script>
</body>

</html>