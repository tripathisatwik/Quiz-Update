<?php
session_start();
require 'dbconnect.php'; // Ensure this file connects to your database

$username = $_SESSION['Login_session'];  // The logged-in username

// Check if the user is logged in
if (!isset($username)) {
    header("Location: index.php");
    exit;
}

// Capture parameters from the URL (if necessary)
$orderId = $_GET['oid'] ?? null;
$amount = $_GET['amt'] ?? null;
$refId = $_GET['refId'] ?? null;

if ($orderId && $amount && $refId) {
    // Prepare the SQL query using a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("UPDATE `user` SET `has_paid` = 1 WHERE username = ?");
    $stmt->bind_param("s", $username); // Bind the username parameter (as a string)
    
    // Execute the query
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        // Redirect to quiz page
        header("Location: quiz.php");
        exit;
    } else {
        echo "Failed to update payment status.";
        header("Location: index.php");
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo "Invalid parameters received.";
}
?>
