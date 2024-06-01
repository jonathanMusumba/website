<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

// Include your database connection file
include_once "db_connection.php";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
    $newPassword = mysqli_real_escape_string($conn, $_POST['new_password']);
    $securityQuestion1 = mysqli_real_escape_string($conn, $_POST['security_question_1']);
    $securityAnswer1 = mysqli_real_escape_string($conn, $_POST['security_answer_1']);
    $securityQuestion2 = mysqli_real_escape_string($conn, $_POST['security_question_2']);
    $securityAnswer2 = mysqli_real_escape_string($conn, $_POST['security_answer_2']);
    $securityQuestion3 = mysqli_real_escape_string($conn, $_POST['security_question_3']);
    $securityAnswer3 = mysqli_real_escape_string($conn, $_POST['security_answer_3']);

    // Update user's password and security questions
    $query = "UPDATE users SET password = '$newPassword', 
              security_question_1 = '$securityQuestion1', security_answer_1 = '$securityAnswer1', 
              security_question_2 = '$securityQuestion2', security_answer_2 = '$securityAnswer2', 
              security_question_3 = '$securityQuestion3', security_answer_3 = '$securityAnswer3' 
              WHERE username = '$username'";

    if (mysqli_query($conn, $query)) {
        // Redirect to login page after setting password and security questions
        header("Location: login.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Password and Security Questions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input[type="password"],
        input[type="text"],
        button {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header style="background-color: #333; color: #fff; padding: 10px; text-align: center;">
        <h1>Set Password and Security Questions</h1>
    </header>
    <div class="container">
        <form method="POST" action="">
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" required>
            <label for="security_question_1">Security Question 1:</label>
            <input type="text" name="security_question_1" required>
            <label for="security_answer_1">Security Answer 1:</label>
            <input type="text" name="security_answer_1" required>
            <label for="security_question_2">Security Question 2:</label>
            <input type="text" name="security_question_2" required>
            <label for="security_answer_2">Security Answer 2:</label>
            <input type="text" name="security_answer_2" required>
            <label for="security_question_3">Security Question 3:</label>
            <input type="text" name="security_question_3" required>
            <label for="security_answer_3">Security Answer 3:</label>
            <input type="text" name="security_answer_3" required>
            <button type="submit">Save</button>
        </form>
    </div>
    <footer style="background-color: #333; color: #fff; padding: 10px; text-align: center; position: fixed; bottom: 0; width: 100%;">
        &copy; 2024 Your Company Name
    </footer>
</body>
</html>
