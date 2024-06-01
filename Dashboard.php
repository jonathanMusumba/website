<?php
session_start();

// Check if user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); 
    exit();
}

// Full access for any logged-in user
echo "Dashboard content for logged-in user";
echo "Full access to all features...";
?>
