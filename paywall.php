<?php
// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require 'dbconnect.php';

// Check if user is logged in
if (!isset($_SESSION['Login_session'])) {
    header("Location: index.php");
    exit;
}

// Fetch user data and check payment status
$username = $_SESSION['Login_session']; // Assuming username is stored in session
$query = "SELECT has_paid FROM user WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();


if ($stmt->num_rows > 0) {
    $stmt->bind_result($has_paid);
    $stmt->fetch();

    if ($has_paid == 1) {
        $_SESSION['has_paid'] = true;
        header("Location: quiz.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}

// Logout logic
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

$payment_id = "PAY" . uniqid(); //unique if for esewa
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paywall</title>
    <script src="https://www.paypal.com/sdk/js?client-id=ATE7-b70_-0SIfeEfqxOzERNKzam4JsbkolxjnKtP3bARmtBc1x_LP34jypTF63MWTOxSt2PRqgD3haY&currency=USD"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 500px;
        }
        h2 {
            color: #e74c3c;
        }
        .message {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .btn {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #2980b9;
        }
        .esewa-btn {
            background-color: #4CAF50;
            margin-top: 20px;
        }
        .esewa-btn:hover {
            background-color: #45a049;
        }
        .logout-btn {
            background-color: #e74c3c;
            margin-top: 20px;
        }
        .logout-btn:hover {
            background-color: #c0392b;
        }
        footer {
            position: absolute;
            bottom: 20px;
            font-size: 14px;
            color: #888;
        }
        .paypal-button-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Paywall</h2>
        <p class="message">You need to complete the payment to access the content.</p>

        <!-- PayPal Payment Button -->
        <div id="paypal-button-container"></div>

        <div class="payment-container">
            <!-- Pay with eSewa Button -->
            <form action="https://uat.esewa.com.np/epay/main" method="POST" style="margin-top: 20px;">
                <input type="hidden" name="tAmt" value="400"> <!-- Total Amount -->
                <input type="hidden" name="amt" value="400"> <!-- Product Amount -->
                <input type="hidden" name="txAmt" value="0"> <!-- Tax Amount -->
                <input type="hidden" name="psc" value="0"> <!-- Service Charge -->
                <input type="hidden" name="pdc" value="0"> <!-- Delivery Charge -->
                <input type="hidden" name="scd" value="EPAYTEST"> <!-- Merchant Code -->
                <input type="hidden" name="pid" value="<?php echo uniqid('ESW-'); ?>"> <!-- Unique Order ID -->
                <input type="hidden" name="su" value="http://localhost/paymentintegration/esewa_success.php"> <!-- Success URL -->
                <input type="hidden" name="fu" value="http://localhost/paymentintegration/esewa_failure.php"> <!-- Failure URL -->
                <button type="submit" class="btn btn-esewa">Pay with eSewa</button>
            </form>
        </div>

        <!-- Logout Button -->
        <form method="POST">
            <button type="submit" name="logout" class="btn logout-btn">Logout</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Cosmo Quiz - Satwik Tripathi. All rights reserved.</p>
    </footer>

    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '1.00' // Amount in USD
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Send payment details to the server
                    fetch('payment_success.php', {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            orderID: data.orderID,
                            details: details
                        })
                    }).then(function(response) {
                        return response.json();
                    }).then(function(data) {
                        if (data.status === 'success') {
                            alert('Payment successful! Redirecting to quiz...');
                            window.location.href = 'quiz.php';
                        } else {
                            alert('Payment failed. Please contact support.');
                        }
                    });
                });
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>
