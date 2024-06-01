<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include_once "db_connection.php";

    // Decode the JSON data sent in the request body
    $data = json_decode(file_get_contents("php://input"));

    // Check if the userId is set in the decoded data
    if (isset($data->userId)) {
        // Sanitize the userId to prevent SQL injection
        $userId = mysqli_real_escape_string($conn, $data->userId);

        // Query to approve the user by updating the Approved column in the users table
        $query = "UPDATE users SET Approved = TRUE WHERE ID = $userId";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            // Respond with a success message
            echo json_encode(array("message" => "User approved successfully"));
        } else {
            // Respond with an error message
            echo json_encode(array("error" => "Error approving user: " . mysqli_error($conn)));
        }
    } else {
        // Respond with an error message if userId is not set in the request
        echo json_encode(array("error" => "User ID not provided"));
    }
} else {
    // Respond with an error message if the request method is not POST
    echo json_encode(array("error" => "Invalid request method"));
}
?>
