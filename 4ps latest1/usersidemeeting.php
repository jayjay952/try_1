
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Meetings</title>
    <link rel="stylesheet" href="usersidemeeting.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <div class="header-mother-div">

        <div class="header-div2" style=" text-align: center;
        color:rgb(255, 255, 140);
        font-size: 50px;
        margin-top: 50px;
        margin-left:-100px">
            <h1>PANTAWID PAMILYANG PILIPINO PROGRAM</h1>
            <div class="searchbar-div"></div>
            <div class="logo-pic">
             <a href="userpagehome.php"> <img class="pic" src="4ps-logo.png" alt="">  </a>
             
            </div>
        </div>
    </div>

    <br><br><br>

    <div class="icon-div">
        <div class="icon">
            <a href="userpagehome.php"><button><i class="fa-solid fa-house"></i> Home </button></a>
        </div>

        <div class="icon">
            <a href="usersidemeeting.php" ><button class="meeting-button" id="meeting-button"><i class="fa-solid fa-users-line"></i> Meeting </button></a>
        </div>

        <div class="icon">
            <a href="usersideupdates.php"><button class="update-button" id="update-button"><i class="fa-solid fa-volume-high"></i>FDS Update </button></a>
        </div>

        <div class="icon">
            <a href="profile.php"><button><i class="fa-solid fa-user"></i> Profile </button></a>
        </div>
    </div>

    <br>

    <div class="container">
        <h2>4Ps Meetings</h2>

        <div id="meeting-list" class="meeting-list">
            <!-- Meetings will be dynamically added here -->
        </div>
    </div>

    <script>
        // Load profile picture in header
        function loadProfilePicture() {
            const member = JSON.parse(localStorage.getItem('member')) || {};
            const headerProfilePicture = document.getElementById('headerProfilePicture');

            if (member.picture) {
                headerProfilePicture.src = member.picture; // Update header profile picture if set
            }
        }

        // Load meetings from localStorage
        function loadMeetings() {
            const meetings = JSON.parse(localStorage.getItem('meetings'))?.reverse() || [];
            const meetingList = document.getElementById('meeting-list');

            // Clear existing meeting cards
            meetingList.innerHTML = '';

            meetings.forEach(meeting => {
                const meetingCard = document.createElement('div');
                meetingCard.classList.add('meeting-card');

                meetingCard.innerHTML = `
                    <h3>${meeting.topic}</h3>
                    <p><strong>Date:</strong> ${meeting.date}</p>
                    <p><strong>Description:</strong> ${meeting.description}</p>
                `;

                meetingList.appendChild(meetingCard);
            });
        }

        // Load profile picture and meetings on page load
        window.onload = function() {
            loadProfilePicture(); // Load profile picture
            loadMeetings(); // Load meetings
        };
    </script>
</body>
</html>
