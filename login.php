<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <input type="submit" value="Login" name="submit">
    </form>
    <? require "cb_conn.php"; ?>
    <?php
    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password = password_hash($password, "md5");

    }
    ?>
</body>
</html>