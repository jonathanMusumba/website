<?php
// Include database connection
include 'db_connection.php';

// Function to generate OTP
function generateOTP() {
    return mt_rand(100000, 999999); // Generate a random 6-digit OTP
}

// Process password reset request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receive form data
    $username = $_POST['username'];
    $securityAnswer = $_POST['security_answer'];

    // Query the database to get the security question answer
    $sql = "SELECT security_answer, email FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $correctAnswer = $row['security_answer'];
        $email = $row['email'];

        // Compare security question answers
        if ($securityAnswer === $correctAnswer) {
            // Generate OTP
            $otp = generateOTP();

            // Store OTP in the database
            $sql = "UPDATE users SET otp = ? WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $otp, $username);
            $stmt->execute();

            $stmt = $conn->prepare("SELECT email FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($email);
$stmt->fetch();
$stmt->close();

if ($email) {
    $to = $email;
    $subject = "Password Reset OTP";
    $message = "Your OTP for password reset is: $otp";
    $headers = "From: your-email@example.com"; 

    if (mail($to, $subject, $message, $headers)) {

        header("Location: reset_password.php?username=$username");
        exit();
    } else {
        echo "Error sending OTP. Please try again later.";
    }
} else {
    echo "User not found or email address not registered.";
}
            header("Location: reset_password.php?username=$username");
            exit();
        } else {
            echo "Incorrect security question answer.";
        }
    } else {

        echo "User not found.";
    }

    $stmt->close();
}

$conn->close();
?>
