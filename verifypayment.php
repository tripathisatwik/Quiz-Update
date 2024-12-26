<?php
session_start();
require 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $orderID = $data['orderID'];
    $details = $data['details'];
    $user_id = $_SESSION['user_id'];

    // Payment details
    $amount = $details['purchase_units'][0]['amount']['value'];
    $status = $details['status'];
    $payment_id = $details['id'];

    if ($status === 'COMPLETED') {
        // Record payment in the database
        $sql = "INSERT INTO payments (user_id, amount, payment_status, payment_id) VALUES 
                ($user_id, $amount, 'completed', '$payment_id')";
        if (mysqli_query($conn, $sql)) {
            // Update user payment status
            $update_user = "UPDATE user SET has_paid = TRUE WHERE id = $user_id";
            mysqli_query($conn, $update_user);

            echo json_encode(['status' => 'success']);
            exit;
        }
    }
    echo json_encode(['status' => 'error']);
}
?>
