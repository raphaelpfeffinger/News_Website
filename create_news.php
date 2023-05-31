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
    <title>News erstellen</title>
</head>
<body>
<a href="index.php"><img src="raphi_logo.png" id="logo" width="12%"></a>
    <div id="createnews">
        <h1 id="newstitle">Neue News erstellen:</h1>
        <form id="news" action="create_news.php" method="post">
            <table id="createnewstable">
                <tr id="clines">
                    <td id="ccells"><label for="title">Titel:</label></td>
                    <td id="ccells"><input type="text" name="title" id="title" maxlength="20" required><br></td>
                </tr>
                <tr id="clines">
                    <td id="ccells"><label for="content">Inhalt:</label></td>
                    <td id="ccells"><textarea name="content" id="content" cols="30" rows="10" required></textarea></td><br>
                </tr>
                <tr id="clines">
                    <td id="ccells"><label for="datefrom">Gültig von:</label></td>
                    <td id="ccells"><input type="date" name="datefrom" id="datefrom" required><br></td>
                </tr>
                <tr id="clines">
                    <td id="ccells"><label for="dateto">bis: </label></td>
                    <td id="ccells"><input type="date" name="dateto" id="dateto" required></td><br>
                </tr>
                <tr id="clines">
                    <td id="ccells"><label for="catlist">Kategorie:</label></td>
                    <?php require "cb_conn.php";
                    //es werden alle kategorien genommen
                    $catquery= "SELECT * FROM kategories";
                    $catresult = mysqli_query($conn, $catquery);
                    //es wird ein select befehl geöffnet
                    echo "<td id='ccells'><select id='catlist' name='catlist'>";
                    foreach($catresult as $i){
                        //mit der foreach wird catoption einmal jeder eintrag
                        $catoption = $i["kategorie"];
                        //die optionen für die dropdown sind alle kategorien
                        echo "<option value='$catoption'>$catoption</option>";
                    } 
                    echo "</select></td>";?>
                    <td id="ccells"><a href="allcategories.php">Neue Kategorie erstellen</a></td><br>
                </tr>
                <tr id="clines">
                    <td id="ccells"><label for="img">Bild(als Link einfügen):</label></td>
                    <td id="ccells"><input type="url" id="img" name="img" required></td><br>
                </tr>
                <tr id="clines">
                    <td id="ccells"><label for="link" >Quelle einfügen:</label></td>
                    <td id="ccells"><input type="url" id="source" name="source" required></td><br>
                </tr>
            
            </table><br><br>
            <input type="submit" name="submit" id="submit">
        </form>
        <a href='index.php' id='links'><-Home</a>
    </div>


        <?php
        require "cb_conn.php";
        if(isset($_POST["submit"])){
            //die länge des Titels wird in einer Variable gespeichert
            $title = trim($_POST["title"]);
            $titlelen = strlen($title);

            //der titel darf nicht unter 3 zeichen und nicht über 15 Zeichen sein
            if($titlelen < 3 || $titlelen > 15){
                echo "<h4>Titel darf nicht kleiner als 3 und nicht grösser als 15 Buchstaben sein!</h4>";
            }else{
                
                //das insert wird als prepared statement vorbereitet
                $input = $conn -> prepare("INSERT INTO news(titel, inhalt, gueltigVon, gueltigBis, erstelltam, kid, link, bild, autor) VALUES(?,?,?,?,?,?,?,?,?)");
                $input -> bind_param("sssssssss", $title, $content, $datefrom, $dateto, $CurrentDate, $kid, $source, $image, $autor);

                //variabeln werden wieder getrimmt und aus dem form definiert
                $content = trim($_POST["content"]);
                $datefrom = trim($_POST["datefrom"]);
                $dateto = trim($_POST["dateto"]);
                $category = trim($_POST["catlist"]);
                $CurrentDate = date("Y-m-d");
                $image = trim($_POST["img"]);
                $source = trim($_POST["source"]);
                $autor = trim($_SESSION["userid"]);

                //das gültigkeitsbis datum darf nicht kleiner sein als das gültigkeits von datum
                if($dateto < $CurrentDate && $dateto < $datefrom){
                    echo "<h4>Gültig von darf nicht kleiner sein als Gültig bis!!</h4>";
                }
                else{
                    
                    //die Kategorie wird per string wieder in id umgewandelt um eingefügt werden zu können
                    $catid = "SELECT kid FROM kategories WHERE kategorie = '$category'";
                    $query = mysqli_query($conn, $catid);
                    $id = mysqli_fetch_assoc($query);
                    $kid = $id["kid"];
                    
                    //input wird abgeschickt
                    $input -> execute(); 
                    //user wird zum start geleitet um die news zu begutachten  
                    header("location: index.php");                     

                }
            }
        }
       
        
        ?>
    </form>
</body>
</html>