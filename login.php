<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">

    <title>Login</title>

</head>

<body>
    <a href="index.php"><img src="raphi_logo.png" id="logo" width="12%"></a>
    <div name="divlogin" id="divlogin">
        <form action="login.php" method="post">
            
            <h1 id="logintitle">Login</h1>
            <div id="label">
                <label for="username">Benutzername:</label><br>
            </div>
            <input type="text" name="username" id="username" required><br><br>
            <div id="label">
                <label for="password">Passwort:</label><br>
            </div>
            <input type="password" name="password" id="password" required><br><br>
            
            <div id="registerlink">
                <input type="submit" value="Login" name="submit" id="letsgo">
                <a href="register.php" id="signup">Registrieren-></a><br>
                <a href='index.php' id='links'><-Home</a>
            </div>
        </form>
    </div>
    
    <?php
    require "cb_conn.php";
    if (isset($_POST['submit'])) {
        //wenn der submit button gedrückt wurde werden benutzername und passwort aus dem formular definiert
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        //der Benutzer mit dem Namen wird aus der Tabelle genommen
        $prove = $conn -> query("SELECT Benutzername FROM users WHERE Benutzername = '$username'");

        //wenn die query höher als 0 ist
        if(mysqli_num_rows($prove) > 0){

            //alle nutzerdaten werden in variabeln gespeichert
            $query = "SELECT * FROM users WHERE Benutzername = '$username'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $hash = $row['Passwort'];
            $userId = $row["uid"];

            //das eingegebene Passwort wird mit dem hash abgegleicht
            if (password_verify($password, $hash)) {
                //falls das Passwort stimmt wird die Session gestartet
                $_SESSION["Benutzername"] = $username;
                $_SESSION["loggedin"] = true;
                $_SESSION["userid"] = $userId;
                header("location: index.php");
            } else {
                //falls nicht wird die Fehlermeldung angezeigt
                $_SESSION["Benutzername"] = "Nobody";
                $_SESSION["loggedin"] = false;
                echo "<h4>The Password or the Username is wrong</h4>";
            }
        } else{
            echo "<h4>The Password or Username are wrong</h4>";
        }
        
    }
    ?>
</body>

</html>