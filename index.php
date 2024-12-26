<html>

<head>
    <title>User Login</title>
    <style>
        /* userlogin.css */

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
        }

        .extra {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 1rem;
        }

        .outer {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            width: 300px;
        }

        .userlogin h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .userlogin p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .userlogin input[type="text"],
        .userlogin input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 10px;
        }

        .userlogin input[type="submit"] {
            width: 70%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .userlogin input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .adminlogin-btn {
            width: 70%;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .adminlogin-btn:hover {
            background-color: #218838;
        }

        .usersignup {
            text-align: center;
            margin-top: 20px;
        }

        .usersignup img {
            paddding: 20px;
            max-width: 100px;
            max-height: 100px;
            margin-bottom: 10px;
        }

        .usersignup h3 a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        .usersignup h3 a:hover {
            color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="extra">
        <div class="outer">
            <h2>Cosmo Quiz</h2>
            <div class="userlogin">
                <form action="" method="POST">
                    <h2>LOGIN</h2>
                    <p>Enter your Username and Password</p>
                    USERNAME <br> <input type="text" name="username" placeholder="Enter your Username">
                    <br>
                    PASSWORD <br> <input type="password" name="password">
                    <br>
                    <input type="submit" name="submit" value="LogIn"
                        style="font-size:20px; background-color:blue; color:white; text-align:center; border=0; border-radius:5px;">
                </form>
                <form action="adminlogin.php" method="get">
                    <button type="submit" class="adminlogin-btn">Admin Login</button>
                </form>
            </div>
            <div class="usersignup">
                <img src="12.jpg" alt="User">
                <h3><a href="signup.php">Don't have Any Account?</a></h3>
            </div>
        </div>
    </div>

    <?php
session_start();
require 'dbconnect.php';

// If user is already logged in, redirect to appropriate page
if (isset($_SESSION['Login_session'])) {
    if ($_SESSION['has_paid']) {
        header("Location: quiz.php");
        exit;
    } else {
        header("Location: paywall.php");
        exit;
    }
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check user credentials
    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        // Successful login
        $row = mysqli_fetch_assoc($result);
        $_SESSION['Login_session'] = $username;
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['has_paid'] = $row['has_paid'];

        if ($row['has_paid']) {
            header("Location: quiz.php"); // User has paid
        } else {
            header("Location: paywall.php"); // User has not paid
        }
        exit;
    } else {
        // Invalid login credentials
        echo "Invalid username or password.";
    }
}
?>

</body>

</html>
