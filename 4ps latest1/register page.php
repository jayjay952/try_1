
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="register page.css">
    <title>4Ps Member Registration</title>
</head>

<body>
    <div class="header-mother-div">
       
        <div class="header-div2" style="margin-top: 50px;">
            <h1>PANTAWID PAMILYANG PILIPINO PROGRAM</h1>
        </div>
    </div>

    <div class="reg-div">
        <h2>4Ps Member Registration</h2>
        <?php
        session_start();
        if (isset($_SESSION['error'])) {
            echo '<p style="color:red;">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo '<p style="color:green;">' . $_SESSION['success'] . '</p>';
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
                <option value="purok 7">urok 7</option>
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

    <script>
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

        document.getElementById('profile-picture').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('profile-preview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        const getMembers = () => JSON.parse(localStorage.getItem('members')) || [];

        const addMember = (member) => {
            const members = getMembers();
            members.push(member);
            localStorage.setItem('members', JSON.stringify(members));
        };

        document.getElementById('addMemberForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (password !== confirmPassword) {
                alert('Passwords do not match. Please try again.');
                return;
            }

            const profilePictureFile = document.getElementById('profile-picture').files[0];
            let profilePictureBase64 = '';

            if (profilePictureFile) {
                const reader = new FileReader();
                reader.onload = () => {
                    profilePictureBase64 = reader.result;
                    const member = {
                        name: document.getElementById('name').value,
                        email: document.getElementById('email').value,
                        mobile: document.getElementById('mobile').value,
                        idNumber: document.getElementById('id-number').value,
                        address: document.getElementById('address').value,
                        familySize: document.getElementById('family-size').value,
                        status: document.getElementById('status').value,
                        username: document.getElementById('username').value,
                        password,
                        profilePicture: profilePictureBase64
                    };

                    addMember(member);
                    alert('Member Registered Successfully!');
                    window.location.href = 'index.php';
                };
                reader.readAsDataURL(profilePictureFile);
            } else {
                alert('Please select a profile picture.');
            }
        });
    </script>
</body>

</html>