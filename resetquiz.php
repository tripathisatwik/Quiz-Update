<?php
// Start the session
session_start();

// Reset session variables for the quiz
$_SESSION['questionIndex'] = 0; // Reset question index
$_SESSION['score'] = 0; // Reset score

// Redirect the user back to the quiz page to start again
header('Location: quiz.php');
?>
