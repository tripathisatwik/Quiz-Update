<!DOCTYPE html>
<html lang="en">
<head>
    <title>Insert Question</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        h1 {
            font-size: 28px;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 90%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"],button{
            background-color: #007BFF;
            color: #fff;
            border: none;s
            border-radius: 5px;
            padding: 10px 20px;
            margin-top: 10px;
            cursor: pointer;
        }

        input[type="submit"]:hover, button:hover{
            background-color: #0056b3;
        }

    </style>
</head>

<body>
    <header>
        <h1>Insert Question</h1>
    </header>
    <main>
        <div class="form-container">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Connect to the database
                include 'dbconnect.php';
                // Retrieve question data from the form
                $questionText = $_POST['questiontext'];
                $option1 = $_POST['option1'];
                $option2 = $_POST['option2'];
                $option3 = $_POST['option3'];
                $option4 = $_POST['option4'];
                $correctOption = $_POST['correct_option'];

                // Insert the question into the database
                $query = "INSERT INTO `question`(`questiontext`, `optiona`, `optionb`, `optionc`, `optiond`, `correctoption`) VALUES ('$questionText', '$option1', '$option2', '$option3', '$option4', '$correctOption')";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    echo "Question inserted successfully!";
                } else {
                    echo "Question not inserted";
                }
            }
            ?>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <label for="question_text">Question Text:</label>
                <input type="text" id="questiontext" name="questiontext" required><br>

                <label for="option1">Option 1:</label>
                <input type="text" id="option1" name="option1" required><br>

                <label for="option2">Option 2:</label>
                <input type="text" id="option2" name="option2" required><br>

                <label for="option3">Option 3:</label>
                <input type="text" id="option3" name="option3" required><br>

                <label for="option4">Option 4:</label>
                <input type="text" id="option4" name="option4" required><br>

                <label for="correct_option">Correct Answer:</label>
                <input type="text" id="correct_option" name="correct_option" required><br>

                <input type="submit" value="Insert Question">
               <button><a href="http://localhost/paymentintegration/adminlanding.php">Done</a></button>
            </form>
        </div>
    </main>
</body>

</html>