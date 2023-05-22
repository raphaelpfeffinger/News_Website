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
            <label for="username">Username</label><br>
            <input type="text" name="username" id="username" required><br><br>
            
            <label for="password">Password</label><br>
            
            <input type="password" name="password" id="password" required><br><br>
            
            <div id="register">
                <input type="submit" value="Login" name="submit" id="letsgo">
                <a href="register.php" id="signup">Sign up</a>
            </div>
        </form>
    </div>
    
    <?php
    require "cb_conn.php";
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $prove = $conn -> query("SELECT * FROM users WHERE Benutzername = '$username'");
        if(mysqli_num_rows($prove) > 0){
            $query = "SELECT * FROM users WHERE Benutzername = '$username'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $hash = $row['Passwort'];
            $userId = $row['uid'];

            if (password_verify($password, $hash)) {
                $_SESSION["Benutzername"] = $username;
                $_SESSION["loggedin"] = true;
                $_SESSION["userid"] = $userId;
                header("location: index.php");
            } else {
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