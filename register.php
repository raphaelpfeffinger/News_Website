<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Registrieren</title>
</head>
<body>
<a href="index.php"><img src="raphi_logo.png" id="logo" width="12%"></a>
<div id="register">
    <form action="register.php" method="post">
            <h1>Register</h1><br>
            <label for="username" id="labelreg">*Benutzername:</label>
            <input type="text" name="username" id="username" required maxlength="20"><br><br>
            <label for="password" id="labelreg">*Passwort:</label>
            <input type="password" name="password" id="password" required><br><br><br>
            <label for="vorname">*Vorname:</label>
            <input type="text" name="vorname" id="vorname" required><br><br>
            <label for="nachname">*Nachname:</label>
            <input type="text" name="nachname" id="nachname" required><br><br>
            <label for="anrede">Anrede:</label>
            <select name="anrede" id="anrede">
                <option value="Herr">Herr</option>
                <option value="Frau">Frau</option>
                <option value="Divers" selected>Divers</option>
            </select><br><br>
            <label for="strasse">Strasse:</label>
            <input type="text" name="strasse" id="strasse"><br><br>
            <label for="plz">PLZ:</label>
            <input type="text" name="plz" id="plz"><br><br>
            <label for="ort">Ort:</label>
            <input type="text" name="ort" id="ort"><br><br>
            <label for="land">Land:</label>
            <input type="text" name="land" id="land"><br><br>
            <label for="telefon">Telefon</label>
            <input type="text" name="telefon" id="telefon"><br><br>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email"><br><br>
            <input type="submit" value="Register" name="submit">
            <a href="login.php">Schon registriert?</a><br><br>
            <a href='index.php' id='links'><-Home</a>
        </form>
    </div>
    <?php require "cb_conn.php";
    if(isset($_POST['submit'])){
        //der Benutzername und das Passwort werden definiert
        $password = $_POST['password'];
        $username = $_POST['username'];
        //die länge wird in variabeln gespeichert um eine mindestlänge festzulegen
        $passwordlen = strlen($password);
        $usernamelen = strlen($username);

        //mindestlänge wird geprüft
        if(strpos($email, "@") == false){
            echo "<h4>Email braucht ein @-Zeichen</h4>";
        } else{
            if($usernamelen < 2){
            echo "<h4>Benutzername darf nicht mehr als 20 Zeichen und nicht weniger als 2 zeichen haben!!</h4>";
            } elseif($passwordlen < 8){
                echo "<h4>Passwort muss mindestens 8 Zeichen haben!!</h4>";
            } 
            //fals die länge stimt
            else{

                //passwort wird gehashed
                $passwordhashed = password_hash($password, PASSWORD_DEFAULT);
                
                //der insert befehl in die Datenbank wird vorbereitet
                $stmt = $conn -> prepare("INSERT INTO users (Benutzername, Passwort, Anrede, Vorname, Nachname, Strasse, PLZ, Ort, Land, EMail_Adresse, Telefon) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt -> bind_param("sssssssssss",$username, $passwordhashed, $anrede, $vorname, $nachname, $strasse, $plz, $ort, $land, $email, $telefon);
            
                //die Werte des Formulars werden in Variabeln gespeichert
                //unnötige Leerzeichen werden entfernt
                $anrede = trim($_POST['anrede']);
                $vorname = trim($_POST['vorname']);
                $nachname = trim($_POST['nachname']);
                $strasse = trim($_POST['strasse']);
                $plz = trim($_POST['plz']);
                $ort = trim($_POST['ort']);
                $land = trim($_POST['land']);
                $telefon = $_POST['telefon'];
                //da die telefon nummer mehr als leerzeichen am ende und anfang haben müssen sie alle gelöscht werden
                $telefon = str_replace(' ', '', $telefon);
                $email = trim($_POST['email']);

                

                

                
                //es wird überprüft ob der Benutzername bereits existiert
                $prove = $conn -> query("SELECT * FROM users WHERE Benutzername= '$username'");
                if(mysqli_num_rows($prove) == 0){
                    //falls nicht wird es in die datenbank eingefügt
                    $stmt -> execute();

                    //query für die Session variable userid
                    $query = "SELECT * FROM users WHERE Benutzername = '$username'";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $userIdreg = $row["uid"];

                    //session variabeln werden definiert
                    $_SESSION["Benutzername"] = $username;
                    $_SESSION["loggedin"] = true;
                    $_SESSION["userid"] = $userIdreg;
                    header("location: index.php");
                }
                else{
                    //wird angezeigt falls der Benutzername schon existiert
                    echo "<h4>Der Benutzername: $username, existiert bereits!</h4>";
                    $_SESSION["Benutzername"] = "nobody";
                    $_SESSION["loggedin"] = false;

                }
            }
        }
    }
    ?>
</body>
</html>