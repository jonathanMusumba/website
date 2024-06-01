<?php
include 'db_connection.php';

$sql = "SELECT * FROM Applicants WHERE 1";

if(isset($_GET['submissionDate']) && !empty($_GET['submissionDate'])) {
    $submissionDate = $_GET['submissionDate'];
    $sql .= " AND DATE(Submitted) = '$submissionDate'";
}

if(isset($_GET['course']) && !empty($_GET['course'])) {
    $course = $_GET['course'];
    $sql .= " AND Course = '$course'";
}

if(isset($_GET['level']) && !empty($_GET['level'])) {
    $level = $_GET['level'];
    $sql .= " AND Level = '$level'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["surname"]. " " . $row["givenName"]. "<br>";

    }
} else {
    echo "0 results";
}

$conn->close();

