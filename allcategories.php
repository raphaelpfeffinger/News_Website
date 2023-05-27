<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>All Categories</title>
</head>
<body>
    <a href="index.php"><img src="raphi_logo.png" id="logo" width="12%"></a>
    <a href="create_news.php"><-Zurück zu den News</a>
    <form method="post" action="allcategories.php">
        <label for="name">Kategorie</label><br>
        <input type="text" name="name" id="kategorie" required><br>
        <input type="submit" name="sendcat" id="sendcat"><br>
    </form>

    <?php 
    require "cb_conn.php";

    if(isset($_POST["sendcat"])){
        $name = $_POST["name"];

        $insert = $conn -> prepare("INSERT INTO kategories(kategorie) VALUES(?)");
        $insert -> bind_param("s", $name);

        $queryprove = $conn -> query("SELECT kategorie FROM kategories WHERE kategorie = '$name'");
        if(mysqli_num_rows($queryprove) == 0){
            $insert -> execute();
            echo "Die kategorie $name wurde erfolgreich eingefügt";
            header("Cache-Control: no-cache, must-revalidate");
        } else {
            echo "Diese Kategorie existiert bereits";
        }
        

    }

    $query = "SELECT * FROM kategories";
    echo "<table id='cattable'>
    <tr>
        <th>Kategorien</th>
        <th>löschen</th>
    </tr>";
    $result = mysqli_query($conn, $query);
    foreach($result as $i){
        $idcat = $i["kid"];
        $category = $i["kategorie"];
            echo "<tr>
            <td>$category</td>
            <td><form action='allcategories.php' method='post'>
            <input type='submit' name='delcat' id='delcat'>
            <input type='hidden' name='delcatid' id='delcatid' value='$idcat'>
            </form></td>
        </tr>";
        
    }
    echo "</table><br>";
    $array = array();
    $queryprove = "SELECT kid FROM news";
        $resultprove = $conn -> query($queryprove);
        if($result ->num_rows > 0){
            while ($row = $resultprove->fetch_assoc()){
                $array[] = $row["kid"];
            }
        }
    if(isset($_POST["delcat"])){
        $deleteidcat = $_POST["delcatid"];
        if(! in_array($deleteidcat, $array)){
            header("Cache-Control: no-cache, must-revalidate");
            $delete = $conn -> prepare("DELETE FROM kategories WHERE kid = ?");
            $delete -> bind_param("s", $deleteidcat);
            $delete -> execute();
        }
        else{
            echo "<h4>Diese Kategorie wird verwendet</4>";
        }
        
    } 
    
    
    
    ?>
</body>
</html>