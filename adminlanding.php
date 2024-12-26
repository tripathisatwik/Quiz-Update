<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h1 {
            font-size: 36px;
            color: #007BFF;
            margin-top: 50px;
        }

        h2 {
            font-size: 24px;
            margin-top: 20px;
        }

        a {
            text-decoration: none;
            font-size: 18px;
            color: #007BFF;
        }

        a:hover {
            color: #0056b3;
        }

        button {
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            margin-top: 20px;
        }

        button a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }

        button a:hover {
            color: #fff;
        }
    </style>
</head>

<body>
    <?php
    include 'dbconnect.php';
    session_start();
    $profile = $_SESSION['Login_session'];
    if ($profile == true) {

    } else {
        header('location:http://localhost/paymentintegration/adminlogin.php');
    }
    $sql = "select * from user where username='$profile'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    echo "<h1>Welcome, Admin</h1>";
    echo "<h2>What would you like to do today?</h2>";
    ?>
    <a href="questionupload.php">Upload Questions</a><br>
    <a href="modifyquestion.php">Modify Questions</a><br>
    <button>
        <a href="logout.php">Logout</a>
    </button>
</body>

</html>
