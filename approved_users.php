<?php
// Include your database connection file
include_once "db_connection.php";

// Check if the user is logged in and has the required role (Director or Principal)
session_start();
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'Director' && $_SESSION['role'] != 'Principal')) {
    // Redirect to the login page if not logged in or doesn't have the required role
    header("Location: login.php");
    exit();
}

// Query to retrieve approved users from the users table
$sql = "SELECT * FROM users WHERE Approved = TRUE";
$result = $conn->query($sql);

// Check if there are approved users
if ($result->num_rows > 0) {
    // Display approved users
    echo "<h2>Approved Users</h2>";
    echo "<table border='1'>";
    echo "<tr><th>User ID</th><th>Username</th><th>Email</th><th>Role</th><th>Actions</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['ID'] . "</td>";
        echo "<td>" . $row['UserName'] . "</td>";
        echo "<td>" . $row['Email'] . "</td>";
        echo "<td>" . $row['Role'] . "</td>";
        echo "<td>";
        // Display action buttons only for Director and Principal
        if ($_SESSION['role'] == 'Director' || $_SESSION['role'] == 'Principal') {
            echo "<button onclick='deleteUser(" . $row['ID'] . ")'>Delete</button>";
            echo "<button onclick='updatePassword(" . $row['ID'] . ")'>Update Password</button>";
        }
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    // If no approved users found, display a message
    echo "No approved users found.";
}

// Close the database connection
$conn->close();
?>
