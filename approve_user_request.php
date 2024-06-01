<?php
include "db_connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the director is logged in (you should implement authentication)
    // For demonstration purposes, let's assume the director is logged in
    
    // Assuming you have a session variable storing the director's role
    $director_role = $_SESSION['role']; // Make sure to sanitize and validate this value
    
    if ($director_role !== 'Director') {
        // If the logged-in user is not the director, redirect to an unauthorized page
        header("Location: unauthorized.php");
        exit();
    }

    // Assuming you have form fields for user ID and action (approve/reject)
    $user_id = $_POST['user_id'];
    $action = $_POST['action']; // This should be 'approve' or 'reject'

    // Perform action based on the director's choice
    if ($action === 'approve') {
        // Update the user's approval status in the users table
        $sql_approve_user = "UPDATE users SET Approved = TRUE WHERE ID = $user_id";
        if ($conn->query($sql_approve_user) === TRUE) {
            // If successful, redirect to a success page
            header("Location: approval_success.php");
            exit();
        } else {
            // If update fails, handle the error
            echo "Error: " . $sql_approve_user . "<br>" . $conn->error;
        }
    } elseif ($action === 'reject') {
        // Delete the user's request from the approval_requests table
        $sql_reject_request = "DELETE FROM approval_requests WHERE UserID = $user_id";
        if ($conn->query($sql_reject_request) === TRUE) {
            // If successful, redirect to a success page
            header("Location: rejection_success.php");
            exit();
        } else {
            // If deletion fails, handle the error
            echo "Error: " . $sql_reject_request . "<br>" . $conn->error;
        }
    } else {
        // Invalid action, handle appropriately (redirect or show error message)
        echo "Invalid action!";
    }
} else {
    // If the form is not submitted via POST method, redirect or display an error
    echo "Form not submitted!";
}

// Close database connection
$conn->close();
?>
