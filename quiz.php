<?php
session_start();
if (!isset($_SESSION['Login_session']) || !$_SESSION['has_paid']) {
    header("Location: paywall.php");
    exit;
}
include 'dbconnect.php';
$questionIndex = isset($_SESSION['questionIndex']) ? $_SESSION['questionIndex'] : 0;
$num = 0;
$score = isset($_SESSION['score']) ? $_SESSION['score'] : 0;
$selectedAnswer = '';
$correctAnswer = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedAnswer = strtolower($_POST['answer']);
    $correctAnswer = strtolower($_POST['correct_answer']);
    if ($selectedAnswer === $correctAnswer) {
        $score++;
        $_SESSION['score'] = $score;
    } else {
        echo '<div class="error-message">Incorrect answer!<br>
        Submitted Answer:'. $selectedAnswer. '<br>
        Correct Answer:' .$correctAnswer. '</div>';
    }
    $questionIndex++;
    $_SESSION['questionIndex'] = $questionIndex;
}
$query = "SELECT * FROM question LIMIT $questionIndex, 1";
$result = mysqli_query($conn, $query);
$num = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .error-message {
            position: absolute;
            top: 80%;
            left: 40%;
            right: 40%;
            background-color: #f00;
            color: #fff;
            padding: 5px;
            text-align: center;
            animation: showErrorMessage 2s linear;
            opacity: 0;
            border-radius: 35%;
        }
        @keyframes showErrorMessage {
            0% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
        main {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .quiz-container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        #question-container {
            margin-bottom: 20px;
        }

        #question-container h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        #question-container ul {
            list-style-type: none;
            padding: 0;
        }
        #question-container li {
            margin-bottom: 10px;
        }
        #question-container input[type="radio"] {
            margin-right: 10px;
        }
        #score-container {
            text-align: left; /* Move score to the left */
            font-size: 18px;
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #333;
            color: #fff;
            padding: 5px 10px;
            border-radius: 0 0 5px 0;
        }
        form button[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        form[name="play_again"] button[type="submit"] {
            margin: 1rem;
            background-color: #f00;
        }
        #question-container {
            position: relative;
            margin-bottom: 20px;
        }
        /* Logout Button Styling */
        .logout-button {
            background-color: #f00;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 10px; /* Position at the top-right corner */
        }
    </style>
</head>
<body>
    <header>
        <h1>Quiz App</h1>
    </header>
    <main>
        <div class="quiz-container">
            <div id="question-container">
                <?php
                if ($num > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<h2>' . $row['questiontext'] . '</h2>';
                        echo '<form method="POST" action="quiz.php">';
                        echo '<ul>';
                        for ($i = 'a'; $i <= 'd'; $i++) {
                            $optionKey = 'option' . $i;
                            $value = $i;
                            $isChecked = ($selectedAnswer === $value) ? 'checked' : '';
                            echo '<li><input type="radio" name="answer" value="' . $value . '" ' . $isChecked . '>' . $row[$optionKey] . '</li>';
                        }
                        echo '</ul>';
                        echo '<input type="hidden" name="correct_answer" value="' . $row['correctoption'] . '">';
                        echo '<button type="submit">Submit Answer</button>';
                        echo '</form>';
                    }
                } else {
                    echo '<h2>Thank you for playing!</h2>';
                    echo '<p>Your final score is: ' . $score . '</p>';
                    echo '<form method="POST" action="resetquiz.php">';
                    echo '<br>' . '<button type="submit" name="play_again">Play Again</button>';
                    echo '</form>';
                }
                ?>
            </div>
            <!-- Score moved to top-left -->
            <div id="score-container">
                Score: <?php echo $score; ?>
            </div>
            <!-- Logout Button positioned at top-right -->
            <form method="POST" action="logout.php">
                <button type="submit" class="logout-button">Logout</button>
            </form>
        </div>
    </main>
</body>
</html>
