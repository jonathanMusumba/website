<?php
include 'db_connection.php';

$query_create_users_table = "CREATE TABLE IF NOT EXISTS users (
    ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    UserName VARCHAR(50) NOT NULL UNIQUE,
    Role ENUM('Director', 'Principal', 'IT Admin') NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    SecurityQuestion1 VARCHAR(255),
    SecurityAnswer1 VARCHAR(255),
    SecurityQuestion2 VARCHAR(255),
    SecurityAnswer2 VARCHAR(255),
    SecurityQuestion3 VARCHAR(255),
    SecurityAnswer3 VARCHAR(255),
    DateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    LastAccessed TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Approved BOOLEAN DEFAULT FALSE
)";
mysqli_query($connection, $query_create_users_table);

$query_create_approval_request_table = "CREATE TABLE IF NOT EXISTS approval_request (
    RequestID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    UserID INT(6) UNSIGNED,
    RequestedRole VARCHAR(50) NOT NULL,
    FOREIGN KEY (UserID) REFERENCES users(ID)
)";
mysqli_query($connection, $query_create_approval_request_table);{
    
}

function addNewUser($connection, $name, $username, $role, $email, $password) {
    $stmt = $connection->prepare("INSERT INTO users (Name, UserName, Role, Email, Password) VALUES (?, ?, ?, ?, ?)");
    
    $stmt->bind_param("sssss", $name, $username, $role, $email, $password);

    if ($stmt->execute()) {
        echo "User added successfully.<br>";
    } else {
        echo "Error adding user: " . $stmt->error;
    }
}
function approveUser($connection, $userID) {
    $query_update_approval = "UPDATE users SET Approved = TRUE WHERE ID = $userID";
    if (mysqli_query($connection, $query_update_approval)) {
        echo "User approved successfully.<br>";
    } else {
        echo "Error approving user: " . mysqli_error($connection);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    addNewUser($connection, $name, $username, $role, $email, $password);

    if ($role === 'Director' || $role === 'Principal') {
        approveUser($connection, mysqli_insert_id($connection));
    } else {

        $userID = mysqli_insert_id($connection);
        $query_insert_approval_request = "INSERT INTO approval_request (UserID, RequestedRole) VALUES ($userID, '$role')";
        if (mysqli_query($connection, $query_insert_approval_request)) {
            echo "Approval request sent successfully.<br>";
        } else {
            echo "Error sending approval request: " . mysqli_error($connection);
        }
    }
}

mysqli_close($connection);

