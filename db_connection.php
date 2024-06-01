<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "LINMS";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
$sqlCreateDB = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sqlCreateDB) === FALSE) {
    die("Error creating database: " . $conn->error);
}

$conn->select_db($dbname);


