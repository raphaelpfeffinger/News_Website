<?php session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Index</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <a href="index.php">Home</a>
        <a href="index.php"><img src="logo.png" id="logo"></a>
        <a href="archive.php">Archive</a>
        

        <?php
        require "cb_conn.php";
        if(! isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] = 0){
            echo "<a href='login.php'>Login</a><br>";
            echo "<a href='register.php'>Register</a>";
        } else if($_SESSION["loggedin"] = 1){
            echo "<a href='create_news.php'>make news</a>";
            echo "<form action='index.php' method='post'>
            <input type='submit' name='logout' id='logout' value='logout'>
            </form>";
            if(isset($_POST["logout"])){
                $_SESSION = array();
                unset($_SESSION["loggedin"]);
                unset($_SESSION["Benutzername"]);
                session_destroy();
            }
        } 
        

        ?>
    </body>
</html>