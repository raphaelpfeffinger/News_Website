<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="register.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <label for="anrede">Anrede:</label>
        <select name="anrede" id="anrede">
            <option value="Herr">Herr</option>
            <option value="Frau">Frau</option>
            <option value="Divers">Divers</option>
        </select>
        <label for="vorname">Vorname</label>
        <input type="text" name="vorname" id="vorname" required>
        <label for="nachname">Nachname</label>
        <input type="text" name="nachname" id="nachname" required>
        <label for="strasse">Strasse</label>
        <input type="text" name="strasse" id="strasse">
        <label for="plz">PLZ</label>
        <input type="text" name="plz" id="plz">
        <label for="ort">Ort</label>
        <input type="text" name="ort" id="ort">
        <label for="land">Land</label>
        <input type="text" name="land" id="land">
        <label for="telefon">Telefon</label>
        <input type="text" name="telefon" id="telefon">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email">
        <input type="submit" value="Login" name="submit">
    </form>
    <?php require "cb_conn.php"; ?>
    <?php
    if(isset($_POST['submit'])){
        

        $stmt = $conn -> prepare("INSERT INTO users (Benutzername, Passwort, Anrede, Vorname, Nachname, Strasse, PLZ, Ort, Land, EMail_Adresse, Telefon) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt -> bind_param("sssssssssss",$username, $password, $anrede, $vorname, $nachname, $strasse, $plz, $ort, $land, $telefon, $email);
        $username = $_POST['username'];
        $password = $_POST['password'];
        $anrede = $_POST['anrede'];
        $vorname = $_POST['vorname'];
        $nachname = $_POST['nachname'];
        $strasse = $_POST['strasse'];
        $plz = $_POST['plz'];
        $ort = $_POST['ort'];
        $land = $_POST['land'];
        $telefon = $_POST['telefon'];
        $email = $_POST['email'];
        $password = hash("sha256", $password);
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