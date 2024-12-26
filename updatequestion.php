<?php
include "dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $question_id = $_GET["id"];
    
    // Fetch the question details from the database
    $sql = "SELECT * FROM question WHERE id = $question_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $id = $row['id']; 
        ?>
        <!DOCTYPE html>
        <html>
        <head>
        <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f0f0f0;
                    padding: 20px;
                    text-align: center;
                }

                h2 {
                    font-size: 24px;
                    margin-top: 20px;
                }

                table {
                    border-collapse: collapse;
                    width: 80%;
                    margin: 20px auto;
                }

                table,
                th,
                td {
                    border: 1px solid #ccc;
                }

                th,
                td {
                    padding: 10px;
                    text-align: center;
                }

                th {
                    background-color: #007BFF;
                    color: white;
                    font-weight: bold;
                }

                tr:nth-child(even) {
                    background-color: #f2f2f2;
                }

                tr:hover {
                    background-color: #ddd;
                }

                a {
                    text-decoration: none;
                    color: #007BFF;
                }

                a:hover {
                    color: #0056b3;
                }
            </style>
        </head>
        <body>
            <div>
                <h2>Update Question</h2>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <label for="new_question_text">New Question Text:</label>
                    <input type="text" id="new_question_text" name="new_question_text" required><br>

                    <label for="new_option_a">New Option A:</label>
                    <input type="text" id="new_option_a" name="new_option_a" required><br>

                    <label for="new_option_b">New Option B:</label>
                    <input type="text" id="new_option_b" name="new_option_b" required><br>

                    <label for="new_option_c">New Option C:</label>
                    <input type="text" id="new_option_c" name="new_option_c" required><br>

                    <label for="new_option_d">New Option D:</label>
                    <input type="text" id="new_option_d" name="new_option_d" required><br>

                    <label for="new_correct_option">New Correct Answer:</label>
                    <input type="text" id="new_correct_option" name="new_correct_option" required><br>

                    <input type="submit" value="Update Question">
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Question not found.";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $question_id = $_POST["id"];
    $newQuestionText = $_POST['new_question_text'];

    // Update the question in the database
    $updateQuery = "UPDATE question SET
        questiontext = '$newQuestionText'
        WHERE id = $question_id";
    $updateResult = mysqli_query($conn, $updateQuery);
    if ($updateResult) {
        echo '<center>';
        echo "Question updated successfully! <br>";
        echo '<a href="http://localhost/paymentintegration/adminlanding.php"><button>Back to HomePage</button></a>';
        echo '</center>';
    } else {
        echo "Error updating question: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>