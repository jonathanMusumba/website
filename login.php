<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include_once "db_connection.php";

    // Escape user inputs for security
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Query to check if the user exists in the database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        if ($row['is_locked'] == 1) {
            // Redirect to index.html if account is locked
            header("Location: index.html");
            exit();
        }

        // Verify the password
        if ($row['password'] === $password && $row['role'] === $role) {
            // Check if the role is Director, Principal, or IT Admin
            if ($role == "Director" || $role == "Principal" || $role == "IT Admin") {
                // Set session variables
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                $_SESSION['login_time'] = date("Y-m-d H:i:s");

                // Redirect to the dashboard
                header("Location: dashboard.html");
                exit();
            } else {
                // Redirect to some other page for other roles
                header("Location: other_page.html");
                exit();
            }
        } else {
            // Increment login attempts
            $login_attempts = $row['login_attempts'] + 1;
            $query_increment_attempts = "UPDATE users SET login_attempts = $login_attempts WHERE username = '$username'";
            mysqli_query($conn, $query_increment_attempts);

            // Lock the account if maximum login attempts are reached
            if ($login_attempts >= 3) {
                $query_lock_account = "UPDATE users SET is_locked = 1 WHERE username = '$username'";
                mysqli_query($conn, $query_lock_account);
            }

            header("Location: index.html");
            exit();
        }
    } else {
        header("Location: index.php");
        exit();
    }
} else {
    // Display login form
    // Note: This HTML code can be placed in your index.html file
    echo '<form method="POST" action="">';
    echo 'Username: <input type="text" name="username"><br>';
    echo 'Password: <input type="password" name="password"><br>';
    echo 'Role: <input type="text" name="role"><br>';
    echo '<button type="submit">Login</button>';
    echo '</form>';
}
?>
