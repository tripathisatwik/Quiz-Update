<?php
include 'dbconnect.php';
if (isset($_POST['submit'])) {
    $name = $_POST["uname"];
    $age = $_POST["age"];
    $username = $_POST["username"];
    $password = $_POST["password"];


    $username_query = "SELECT username FROM user where username='$username'";
    $db_usernames_query = mysqli_query($conn, $username_query);

    if (mysqli_num_rows($db_usernames_query) > 0) {
        echo "<p class='register-unsuccess'>This username already exists. Please enter another username to register. Registration Unsuccessful!</p>";
    } else {
        $sql = "INSERT INTO `user`(`id`, `name`, `age`, `highscore`, `username`, `password`) 
        values ('','$name','$age','','$username','$password')";
        $result = mysqli_query($conn, $sql);
        echo "<p class='account-created'>Your Account has been Created. <br>Click on LogIn</p>";
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>SignUp</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .formsheet {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
        }

        form {
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        hr {
            border: 1px solid #ccc;
        }

        .input-label {
            text-align: left;
            margin-left: 15px;
        }

        input[type="text"],
        input[type="number"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
            display: inline-block;
            margin-top: 10px;
        }

        a:hover {
            color: #0056b3;
        }

        .register-unsuccess {
            color: red;
            font-weight: bold;
        }

        .account-created {
            color: green;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="formsheet">
        <form action="" method="POST">
            <h1>SignUp</h1>
            <hr>
            <label class="input-label">Name</label>
            <input required type="text" name="uname" placeholder="Enter your Name"><br>
            <label class="input-label">Age</label>
            <input type="number" name="age" required><br>
            <label class="input-label">Username</label>
            <input type="text" name="username" required placeholder="Enter Username"><br>
            <label class="input-label">Password</label>
            <input type="password" name="password" required placeholder="Enter Password"><br>
            <input type="submit" name="submit" value="SignUp">
            <a href="index.php">LogIn</a>
        </form>
    </div>
</body>

</html>
