





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage 4Ps Members</title>
    <link rel="stylesheet" href="adminsidemm.css">
    <style>
        .blink {
            animation: blinkAnimation 1s steps(5, start) 2;
            background-color: blue;
            color: white;
        }

        @keyframes blinkAnimation {
            50% {
                background-color: transparent;
                color: black;
            }
        }



        .modal {
            display: none;
            position: fixed;
            z-index: 10;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            width: 50%;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .close {
            color: #333;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: red;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .modal-header h2 {
            margin: 0;
        }

        .modal-body {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .modal-body label {
            font-weight: bold;
        }

        .modal-body input,
        .modal-body select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .modal-footer button {
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-footer .btn-save {
            background-color: #4CAF50;
            color: white;
        }

        .modal-footer .btn-save:hover {
            background-color: #45a049;
        }

        .modal-footer .btn-cancel {
            background-color: #f44336;
            color: white;
        }

        .modal-footer .btn-cancel:hover {
            background-color: #e53935;
        }

        /* Edit Button Styles */
        .btn-edit {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-edit:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside style="height: 100vh;" class="sidebar">
            <h2 class="am-mmdash">4Ps Super Admin</h2>
            <nav>
                <ul>
                    <li><a href="superadmin.php">Dashboard</a></li>
                    <li><a href="adminsidemm.php" class="active">Manage Members</a></li>
                    <li><a href="adminsidemeeting.php">Meeting</a></li>
                    <li><a href="adminsideupdates.php">FDS Updates</a></li>
                    <li><a href="admin regform.php">Register New Admin</a></li>
                    <li><a href="sup-attendance.php"> Attendance</a></li>
                    <li><a href="index.php">Logout</a></li>
                </ul>
            </nav>
        </aside>
    </div>

    <div class="container">
        <h1>Add and Manage 4Ps Members</h1>


        <div class="reg-div">
        <h2>4Ps Member Registration</h2>

        <?php

if (isset($_SESSION['error'])) {
    echo '<p class="error-message">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    echo '<p style="color:green; text-align:center;">' . $_SESSION['success'] . '</p>';
    unset($_SESSION['success']);
}
?>

        <form id="addMemberForm" class="add-member-form" action="connectdbs.php" method="POST" enctype="multipart/form-data">
            <label for="username">Name:</label>
            <input type="text" id="username" name="name" required>

            <label for="username">Member Name:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="mobile">Mobile Number:</label>
            <input type="number" id="mobile" name="mobile" pattern="[0-9]{11}" required>

            <label for="id-number">ID Number:</label>
            <input type="text" id="id-number" name="id_number" required>

            <label for="address">Address:</label>
            <select id="address" name="address" required>
                <option value="" disabled selected>Select your address</option>
                <option value="purok 1">Purok 1</option>
                <option value="purok 2">Purok 2</option>
                <option value="purok 3">Purok 3</option>
                <option value="purok 4">Purok 4</option>
                <option value="purok 5">Purok 5</option>
                <option value="purok 6">Purok 6</option>
                <option value="purok 7">Purok 7</option>
                <option value="purok Siete Media">Siete Media</option>
            </select>

            <label for="family-size">Family Size:</label>
            <input type="number" id="family-size" name="family_size" min="1" required>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>



            <label for="password">Password:</label>
            <div class="password-container">
                <input type="password" id="password" name="password" required>
                <span id="togglePassword" class="toggle-password"></i></span>
            </div>

            <label for="confirmPassword">Confirm Password:</label>
            <div class="password-container">
                <input type="password" id="confirmPassword" name="confirmPassword" required>
                <span id="toggleConfirmPassword" class="toggle-password" ></span>
            </div>
            <span id="passwordMessage" class="error-message"></span>



            <div class="buttons">
                <button type="reset">Reset</button>
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>

        <!-- Search Bar -->
        <div class="search-container">
            <label for="searchMember">Search Member:</label>
            <input type="text" id="searchMember" placeholder="Enter member name or ID" oninput="searchMember()">
        </div>

        <!-- Members List -->
        <h3>Members List</h3>
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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="membersList">
                <?php
                $pdo = new PDO("mysql:host=localhost;dbname=4ps_system", "root", "");
                $stmt = $pdo->query("SELECT * 
FROM user 
WHERE archive = 0 
  AND role NOT IN ('admin', 'super admin');
");
                foreach ($stmt as $row) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>" . htmlspecialchars($row['mobile']) . "</td>
                        <td>" . htmlspecialchars($row['address']) . "</td>
                        <td>" . htmlspecialchars($row['family_size']) . "</td>
                        <td>" . htmlspecialchars($row['status']) . "</td>
                        <td>" . htmlspecialchars($row['id_number']) . "</td>
                        <td><button class='btn-edit' onclick='openEditModal(" . json_encode($row) . ")'>Edit</button></td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <h1>Archive 4Ps Members</h1>
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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="membersList">
                <?php
                $pdo = new PDO("mysql:host=localhost;dbname=4ps_system", "root", "");
                $stmt = $pdo->query("SELECT * FROM user WHERE archive = 1");
                foreach ($stmt as $row) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>" . htmlspecialchars($row['mobile']) . "</td>
                        <td>" . htmlspecialchars($row['address']) . "</td>
                        <td>" . htmlspecialchars($row['family_size']) . "</td>
                        <td>" . htmlspecialchars($row['status']) . "</td>
                        <td>" . htmlspecialchars($row['id_number']) . "</td>
                        <td><button class='btn-edit' onclick='openEditModal(" . json_encode($row) . ")'>Edit</button></td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Member</h2>
                <span class="close" onclick="closeEditModal()">&times;</span>
            </div>
            <form id="editForm" action="userUpdate.php" method="POST">
                <div class="modal-body">
                    <!-- Hidden ID field -->
                    <input type="hidden" id="editId" name="editId">

                    <!-- Name -->
                    <label for="editName">Name:</label>
                    <input type="text" id="editName" name="editName" required>

                    <!-- Email -->
                    <label for="editEmail">Email:</label>
                    <input type="email" id="editEmail" name="editEmail" required>

                    <!-- Mobile -->
                    <label for="editMobile">Mobile:</label>
                    <input type="text" id="editMobile" name="editMobile" required>

                    <!-- Address -->
                    <label for="editAddress">Address:</label>
                    <input type="text" id="editAddress" name="editAddress" required>

                    <!-- Family Size -->
                    <label for="editFamilySize">Family Size:</label>
                    <input type="number" id="editFamilySize" name="editFamilySize" required>

                    <!-- Status -->
                    <label for="editStatus">Status:</label>
                    <select id="editStatus" name="editStatus">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>

                    <!-- Archive Action -->
                    <label for="editArchiveStatus">Update Account Status:</label>
                    <select id="editArchiveStatus" name="editArchiveStatus">
                        <option value="Archive">Archive</option>
                        <option value="Restore">Restore</option>
                    </select>

                    <!-- ID Number (readonly) -->
                    <label for="editIdNumber">ID Number:</label>
                    <input type="text" id="editIdNumber" name="editIdNumber" readonly>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn-save">Save Changes</button>
                </div>
            </form>

        </div>
    </div>

    <script>
        const editModal = document.getElementById('editModal');

        function openEditModal(member) {
            document.getElementById('editId').value = member.id_number; // Use 'id_number' from the database
            document.getElementById('editName').value = member.name;
            document.getElementById('editEmail').value = member.email;
            document.getElementById('editMobile').value = member.mobile;
            document.getElementById('editAddress').value = member.address;
            document.getElementById('editFamilySize').value = member.family_size;
            document.getElementById('editStatus').value = member.status;
            document.getElementById('editArchiveStatus').value = member.archive === 1 ? 'Archive' : 'Restore';
            document.getElementById('editIdNumber').value = member.id_number;
            editModal.style.display = 'flex';
        }


        function closeEditModal() {
            editModal.style.display = 'none';
        }

        function searchMember() {
            const searchTerm = document.getElementById('searchMember').value.toLowerCase();
            const rows = document.querySelectorAll('#membersList tr');

            rows.forEach(row => {
                const name = row.cells[0].textContent.toLowerCase();
                const idNumber = row.cells[6].textContent.toLowerCase();
                if (name.includes(searchTerm) || idNumber.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }








        const toggleVisibility = (toggleElement, targetField) => {
            const icon = toggleElement.querySelector('i');
            if (targetField.type === 'password') {
                targetField.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                targetField.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        };

        document.getElementById('togglePassword').addEventListener('click', () => {
            toggleVisibility(document.getElementById('togglePassword'), document.getElementById('password'));
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', () => {
            toggleVisibility(document.getElementById('toggleConfirmPassword'), document.getElementById('confirmPassword'));
        });

        document.getElementById('mobile').addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 11);
        });

        document.getElementById('id-number').addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 12);
        });
        
        document.getElementById('family-size').addEventListener('input', function() {
            const value = parseInt(this.value.replace(/\D/g, ''), 10);
            this.value = value > 0 && value <= 25 ? value : '';
        });

        
    </script>
</body>

</html>