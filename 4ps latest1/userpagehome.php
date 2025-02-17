
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="userpagehome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
     crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>User Home Page</title>

    <style>
        /* Blinking effect */
        @keyframes blink {
            0% { background-color: transparent; }
            50% { background-color: red; }
            100% { background-color: transparent; }
        }
        .blink {
            animation: blink 1s infinite;
        }
        



        /* Responsive Design */
        @media (max-width: 768px) {
            .header-mother-div h1 {
                font-size: 1.5rem;
            }

            .icon-div {
                flex-direction: column;
            }

            .icon button {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .header-mother-div h1 {
                font-size: 1.2rem;
            }

            .logo-pic img {
                width: 60px;
            }

            .icon button {
                font-size: 0.9rem;
                padding: 8px 15px;
            }
        }

       
        
    </style>
</head>

<body>
    <div class="header-mother-div">
       
    
        <div class="header-div2" style=" text-align: center;
        color:rgb(255, 255, 140);
        font-size: 50px;
        margin-top: 50px;
        margin-left:-100px">
            <h1 >PANTAWID PAMILYANG PILIPINO PROGRAM</h1>
            <div class="logo-pic">
                <img class="pic" src="4ps-logo.png" alt="">  
            </div>
        </div>
    </div>

    <br><br><br>

    <div class="icon-div">
        <div class="icon">
            <a href="#"><button class="home-button"><i class="fa-solid fa-house"></i> Home </button></a>
        </div>

        <div class="icon">
            <a href="usersidemeeting.php"><button class="meeting-button" id="meeting-button"><i class="fa-solid fa-users-line"></i>Meeting</button></a>
        </div>

        <div class="icon">
            <a href="usersideupdates.php"><button class="update-button" id="update-button"><i class="fa-solid fa-volume-high"></i>FDS Update </button></a>
        </div>


        <div class="icon">
            <a href="profile.php"><button><i class="fa-solid fa-user"></i> Profile </button></a>
        </div>
    </div>

    

   

    <script>
        // Function to check for new meetings or updates and apply blinking effect
        function checkForNewInfo() {
            const meetings = JSON.parse(localStorage.getItem('meetings')) || [];
            const updates = JSON.parse(localStorage.getItem('updates')) || [];
            const prevMeetingCount = localStorage.getItem('prevMeetingCount') || 0;
            const prevUpdateCount = localStorage.getItem('prevUpdateCount') || 0;

            const meetingButton = document.getElementById('meeting-button');
            const updateButton = document.getElementById('update-button');

            // Check for new meetings
            if (meetings.length > prevMeetingCount) {
                meetingButton.classList.add('blink');
            } else {
                meetingButton.classList.remove('blink');
            }

            // Check for new updates
            if (updates.length > prevUpdateCount) {
                updateButton.classList.add('blink');
            } else {
                updateButton.classList.remove('blink');
            }

            // Store the current counts
            localStorage.setItem('prevMeetingCount', meetings.length);
            localStorage.setItem('prevUpdateCount', updates.length);

            // Load the latest update image and title if available
            if (updates.length > 0) {
                const latestUpdate = updates[updates.length - 1]; // Get the latest update
                document.getElementById('update-image').src = latestUpdate.imageUrl || 'default-image.jpg'; // Fallback to a default image
                document.getElementById('update-title').innerText = latestUpdate.title || 'No Title';
            }
        }

        // Call the function on page load
        window.onload = checkForNewInfo;

        // Example: Admin adding a new meeting (this would be done through admin dashboard)
        function addMeeting() {
            const meetings = JSON.parse(localStorage.getItem('meetings')) || [];
            meetings.push({
                title: 'New 4Ps Meeting Update',
                date: '2024-10-19'
            });
            localStorage.setItem('meetings', JSON.stringify(meetings));
            checkForNewInfo(); // Refresh to show the new meeting
        }

        // Example: Admin adding a new update (this would be done through admin dashboard)
        function addUpdate() {
            const updates = JSON.parse(localStorage.getItem('updates')) || [];
            updates.push({
                imageUrl: '4ps_meeting_pic.jpg', // Example image URL
                title: 'The Latest Update from 4Ps'
            });
            localStorage.setItem('updates', JSON.stringify(updates));
            checkForNewInfo(); // Refresh to show the new update
        }

        


        // Function to check for new messages and apply the blinking effect
function checkForNewMessages() {
    const messages = JSON.parse(localStorage.getItem('messages')) || [];
    const prevMessageCount = localStorage.getItem('prevMessageCount') || 0;

    const messageButton = document.getElementById('message-button');

    // Check if there are new messages
    if (messages.length > prevMessageCount) {
        messageButton.classList.add('blink');
    } else {
        messageButton.classList.remove('blink');
    }

    // Store the current message count
    localStorage.setItem('prevMessageCount', messages.length);
}

// Call the function on page load
window.onload = function() {
    checkForNewInfo(); // Check for new meetings and updates
    checkForNewMessages(); // Check for new messages
};

// Example: Admin adding a new message (for testing purposes)
function addMessage() {
    const messages = JSON.parse(localStorage.getItem('messages')) || [];
    messages.push({
        content: 'New message from the admin.',
        date: new Date().toISOString()
    });
    localStorage.setItem('messages', JSON.stringify(messages));
    checkForNewMessages(); // Refresh to show the new message
}



// Load profile picture from localStorage
function loadProfilePicture() {
    const member = JSON.parse(localStorage.getItem('member')) || {};
    const userProfilePicture = document.getElementById('userProfilePicture');

    // If profile picture exists, set it as the source; otherwise, use default
    if (member.picture) {
        userProfilePicture.src = member.picture;
    }
}

// Call the function on page load
window.onload = function() {
    loadProfilePicture();
    checkForNewInfo(); // Check for new meetings and updates
    checkForNewMessages(); // Check for new messages
};

// Uncomment the line below to simulate the admin sending a new message for testing
// addMessage();
    </script>
</body>
</html>