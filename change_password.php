<?php session_start();
if($_SESSION["loggedin"] != true){
    header("location: login.php");
}
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
        <a href='index.php'><-Home</a>
    </div>

    <?php 
    require "cb_conn.php";
    //wenn der submit button gedrückt wurde
    if(isset($_POST["send"])){
        //benutzername wird aus der session genommen und als bedingung für den select befehl benutzt
        $username = $_SESSION["Benutzername"];
        $query = "SELECT * FROM users WHERE Benutzername = '$username'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        //erstes passwort aus dem form
        $firstpw = trim($_POST["firstpw"]);
        //passwort aus der datenbank
        $hash = $row["Passwort"];
        //neues passwort
        $changepw = trim($_POST["changepw"]);
        
        //altes passwort darf nicht das gleiche wie das alte sein
        if($firstpw != $changepw){
            //das alte wird mit dem hash abgeglichen
            if(password_verify($firstpw, $hash)){
                //falls es stimmt wird das neue gehashed
                $changehash = password_hash($changepw, PASSWORD_DEFAULT);
                $query = $conn -> prepare("UPDATE users SET Passwort = ? WHERE Benutzername = ?");
                $query -> bind_param("ss", $changehash, $username);
                $query -> execute();
                if($query -> execute()){
                    unset($_SESSION["loggedin"]);
                    session_destroy();
                    header("location: index.php");
                }
            } else{
            echo "<h4>wrong password</h4>";
            }
        } else{
            echo "<h4>your new password can't be the same as the old</h4>";
        }
    }
    ?>
</body>
</html>