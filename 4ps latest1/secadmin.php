<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
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
    <title>Sec Admin Dashboard</title>
    <link rel="stylesheet" href="secadmin.css">
    <style>
        .admin-profile {
            display: flex;
            align-items: center;
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
        }

        .profile-pic {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }

        .profile-info h3 {
            margin: 0;
            font-size: 1.2em;
            color: #333;
        }

        .profile-info p {
            margin: 0;
            font-size: 0.9em;
            color: #777;
        }

        .card {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .active-member {
            background-color: #d4f7d4;
        }

        .inactive-member {
            background-color: #f7d4d4;
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>4Ps Admin</h2>
            <div class="admin-profile">
                
                <div class="profile-info">
                    <h3 style="color:white"><?php echo htmlspecialchars($name); ?></h3>

                </div>
            </div>
            <nav>
                <ul>
                    <li><a href="#" class="active">Dashboard</a></li>
                    <li><a href="secadmin-meeting.php">Meeting Updates</a></li>
                    <li><a href="secadmin-update.php">FDS Updates</a></li>
                    <li><a href="index.php">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Admin Dashboard</h1>
                <p>Welcome, Admin! Manage the system and track the progress of the 4Ps program.</p>
            </header>

            <!-- Overview Section -->
            <section class="overview-section">
                <div class="card">
                    <h3>4Ps Total Members</h3>
                    <p id="totalMembers"></p>
                </div>
                <div class="card">
                    <h3>Active Members</h3>
                    <p id="activeMembers"></p>
                </div>
                <div class="card">
                    <h3>Inactive Members</h3>
                    <p id="inactiveMembers"></p>
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

                            // Fetch all members
                            $stmt = $pdo->prepare("SELECT * FROM `user` WHERE `role` = 'user'");
                            $stmt->execute();
                            $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            $totalMembers = count($members);
                            $activeMembers = count(array_filter($members, fn($m) => $m['status'] === 'active'));
                            $inactiveMembers = $totalMembers - $activeMembers;

                            // Echo totals for JavaScript
                            echo "<script>
                                const totalMembers = $totalMembers;
                                const activeMembers = $activeMembers;
                                const inactiveMembers = $inactiveMembers;
                            </script>";

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
        // Update totals dynamically
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('totalMembers').textContent = totalMembers;
            document.getElementById('activeMembers').textContent = activeMembers;
            document.getElementById('inactiveMembers').textContent = inactiveMembers;

            const fdsUpdatesElem = document.getElementById('newUpdates'); // Ensure this element ID matches your HTML
            const Meeting = document.getElementById('Meeting')

            const updates = JSON.parse(localStorage.getItem('updates')) || [];
            const updatesCount = updates.length;
            const meeting = JSON.parse(localStorage.getItem('meetings')) || [];
            const updateMeetings = meeting.length


            fdsUpdatesElem.textContent = updatesCount; // Updates the FDS Updates card
            Meeting.textContent = updateMeetings
        });
    </script>
</body>

</html>