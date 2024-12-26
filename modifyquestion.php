<!DOCTYPE html>
<html>

<head>
    <style>
        /* style.css */

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
    <?php
    include "dbconnect.php";
    $sql = "SELECT * FROM question";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "<div>
        <h2>Questions</h2>
        <table border='1'>
            <tr>
                <th>Question</th>
                <th>Option A</th>
                <th>Option B</th>
                <th>Option C</th>
                <th>Option D</th>
                <th>Correct Option</th>
                <th>Action</th>
            </tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td>
                    <?php echo $row['questiontext']; ?>
                </td>
                <td>
                    <?php echo $row['optiona']; ?>
                </td>
                <td>
                    <?php echo $row['optionb']; ?>
                </td>
                <td>
                    <?php echo $row['optionc']; ?>
                </td>
                <td>
                    <?php echo $row['optiond']; ?>
                </td>
                <td>
                    <?php echo $row['correctoption']; ?>
                </td>
                <td> <a href='updatequestion.php?id=<?php echo $row['id']; ?>'>Update</a><br>
                <a href='deletequestion.php?id=<?php echo $row['id']; ?>'>Delete</a></td>
            </tr>
            <?php
        }
        echo "</table></div>";
    } else {
        echo "No records found.";
    }
    mysqli_close($conn);
    ?>
</body>

</html>
