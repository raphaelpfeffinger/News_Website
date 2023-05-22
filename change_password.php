<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passwort Ändern</title>
</head>
<body>
    <div id="changep" name="changep">
        <form action="change_password.php" method="post">
            <label for="firstpw">Please enter your old Password</label><br>
            <input type="password" name="firstpw" id="firstpw"><br>
            <label for="changepw">Please enter your new Password</label><br>
            <input type="password" name="changepw" id="changepw">
            <input type="submit" name="send" id="send">
        </form>

        <?php 
        if(isset($_POST["senden"])){
           
        }
        ?>
    </div>
</body>
</html>