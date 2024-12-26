<?php
session_start();
include 'dbconnect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected answer and the correct answer from the form
    $selectedAnswer = strtolower($_POST['user_answer']); // Convert to lowercase for case-insensitive comparison
    $correctAnswer = strtolower($_POST['correct_answer']); // Convert to lowercase for case-insensitive comparison

    // Check if the selected answer is correct
    if ($selectedAnswer === $correctAnswer) {
        // Increment the user's score (you may want to store this in the session)
        $_SESSION['score'] = isset($_SESSION['score']) ? $_SESSION['score'] + 1 : 1;
        $message = "Correct Answer!";
    } else {
        echo '<h2>Thank you for playing!</h2>';
        echo '<p>Your final score is: ' . (isset($_SESSION['score']) ? $_SESSION['score'] : '0') . '</p>';
        echo '<form method="POST" action="resetquiz.php">';
        echo '<br>' . '<button type="submit" name="play_again">Play Again</button>';
        echo '</form>';
    }
}
// Increment the question index for the next question
if (isset($_SESSION['questionIndex'])) {
    $_SESSION['questionIndex'] += 1;
} else {
    $_SESSION['questionIndex'] = 1; // Initialize question index if not set
}
// Redirect the user back to the quiz page
header('Location: quiz.php');
?>