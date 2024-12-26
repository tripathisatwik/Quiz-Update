<?php
include "dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $question_id = $_GET["id"];
    // Perform the deletion here using $question_id
    $sql = "DELETE FROM question WHERE id = $question_id";
    if (mysqli_query($conn, $sql)) {
        echo '<center>';
        echo "Question deleted successfully! <br>";
        echo '<a href="http://localhost/paymentintegration/adminlanding.php"><button>Back to HomePage</button></a>';
        echo '</center>';
    } else {
        echo "Error deleting question: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>