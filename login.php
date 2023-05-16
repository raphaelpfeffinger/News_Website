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
    <a href="index.php"><img src="logo.png" id="logo" width="6%"></a>
    <div name="divlogin" id="divlogin">
        <form action="login.php" method="post">
            <div id="login">
                <h1 id="logintitle">LOGIN</h1>
                <div id="label" name="label">
                    <label for="username">Username</label><br>
                </div>
                <input type="text" name="username" id="username" required><br>
                <div id="label2" name="label2">
                    <label for="password">Password</label><br>
                </div>
                <input type="password" name="password" id="password" required><br>
                <div id="submit">
                    <input type="submit" value="Login" name="submit" id="letsgo">
                </div>
                <a href="register.php">Sign up</a>
            </div>
        </form>
    </div>
    
    <?php
    require "cb_conn.php";
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = "SELECT * FROM users WHERE Benutzername = '$username'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $hash = $row['Passwort'];

        if (password_verify($password, $hash)) {
            $_SESSION["Benutzername"] = $username;
            $_SESSION["loggedin"] = true;
            header("location: index.php");
        } else {
            $_SESSION["Benutzername"] = "Nobody";
            $_SESSION["loggedin"] = false;
            echo "fml";
        }
    }
    ?>
</body>

</html>