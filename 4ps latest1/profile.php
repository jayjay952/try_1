<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: profile.php");
    exit();
}

// Retrieve user details from session
$id = $_SESSION['user_id'];
$name = $_SESSION['name'] ?? 'N/A';
$email = $_SESSION['email'] ?? 'N/A';
$username = $_SESSION['username'] ?? 'N/A';
$mobile = $_SESSION['mobile'] ?? 'N/A';
$address = $_SESSION['address'] ?? 'N/A';
$family_size = $_SESSION['family_size'] ?? 'N/A';
$id_number = $_SESSION['id_number'] ?? 'N/A';
$status = $_SESSION['status'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Page</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            animation: slide-down 0.3s ease-in-out;
        }

        @keyframes slide-down {
            from {
                transform: translateY(-50%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal form {
            display: flex;
            flex-direction: column;
        }

        .modal form label {
            margin-top: 10px;
            font-weight: bold;
        }

        .modal form input,
        .modal form button {
            margin-top: 5px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .modal form button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }

        .modal form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="header-mother-div">
        

        <div class="header-div2"style=" text-align: center;
        color:rgb(255, 255, 140);
        font-size: 50px;
        margin-top: 50px;
        margin-left:-100px">
            <h1>PANTAWID PAMILYANG PILIPINO PROGRAM</h1>
            <div class="logo-pic">
                <a href="userpagehome.php"> <img class="pic" src="4ps-logo.png" alt="" style="margin-right: -18px;"> </a>
            </div>
        </div>
    </div>

    <br><br><br>

    <div class="icon-div">
        <div class="icon">
            <a href="userpagehome.php"><button class="home-button"><i class="fa-solid fa-house"></i> Home </button></a>
        </div>

        <div class="icon">
            <a href="usersidemeeting.php"><button><i class="fa-solid fa-users-line"></i> Meeting </button></a>
        </div>

        <div class="icon">
            <a href="usersideupdates.php"><button class="update-button"><i class="fa-solid fa-volume-high"></i>FDS Update </button></a>
        </div>

        <div class="icon">
            <a href=""><button class="account-button"><i class="fa-solid fa-user"></i> Profile </button></a>
        </div>
    </div>

    <br><br>

    <div class="profile-container">
        <h2>User Profile</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($mobile); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></p>
        <p><strong>Family Size:</strong> <?php echo htmlspecialchars($family_size); ?></p>
        <p><strong>ID Number:</strong> <?php echo htmlspecialchars($id_number); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($status); ?></p>

        <div>
            <a href="index.php"><button>Log Out</button></a>
            <button id="editProfileBtn">Edit Profile</button>
        </div>
    </div>

    <!-- Modal -->
    <div id="editProfileModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Profile</h2>
            <form id="editProfileForm" action="updateProfile.php" method="POST">
                <!-- Hidden Field for ID -->
                <input type="hidden" id="editId" name="editId" value="<?php echo htmlspecialchars($id); ?>">

                <!-- Name -->
                <label for="name">Name:</label>
                <input type="text" id="name" name="editName" value="<?php echo htmlspecialchars($name); ?>" required>

                <!-- Email -->
                <label for="email">Email:</label>
                <input type="email" id="email" name="editEmail" value="<?php echo htmlspecialchars($email); ?>" required>

                <!-- Mobile -->
                <label for="mobile">Phone:</label>
                <input type="text" id="mobile" name="editMobile" value="<?php echo htmlspecialchars($mobile); ?>" required>

                <!-- Address -->
                <label for="address">Address:</label>
                <input type="text" id="address" name="editAddress" value="<?php echo htmlspecialchars($address); ?>" required>

                <!-- Family Size -->
                <label for="family_size">Family Size:</label>
                <input type="number" id="family_size" name="editFamilySize" value="<?php echo htmlspecialchars($family_size); ?>" readonly>

               

                <!-- ID Number -->
                <label for="id_number">ID Number:</label>
                <input type="text" id="id_number" name="id_number" value="<?php echo htmlspecialchars($id_number); ?>" readonly>

                <!-- Submit Button -->
                <button type="submit">Save Changes</button>
            </form>


        </div>
    </div>

    <script>
        // Function to open and autofill the modal
        function openEditModal(userData) {
            document.getElementById('editId').value = userData.id;
            document.getElementById('name').value = userData.name;
            document.getElementById('email').value = userData.email;
            document.getElementById('mobile').value = userData.mobile;
            document.getElementById('address').value = userData.address;
            document.getElementById('family_size').value = userData.family_size;
            document.getElementById('id_number').value = userData.id_number;

            // Show the modal
            document.getElementById('editProfileModal').style.display = 'block';
        }

        // Function to close the modal
        function closeEditModal() {
            document.getElementById('editProfileModal').style.display = 'none';
        }

        // Attach event listener to the "Edit Profile" button
        document.getElementById('editProfileBtn').addEventListener('click', function() {
            const userData = {
                id: '<?php echo htmlspecialchars($id); ?>',
                id_number: '<?php echo htmlspecialchars($id_number); ?>',
                name: '<?php echo htmlspecialchars($name); ?>',
                email: '<?php echo htmlspecialchars($email); ?>',
                mobile: '<?php echo htmlspecialchars($mobile); ?>',
                address: '<?php echo htmlspecialchars($address); ?>',
                family_size: '<?php echo htmlspecialchars($family_size); ?>',
                status: '<?php echo htmlspecialchars($status); ?>',
            };

            openEditModal(userData);
        });

        // Close modal on click of the "x" button
        document.querySelector('.close').addEventListener('click', closeEditModal);

        // Close modal if clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('editProfileModal');
            if (event.target === modal) {
                closeEditModal();
            }
        };
    </script>

</body>

</html>