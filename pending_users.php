<?php
session_start();
include "db_connection.php";

// Check if user is authorized to access this page
if ($_SESSION['role'] != 'Director' && $_SESSION['role'] != 'Principal') {
    // Redirect to unauthorized page or display an error message
    header("Location: unauthorized.php");
    exit();
}

// Retrieve pending users from approval_requests table
$sql_pending_users = "SELECT * FROM approval_requests";
$result_pending_users = $conn->query($sql_pending_users);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Users</title>
    <!-- Include any necessary CSS -->
</head>
<body>
    <h1>Pending Users</h1>
    <table>
        <thead>
            <tr>
                <th>User Username</th>
                <th>Requested Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display pending users with action buttons
            while ($row = $result_pending_users->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['user_username']}</td>";
                echo "<td>{$row['requested_role']}</td>";
                echo "<td><button onclick=\"approveUser({$row['user_id']})\">Approve</button> <button onclick=\"rejectUser({$row['user_id']})\">Reject</button></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- JavaScript functions to handle approval and rejection -->
    <script>
        function approveUser(userId) {
    fetch('approve_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ userId: userId }),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        // Reload the page or update UI as needed
        window.location.reload();
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
        // Handle errors appropriately
    });
}

function rejectUser(userId) {
    fetch('reject_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ userId: userId }),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        // Reload the page or update UI as needed
        window.location.reload();
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
        // Handle errors appropriately
    });
}

    </script>
</body>
</html>
