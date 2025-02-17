<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sec admin-mm</title>
    <link rel="stylesheet" href="secadmin-mm.css">
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <h2 class="am-mmdash">4Ps Admin</h2>
            <nav>
                <ul>
                    <li><a href="secadmin.php">Dashboard</a></li>
                    <li><a href="" class="active">Manage Members</a></li>
                    <li><a href="secadmin-meeting.php">Meeting Updates</a></li>
                    <li><a href="secadmin-update.php">FDS Updates </a></li>
                    <li><a href="secadmin-4ps-dashboard.php">4Ps Members Dashboard</a></li>
                    <li><a href="homepagelogin.php">Logout</a></li>
                </ul>
            </nav>
        </aside>
    </div>

    <div class="container">
        <h1>Add and Manage 4Ps Members</h1>
       <!-- Add Member Form -->
       <form id="addMemberForm" class="add-member-form">
        <label for="name">Member Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="mobile">Mobile Number:</label>
        <input type="tel" id="mobile" name="mobile" pattern="[0-9]{11}" required>
        
        <label for="id-number">ID Number:</label>
        <input type="text" id="id-number" name="id_number" required>
        
        <label for="address">Address:</label>
        <select id="address" name="address" required>
            <option value="" disabled selected>Select your address</option>
            <option value="Sitio Basurahan">brgy parian Sitio Basurahan</option>
            <option value="Sitio Gulod">brgy parian Sitio Gulod</option>
            <option value="Sitio Ilaya">brgy parian Sitio Ilaya</option>
            <option value="Sitio Kawayanan">brgy parian Sitio Kawayanan</option>
            <option value="Sitio Putol">brgy parian Sitio Putol</option>
            <option value="Villa Carpio">brgy parian Villa Carpio</option>
            <option value="Lazaro">brgy parian Lazaro</option>
            <option value="Farcon Ville">brgy parian Farcon Ville</option>
            <option value="Santa Cecilia">brgy parian Santa Cecilia</option>
        </select>
        
        <label for="family-size">Family Size:</label>
        <input type="number" id="family-size" name="family_size" min="1" required>
        
        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
        
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <div style="position: relative;">
            <input type="password" id="password" name="password" required>
            <span id="togglePassword" style="position: absolute; left: 190px; top: 5px; cursor: pointer;">👁️</span>
        </div>

        <label for="confirmPassword">Confirm Password:</label>
        <div style="position: relative;">
            <input type="password" id="confirmPassword" name="confirmPassword" required>
            <span id="toggleConfirmPassword" style="position: absolute; left: 190px; top: 5px; cursor: pointer;">👁️</span>
        </div>
        <span id="passwordMessage" style="color: red; font-size: small;"></span>

        <!-- Profile Picture Upload -->
        <label for="profile-picture">Choose Profile Picture:</label>
        <input type="file" id="profile-picture" name="profile-picture" accept="image/*">
        <img id="profile-preview" class="profile-img" src="" alt="Profile Preview" style="display: none;">
        
        <button type="submit">Add Member</button>
    </form>

        <h3>Members List</h3>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>4Ps ID number</th>
                    <th>Address</th>
                    <th>Family Size</th>
                    <th>Status</th>
                    <th>Profile Picture</th>
                </tr>
            </thead>
            <tbody id="membersList"></tbody>
        </table>
    </div>

    <script>
        const form = document.getElementById('addMemberForm');
        const membersList = document.getElementById('membersList');

        // Password toggle visibility function for password field
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');
        togglePassword.addEventListener('click', function () {
            const icon = togglePassword.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash'); // Change icon
            } else {
                passwordField.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye'); // Change icon back
            }
        });

        // Password toggle visibility function for confirm password field
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordField = document.getElementById('confirmPassword');
        toggleConfirmPassword.addEventListener('click', function () {
            const icon = toggleConfirmPassword.querySelector('i');
            if (confirmPasswordField.type === 'password') {
                confirmPasswordField.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash'); // Change icon
            } else {
                confirmPasswordField.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye'); // Change icon back
            }
        });


        // Input validation for Mobile Number
        document.getElementById('mobile').addEventListener('input', function () {
            const mobile = this.value.replace(/\D/g, ''); // Remove non-digit characters
            this.value = mobile.slice(0, 11); // Limit to 11 digits
        });

        // Input validation for 4Ps ID Number
        document.getElementById('id-number').addEventListener('input', function () {
            const idNumber = this.value.replace(/\D/g, ''); // Remove non-digit characters
            this.value = idNumber.slice(0, 12); // Limit to 12 digits
        });

        // Input validation for Family Size
        document.getElementById('family-size').addEventListener('input', function () {
            const familySize = this.value.replace(/\D/g, ''); // Remove non-digit characters
            const value = parseInt(familySize, 10);

            if (!value || value < 1) {
                this.value = ""; // Set to empty if invalid
            } else if (value > 25) {
                this.value = "20"; // Limit to 25
            } else {
                this.value = familySize; // Valid value
            }
        });

        // Load members from localStorage on page load
        document.addEventListener('DOMContentLoaded', function () {
            const savedMembers = JSON.parse(localStorage.getItem('members')) || [];
            savedMembers.forEach(member => addMemberToTable(member));
        });

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const mobile = document.getElementById('mobile').value;
            const idNumber = document.getElementById('id-number').value;
            const address = document.getElementById('address').value;
            const familySize = document.getElementById('family-size').value;
            const status = document.getElementById('status').value;

            // Handle profile picture upload
            const profilePicture = document.getElementById('profile-picture').files[0];
            let profilePictureUrl = "";
            if (profilePicture) {
                const reader = new FileReader();
                reader.onloadend = function () {
                    profilePictureUrl = reader.result;
                    addMemberToTable({
                        name, email, mobile, idNumber, address, familySize, status, profilePictureUrl
                    });
                };
                reader.readAsDataURL(profilePicture);
            } else {
                addMemberToTable({ name, email, mobile, idNumber, address, familySize, status, profilePictureUrl });
            }

            // Save the new member to localStorage
            const newMember = { name, email, mobile, idNumber, address, familySize, status, profilePictureUrl };
            const members = JSON.parse(localStorage.getItem('members')) || [];
            members.push(newMember);
            localStorage.setItem('members', JSON.stringify(members));

            form.reset();
        });

        function addMemberToTable(member) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${member.name}</td>
                <td>${member.email}</td>
                <td>${member.mobile}</td>
                <td>${member.idNumber}</td>
                <td>${member.address}</td>
                <td>${member.familySize}</td>
                <td>${member.status}</td>
                <td>
                    ${member.profilePictureUrl ? `<img src="${member.profilePictureUrl}" alt="Profile Picture" width="50" height="50">` : 'No Profile Picture'}
                </td>
            `;
            membersList.appendChild(row);
        }
    </script>
</body>
</html>
