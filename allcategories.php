<?php session_start();
if($_SESSION["loggedin"] != true){
header("location: login.php");
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Alle Kategorien</title>
</head>
<body>
    <a href="index.php"><img src="raphi_logo.png" id="logo" width="12%"></a>
    <div id="makecat">
        <h1>Neue Kategorie</h1>
        <form method="post" action="allcategories.php">
            <br><label for="name" id="catname">Kategoriename:</label><br>
            <input type="text" name="name" id="kategorie" required><br><br>
            <input type="submit" name="sendcat" id="sendcat" value="Einfügen"><br>
            <a href='create_news.php'><-Zurück zu den News</a><br><br>
        </form>
        <a href='index.php' id='links'><-Home</a>
    </div>
    <?php 
    require "cb_conn.php";

    if(isset($_POST["sendcat"])){
        //falls eine neue kategorie erstellt werden soll
        $name = trim($_POST["name"]);

        //insert statement für tabelle kategories wird vorbereitet
        $insert = $conn -> prepare("INSERT INTO kategories(kategorie) VALUES(?)");
        $insert -> bind_param("s", $name);

        //es darf nicht 2 gleiche kategorien geben
        $queryprove = $conn -> query("SELECT kategorie FROM kategories WHERE kategorie = '$name'");
        if(mysqli_num_rows($queryprove) == 0){
            $insert -> execute();
            echo "<h4 id='success'>Die kategorie $name wurde erfolgreich eingefügt</h4>";
            header("Cache-Control: no-cache, must-revalidate");
        } else {
            echo "<h4>Diese Kategorie existiert bereits</h4>";
        }
        

    }
    $query = "SELECT * FROM kategories";
    $result = mysqli_query($conn, $query);

    //ein leerer array wird defniert
    $array = array();
    //es werden alle benutzten kategorie-ids aus der tabelle news genommen
    $queryprove = "SELECT kid FROM news";
        $resultprove = $conn -> query($queryprove);
        if($result ->num_rows > 0){
            while ($row = $resultprove->fetch_assoc()){
                //die benutzten id's werden in das array geschrieben
                $array[] = $row["kid"];
            }
        }

    if(isset($_POST["delcat"])){
        $deleteidcat = $_POST["delcatid"];
        //wenn der delete button gedrückt wird, wird überprüft, ob die zu löschende kategorie id in dem array ist
        if(! in_array($deleteidcat, $array)){
            //falls nicht wird sie gelöscht
            header("Cache-Control: no-cache, must-revalidate");
            $delete = $conn -> prepare("DELETE FROM kategories WHERE kid = ?");
            $delete -> bind_param("s", $deleteidcat);
            $delete -> execute();
        }
        else{
            echo "<h4>Diese Kategorie wird verwendet</4>";
        }
        
    } 

    //falls es kategorien gibt
    $prove = $conn -> query("SELECT * FROM kategories");
    //es werden alle kategorien ausgegeben
    if(mysqli_num_rows($prove)> 0){
        echo "<h1>alle Kategorien:</h1><table id='cattable'>
        <tr>
            <th>Kategorien</th>
            <th>löschen</th>
        </tr>";
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
    //falls es keine kategorien gibt im moment
} else{
    echo "<h1>Keine Kategorien...</h1>";
}
    
    
    
    ?>
</body>
</html>