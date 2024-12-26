<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
</head>
<body>
    <h2>Payment Failed</h2>
    <p>Unfortunately, your payment could not be processed. Please try again.</p>
    <a href="paywall.php">Go Back to Paywall</a>
</body>
</html>
