<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        require "cb_conn.php";
        $count = "SELECT COUNT(*) AS num_rows FROM news";
        $result1 = mysqli_query($conn, $count);
        $row1 = mysqli_fetch_assoc($result1);
        for($i = 0; $i < $row1["num_rows"]; $i++){
            $escape = mysqli_real_escape_string($conn, $i);
            $query = "SELECT * FROM news WHERE newsID='$i'";
            $send = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($send);

            echo $row["titel"] . "<br>";
        }
        $catcount = "SELECT COUNT(*) AS num_rows FROM kategories";
        $result2 = mysqli_query($conn, $catcount);
        $row2 = mysqli_fetch_assoc($result2);

        /*$catname = "SELECT name";
        for($y = 0; $y < $row2["num_rows"]; $y++){
            echo "<select name='sort' id='sort'>
            <option value=''"
        }*/
    
    ?>
</body>
</html>