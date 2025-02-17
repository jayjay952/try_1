<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>secAdmin - Manage Updates</title>
    <link rel="stylesheet" href="secadmin-update.css">
    <style>
        /* Table Styling */
#updateList {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    font-family: Arial, sans-serif;
}

#updateList th, #updateList td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

/* Table Header Styling */
#updateList thead {
    background: linear-gradient(135deg, #6f7de8, #4a55d6);
    color: white;
    font-weight: bold;
    text-transform: uppercase;
}

/* Table Row Hover Effect */
#updateList tbody tr:hover {
    background-color: #f1f1f1;
    transition: background-color 0.3s ease;
}

/* Table Borders */
#updateList th, #updateList td {
    border: 1px solid #e4e7ef;
    border-radius: 8px;
}

/* Action Buttons */
#updateList td button {
    background-color: #ff4b4b;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

#updateList td button:hover {
    background-color: #e53e3e;
}

/* Additional Spacing */
#updateList td {
    padding-left: 20px;
    padding-right: 20px;
}

#updateList th {
    padding-left: 20px;
    padding-right: 20px;
}

    </style>
</head>
<body>

    
    
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h3 class="am-mmdash">4Ps Admin</h3>
            <nav>
                <ul>
                    <li><a href="secadmin.php" class="">Dashboard</a></li>
                    
                    <li><a href="secadmin-meeting.php">Meeting Updates</a></li>
                    <li><a href="" class="active">FDS Updates</a></li>
                    <li><a href="index.php">Logout</a></li>
                </ul>
            </nav>
        </aside>
    </div>






    <div class="container">
        <h2>Add Update for 4Ps Members</h2>
        <form id="addUpdateForm" class="add-update-form">
            <label for="update-title">Update Title:</label>
            <input type="text" id="update-title" name="title" required>
            
            <label for="update-content">Update Content:</label>
            <textarea id="update-content" name="content" rows="5" required></textarea>
            
            <button type="submit">Post Update</button>
        </form>

        <p class="message" id="message"></p>

        <!-- Updates List -->
        <h2>Existing Updates</h2>
        <table id="updateList">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Updates will be dynamically added here -->
            </tbody>
        </table>
    </div>

    <script>
        const form = document.getElementById('addUpdateForm');
        const message = document.getElementById('message');
        const updateList = document.querySelector('#updateList tbody');

        // Load updates from localStorage on page load
        function loadUpdates() {
            const updates = JSON.parse(localStorage.getItem('updates')) || [];
            updateList.innerHTML = ''; // Clear existing rows

            updates.forEach((update, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${update.title}</td>
                    <td>${update.content}</td>
                    <td>${update.date}</td>
                    <td><button onclick="deleteUpdate(${index})">Delete</button></td>
                `;
                updateList.appendChild(row);
            });
        }

        // Function to handle form submission
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            // Get update details
            const title = document.getElementById('update-title').value;
            const content = document.getElementById('update-content').value;

            // Create an update object
            const update = { title, content, date: new Date().toLocaleString() };

            // Get existing updates from localStorage
            let updates = JSON.parse(localStorage.getItem('updates')) || [];

            // Add new update to the list
            updates.push(update);

            // Save updates back to localStorage
            localStorage.setItem('updates', JSON.stringify(updates));

            // Display a success message
            message.textContent = "Update posted successfully!";
            message.style.color = "green";

            // Clear the form
            form.reset();

            // Reload the updates list
            loadUpdates();
        });

        // Function to delete an update
        function deleteUpdate(index) {
            let updates = JSON.parse(localStorage.getItem('updates')) || [];
            updates.splice(index, 1); // Remove the selected update

            // Save the updated list back to localStorage
            localStorage.setItem('updates', JSON.stringify(updates));

            // Reload the updates list
            loadUpdates();
        }

        // Load updates when the page is loaded
        window.onload = loadUpdates;
    </script>
</body>
</html>