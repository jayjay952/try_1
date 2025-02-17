<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="hompagelogin.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Login Home Page</title>
    <style>
     

    </style>
</head>

<body>
    <div class="header-mother-div">
        
        </div>      

        <div class="header-div2">
            <h1 style="margin-top: -80px;margin-left: -70px; color:lightyellow;" class="logo-text">PANTAWID PAMILIYANG PILIPINO PROGRAM</h1>
            <div>   
                <div class="logo">
                    <div  class="logo-pic">
                        <img  class="pic" src="4ps-logo.png" alt="">  
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <br><br><br>

   
    <br>


    <div style=" background-color: white;
    padding: 30px;
    width: 450px;
    max-width: 400px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin-left:450px;
    margin-top:20px;" class="form-container">
        <h2 class="form-title">Login</h2>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message"><?php echo $_SESSION['error']; ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <form action="login.php" method="POST">
            <div class="form-group">
                <label  style="margin-left: 50px;">Username:</label>
                <input style="margin-left:-px" type="text" name="username" required>
            </div>
            <div class="form-group">
                <label style="margin-left: 50px;">Password:</label>
                <input style="margin-left:px" type="password" id="password" name="password" required>
                
            </div>
                 <a href="forgot_password.php">Forgot Password</a>
            <br>
            <button type="submit">Login</button>
        </form>
       
       
    </div>

    <script>
        // JavaScript function to toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
 