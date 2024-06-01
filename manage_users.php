<?php
include 'db_connection.php';

function approveUserRequest($connection, $requestID) {
    $query_request_info = "SELECT UserID, RequestedRole FROM approval_request WHERE RequestID = $requestID";
    $result_request_info = mysqli_query($connection, $query_request_info);

    if ($result_request_info && mysqli_num_rows($result_request_info) > 0) {
        $row = mysqli_fetch_assoc($result_request_info);
        $userID = $row['UserID'];
        $requestedRole = $row['RequestedRole'];


        $query_update_role = "UPDATE users SET Role = '$requestedRole', Approved = TRUE WHERE ID = $userID";
        if (mysqli_query($connection, $query_update_role)) {

            $query_delete_request = "DELETE FROM approval_request WHERE RequestID = $requestID";
            if (mysqli_query($connection, $query_delete_request)) {
                echo "User request approved successfully.<br>";
            } else {
                echo "Error deleting approval request: " . mysqli_error($connection);
            }
        } else {
            echo "Error updating user role: " . mysqli_error($connection);
        }
    } else {
        echo "No user request found with ID: $requestID";
    }
}

function unlockUser($connection, $userID) {

    $query_unlock_user = "UPDATE users SET Locked = FALSE WHERE ID = $userID";
    if (mysqli_query($connection, $query_unlock_user)) {
        echo "User unlocked successfully.<br>";
    } else {
        echo "Error unlocking user: " . mysqli_error($connection);
    }
}


function deleteUser($connection, $userID) {
    $query_check_director = "SELECT Role FROM users WHERE ID = $userID";
    $result_check_director = mysqli_query($connection, $query_check_director);

    if ($result_check_director && mysqli_num_rows($result_check_director) > 0) {
        $row = mysqli_fetch_assoc($result_check_director);
        $role = $row['Role'];
        if ($role !== 'Director') {
            $query_delete_user = "DELETE FROM users WHERE ID = $userID";
            if (mysqli_query($connection, $query_delete_user)) {
                echo "User deleted successfully.<br>";
            } else {
                echo "Error deleting user: " . mysqli_error($connection);
            }
        } else {
            echo "Cannot delete Director.";
        }
    } else {
        echo "User not found.";
    }
}

function changeUserRole($connection, $userID, $newRole) {
    $query_update_role = "UPDATE users SET Role = '$newRole' WHERE ID = $userID";
    if (mysqli_query($connection, $query_update_role)) {
        echo "User role updated successfully.<br>";
    } else {
        echo "Error updating user role: " . mysqli_error($connection);
    }
}

function updateUserEmail($connection, $userID, $newEmail) {
    $query_update_email = "UPDATE users SET Email = '$newEmail' WHERE ID = $userID";
    if (mysqli_query($connection, $query_update_email)) {
        echo "User email updated successfully.<br>";
    } else {
        echo "Error updating user email: " . mysqli_error($connection);
    }
}

function updateUserPassword($connection, $userID, $newPassword) {
    $query_update_password = "UPDATE users SET Password = '$newPassword' WHERE ID = $userID";
    if (mysqli_query($connection, $query_update_password)) {
        echo "User password updated successfully.<br>";
    } else {
        echo "Error updating user password: " . mysqli_error($connection);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['action'] == 'approve') {
        $requestID = $_POST['requestID'];
        approveUserRequest($connection, $requestID);
    } elseif ($_POST['action'] == 'unlock') {
        $userID = $_POST['userID'];
        unlockUser($connection, $userID);
    } elseif ($_POST['action'] == 'delete') {
        $userID = $_POST['userID'];
        deleteUser($connection, $userID);
    } elseif ($_POST['action'] == 'changeRole') {
        $userID = $_POST['userID'];
        $newRole = $_POST['newRole'];
        changeUserRole($connection, $userID, $newRole);
    } elseif ($_POST['action'] == 'updateEmail') {
        $userID = $_POST['userID'];
        $newEmail = $_POST['newEmail'];
        updateUserEmail($connection, $userID, $newEmail);
    } elseif ($_POST['action'] == 'updatePassword') {
        $userID = $_POST['userID'];
        $newPassword = $_POST['newPassword'];
        updateUserPassword($connection, $userID, $newPassword);
    }
}

mysqli_close($connection);
