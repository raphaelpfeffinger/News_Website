<?php session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Passwort Ändern</title>
</head>
<body>
    <a href="index.php"><img src="raphi_logo.png" id="logo" width="12%"></a>
    <div id="changep" name="changep">
        <form action="change_password.php" method="post">
            <h1>Passwort ändern</h1>
            <label for="firstpw">Altes Passwort:</label><br>
            <input type="password" name="firstpw" id="firstpw"><br><br>
            <label for="changepw">Neues Passwort:</label><br>
            <input type="password" name="changepw" id="changepw"><br><br>
            <input type="submit" name="send" id="send" value="Ändern">
        </form>
    </div>

    <?php 
    require "cb_conn.php";
    if(isset($_POST["send"])){
        print_r($_SESSION);
        $username = $_SESSION["Benutzername"];
        $query = "SELECT * FROM users WHERE Benutzername = '$username'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);


        $firstpw = $_POST["firstpw"];
        $hash = $row["Passwort"];
        $changepw = $_POST["changepw"];
        
        if($firstpw != $changepw){
            if(password_verify($firstpw, $hash)){
                $changehash = password_hash($changepw, PASSWORD_DEFAULT);
                $query = $conn -> prepare("UPDATE users SET Passwort = ? WHERE Benutzername = ?");
                $query -> bind_param("ss", $changehash, $username);
                $query -> execute();
                if($query -> execute()){
                    unset($_SESSION["loggedin"]);
                    session_destroy();
                    header("location: index.php");
                }
            } 
        
            else{
            echo "wrong password";
            }
        } else{
            echo "your new password can't be the same as the old";
        }
    }
    ?>
</body>
</html>