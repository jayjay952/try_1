<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
     crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>FDS Updates</title>
    <link rel="stylesheet" href="usersideupdates.css">

</head>
<body>

    <div class="header-mother-div">
        <div class="header-div2" style=" text-align: center;
        color:rgb(255, 255, 140);
        font-size: 50px;
        margin-top: 50px;
        margin-left:-100px">
    
             <h1> PANTAWID PAMILYANG PILIPINO PROGRAM </h1>
             <div class="logo-pic">
                <a href="userpagehome.php"> <img class="pic" src="4ps-logo.png" alt="">  </a>
                
            </div>
        </div>
    
    </div>
            
        <br>
        <br>

        <br>

        
        <div class="icon-div">
    
            <div class="icon">
          <a href="userpagehome.php"> <button class="home-button"> <i class="fa-solid fa-house"> </i> Home </button></a>
            </div>
    
            <div  class="icon">
            <a href="usersidemeeting.php"> <button> <i class="fa-solid fa-users-line"></i> Meeting </button> </a>
            </div>
    
            <div  class="icon">
             <a href="usersideupdates.php"> <button class="update-button"><i class="fa-solid fa-volume-high"></i>FDS update</button> </a>
              </div>
    
           <div  class="icon">
           <a href="profile.php"> <button> <i class="fa-solid fa-user"></i> Profile </button> </a>
           </div>
    
        </div>
    

         <br>
         <br>


    <div class="container">
        <h2>Latest Updates for 4Ps Members</h2>
        <div id="updates" class="updates">
            <!-- Updates will be displayed here -->
        </div>
    </div>

    <script> 
        const updatesDiv = document.getElementById('updates');

        // Fetch updates from localStorage (simulating stored updates)
        const updates = JSON.parse(localStorage.getItem('updates')).reverse() || [];

        // Display updates
        if (updates.length > 0) {
            updates.forEach(update => {
                const updateElement = document.createElement('div');
                updateElement.classList.add('update');
                updateElement.innerHTML = `
                    <h3>${update.title}</h3>
                    <p>${update.content}</p>
                    <small>Posted on: ${update.date}</small>
                `;
                updatesDiv.appendChild(updateElement);
            });
        } else {
            updatesDiv.innerHTML = '<p>No updates available at the moment.</p>';
        }



        // Load current profile data from localStorage
function loadProfile() {
    const member = JSON.parse(localStorage.getItem('member')) || {};
    
    // Display the profile picture if available
    if (member.picture) {
        const headerProfilePicture = document.getElementById('headerProfilePicture');
        headerProfilePicture.src = member.picture; // Set the profile picture in header
    }
}

// Call loadProfile on page load
window.onload = loadProfile;
    </script>
</body>
</html>