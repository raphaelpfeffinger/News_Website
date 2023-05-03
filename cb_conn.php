<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Connection</title>
    </head>
    <body>
        <?php
        $servername = "localhost:3306";
        $username = "root";
        $password = "";
        $dbname = "news";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " .$conn->connect_error);
        }
        
        ?>
    </body>
</html>