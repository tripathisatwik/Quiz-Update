<html>

<head>
    <title>Admin Login</title>
    <style>
        /* Body styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        /* Container for the login form */
        .userlogin {
            background-color: #fff;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
        /* Heading styles */
        h2 {
            color: #333;
        }
        /* Paragraph styles */
        p {
            color: #777;
        }
        /* Text input styles */
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        /* Button styles */
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background-color: blue;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 20px;
            cursor: pointer;
        }
        /* Button hover effect */
        input[type="submit"]:hover {
            background-color: #0073e6;
        }
        img {
            height: 10rem;
        }
    </style>
</head>

<body>
    <div class="userlogin">
        <form action="" method="POST">
            <h2>LOGIN</h2>
            <p>Enter your Username and Password</p>
            USERNAME <br> <input type="text" name="username" placeholder="Enter your Username">
            <br>
            PASSWORD <br> <input type="password" name="password">
            <br>
            <input type="submit" name="submit" value="LogIn">

        </form>
        <?php
        include 'dbconnect.php';
        session_start();
        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $sql = "select * from admin where username='$username' and password='$password'";
            $result = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($result);
            if ($num == 1) {
                $_SESSION['Login_session'] = $username;
                echo "Login Sucess";
                header("Location:http://localhost/paymentintegration/adminlanding.php");

            } else {
                echo "invalid user";
            }
        }
        ?>
</body>

</html>