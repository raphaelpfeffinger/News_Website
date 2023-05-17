<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<a href="index.php"><img src="logo.png" id="logo"></a>
<form action="register.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>
        <label for="anrede">Anrede:</label>
        <select name="anrede" id="anrede">
            <option value="Herr">Herr</option>
            <option value="Frau">Frau</option>
            <option value="Divers">Divers</option>
        </select><br>
        <label for="vorname">Vorname</label>
        <input type="text" name="vorname" id="vorname" required><br>
        <label for="nachname">Nachname</label>
        <input type="text" name="nachname" id="nachname" required><br>
        <label for="strasse">Strasse</label>
        <input type="text" name="strasse" id="strasse"><br>
        <label for="plz">PLZ</label>
        <input type="text" name="plz" id="plz"><br>
        <label for="ort">Ort</label>
        <input type="text" name="ort" id="ort"><br>
        <label for="land">Land</label>
        <input type="text" name="land" id="land"><br>
        <label for="telefon">Telefon</label>
        <input type="text" name="telefon" id="telefon"><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email"><br>
        <input type="submit" value="Register" name="submit"><br>
    </form>
    <a href="login.php">already registered?</a>;
    <?php require "cb_conn.php"; ?>
    <?php
    if(isset($_POST['submit'])){
        $password = $_POST['password'];
        $passwordhashed = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $conn -> prepare("INSERT INTO users (Benutzername, Passwort, Anrede, Vorname, Nachname, Strasse, PLZ, Ort, Land, EMail_Adresse, Telefon) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt -> bind_param("sssssssssss",$username, $passwordhashed, $anrede, $vorname, $nachname, $strasse, $plz, $ort, $land, $telefon, $email);
        $username = $_POST['username'];
      
        $anrede = $_POST['anrede'];
        $vorname = $_POST['vorname'];
        $nachname = $_POST['nachname'];
        $strasse = $_POST['strasse'];
        $plz = $_POST['plz'];
        $ort = $_POST['ort'];
        $land = $_POST['land'];
        $telefon = $_POST['telefon'];
        $email = $_POST['email'];
        
        $prove = $conn -> query("SELECT * FROM users WHERE Benutzername= '$username'");
        if(mysqli_num_rows($prove) == 0){
            $stmt -> execute();
        }
        else{
            echo "The username: $username, already exists";
        }
       


    }

    ?>
</body>
</html>