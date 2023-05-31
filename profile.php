<?php session_start();
//bei jeder seite wird überprüft ob der user angemeldet ist
//falls nicht wird er zum login weitergeleitet
if($_SESSION["loggedin"] != true){
    header("location: login.php");
}else{
require "cb_conn.php";
$username = $_SESSION["Benutzername"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Profil</title>
</head>
<body>
<a href="index.php"><img src="raphi_logo.png" id="logo" width="12%"></a>
<div id='profile' name='profile'>
    <h1>Dein Profil</h1><br>
    <h2>Hallo <?php echo $username; ?></h2>
    <a href='change_password.php'>Passwort ändern -></a><br><br>
    <a href='index.php'><-zurück zum Start</a>

    </form>
</div>

    
</body>
</html>