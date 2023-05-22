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
        <a href="index.php"><img src="raphi_logo.png" id="logo" width="12%"></a>
        <?php
        require "cb_conn.php";
        if(! isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] = 0){
            echo "<div id='loginpages'>
            <a href='index.php' id='links'>Home</a>
            <a href='login.php' id='links'>Login</a>
            <a href='register.php' id='links'>Register</a>
            <a href='archive.php' id='links'>Archive</a>
            </div>";
        } else if($_SESSION["loggedin"] = 1){
            echo "<div id='loggedinpages'>
            <a href='create_news.php'>make news</a>
            <form action='index.php' method='post'>
            <input type='submit' name='logout' id='logout' value='logout'>
            </form>
            <a href='archive.php'>Archive</a>
            </div>";
            echo "<a href='change_password.php'>change password</a>";
            if(isset($_POST["logout"])){
                $_SESSION = array();
                unset($_SESSION["loggedin"]);
                unset($_SESSION["Benutzername"]);
                session_destroy();
            }
            
                
        }
           
        $count = "SELECT COUNT(*) AS num_rows FROM news";
        $result1 = mysqli_query($conn, $count);
        $row = mysqli_fetch_assoc($result1);
        $currentdate = date("Y-m-d");
        echo $row["num_rows"];
        
        for($i = 1; $i < $row["num_rows"]; $i++) {

            $escape = mysqli_real_escape_string($conn, $i);
            $correct = "SELECT * FROM news WHERE gueltigBis >= '$currentdate' AND newsID = '$i' AND gueltigVon <= '$currentdate'";
            $result = mysqli_query($conn, $correct);
            
            if($result && mysqli_num_rows($result) > 0){
                $query = mysqli_fetch_assoc($result);
                echo $query["titel"] . $query["inhalt"] . "<br>";
            } 
            
            
        }
        
        

        ?>
    </body>
</html>