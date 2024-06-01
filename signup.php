<?php
include "db_connection.php";


$sql_create_table = "CREATE TABLE IF NOT EXISTS users (
    ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    UserName VARCHAR(50) NOT NULL UNIQUE,
    Role VARCHAR(50) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    SecurityQuestion1 VARCHAR(255) NOT NULL,
    SecurityAnswer1 VARCHAR(255) NOT NULL,
    SecurityQuestion2 VARCHAR(255) NOT NULL,
    SecurityAnswer2 VARCHAR(255) NOT NULL,
    SecurityQuestion3 VARCHAR(255) NOT NULL,
    SecurityAnswer3 VARCHAR(255) NOT NULL,
    DateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    LastAccessed TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Approved BOOLEAN DEFAULT FALSE
)";

if ($conn->query($sql_create_table) === FALSE) {
    die("Error creating table: " . $conn->error);
}

$sql_create_approval_requests_table = "CREATE TABLE IF NOT EXISTS approval_requests (
    RequestID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    UserID INT(6) UNSIGNED,
    RequestedRole VARCHAR(50) NOT NULL,
    FOREIGN KEY (UserID) REFERENCES users(ID)
)";

if ($conn->query($sql_create_approval_requests_table) === FALSE) {
    die("Error creating approval_requests table: " . $conn->error);
}


function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function sanitizeData($data) {
    global $conn;
    return mysqli_real_escape_string($conn, $data);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitizeData($_POST['name']);
    $username = sanitizeData($_POST['username']);
    $role = sanitizeData($_POST['role']);
    $email = sanitizeData($_POST['email']);
    $password = hashPassword($_POST['password']);
    $security_question_1 = sanitizeData($_POST['security_question_1']);
    $security_answer_1 = hashPassword($_POST['security_answer_1']);
    $security_question_2 = sanitizeData($_POST['security_question_2']);
    $security_answer_2 = hashPassword($_POST['security_answer_2']);
    $security_question_3 = sanitizeData($_POST['security_question_3']);
    $security_answer_3 = hashPassword($_POST['security_answer_3']);

    $sql_insert_user = "INSERT INTO users (Name, UserName, Role, Email, Password, SecurityQuestion1, SecurityAnswer1, SecurityQuestion2, SecurityAnswer2, SecurityQuestion3, SecurityAnswer3)
            VALUES ('$name', '$username', '$role', '$email', '$password', '$security_question_1', '$security_answer_1', '$security_question_2', '$security_answer_2', '$security_question_3', '$security_answer_3')";

    if ($conn->query($sql_insert_user) === TRUE) {
        $sql_check_director = "SELECT * FROM users WHERE Role = 'Director'";
        $result_director = $conn->query($sql_check_director);
        if ($result_director->num_rows == 0) {
            $user_id = $conn->insert_id;
            $sql_update_approval = "UPDATE users SET Approved = TRUE WHERE ID = $user_id";
            $conn->query($sql_update_approval);
            echo "Your account has been approved as you are the director.";
        } else {
            $sql_insert_approval_request = "INSERT INTO approval_requests (UserID, RequestedRole) VALUES ('$user_id', '$role')";
            $conn->query($sql_insert_approval_request);
            echo "Your account is pending approval from the director.";
        }
    } else {
        echo "Error: " . $sql_insert_user . "<br>" . $conn->error;
    }
} else {
    echo "Error: Form not submitted.";
}

$conn->close();

