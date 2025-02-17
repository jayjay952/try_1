<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>secAdmin Meeting</title>
    <link rel="stylesheet" href="secadmin-meeting.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>4Ps Admin</h2>
            <nav>
                <ul>
                    <li><a href="secadmin.php">Dashboard</a></li>
                    
                    <li><a href="" class="active">Meetings Updates</a></li>
                    <li><a href="secadmin-update.php">FDS Updates</a></li>
                    <li><a href="index.php">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Manage Meetings</h1>
                <p>Here, you can schedule meetings and manage meeting topics.</p>
            </header>

            <!-- Add Meeting Form -->
            <section class="meeting-form">
                <h2>Schedule a New Meeting</h2>
                <form id="meeting-form">
                    <label for="meeting-date">Meeting Date:</label>
                    <input type="date" id="meeting-date" name="meeting_date" required>

                    <label for="meeting-topic">Meeting Topic:</label>
                    <input type="text" id="meeting-topic" name="meeting_topic" placeholder="Enter the meeting topic" required>

                    <label for="meeting-description">Meeting Description:</label>
                    <textarea id="meeting-description" name="meeting_description" rows="5" placeholder="Describe the meeting" required></textarea>

                    <button type="submit" class="submit-btn">Add Meeting</button>
                </form>
            </section>

            <!-- Scheduled Meetings Table -->
            <section class="meetings-table">
                <h2>Scheduled Meetings</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Topic</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="meeting-list">
                        <!-- Meeting rows will be dynamically added here -->
                    </tbody>
                </table>
            </section>
        </div>
    </div>

    <script>
        // Load meetings from localStorage (or API)
        function loadMeetings() {
            const meetings = JSON.parse(localStorage.getItem('meetings')) || [];
            const meetingList = document.getElementById('meeting-list');

            // Clear the existing rows
            meetingList.innerHTML = '';

            meetings.forEach((meeting, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${meeting.date}</td>
                    <td>${meeting.topic}</td>
                    <td>${meeting.description}</td>
                    <td>
                        <button class="action-btn" onclick="deleteMeeting(${index})">Delete</button>
                    </td>
                `;
                meetingList.appendChild(row);
            });
        }

        // Add a meeting
        document.getElementById('meeting-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const date = document.getElementById('meeting-date').value;
            const topic = document.getElementById('meeting-topic').value;
            const description = document.getElementById('meeting-description').value;

            const newMeeting = { date, topic, description };

            // Get existing meetings from localStorage
            const meetings = JSON.parse(localStorage.getItem('meetings')) || [];

            // Add the new meeting to the array
            meetings.push(newMeeting);

            // Save updated meetings back to localStorage
            localStorage.setItem('meetings', JSON.stringify(meetings));

            // Reload the meeting list
            loadMeetings();

            // Clear the form
            document.getElementById('meeting-form').reset();
        });

        // Delete a meeting
        function deleteMeeting(index) {
            const meetings = JSON.parse(localStorage.getItem('meetings')) || [];
            meetings.splice(index, 1); // Remove the selected meeting

            // Save the updated meetings back to localStorage
            localStorage.setItem('meetings', JSON.stringify(meetings));

            // Reload the meeting list
            loadMeetings();
        }

        // Load the meetings on page load
        window.onload = loadMeetings;
    </script>
</body>
</html>