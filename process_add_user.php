<?php
// Include database connection file
include_once "db_connection.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $username = $_POST["username"];
    $role = $_POST["role"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement to insert user into the database
    $sql = "INSERT INTO users (Name, UserName, Role, Email, Password) VALUES (?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $username, $role, $email, $hashed_password);

    // Execute the statement
    if ($stmt->execute()) {
        // User added successfully
        echo "User added successfully!";
    } else {
        // Error occurred
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect user to the add user page if accessed directly
    header("Location: add_user.php");
    exit();
}
?>
