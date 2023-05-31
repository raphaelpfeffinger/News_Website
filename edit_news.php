<?php session_start();
if($_SESSION["loggedin"] != true){
    header("location: login.php");
} else{
    require "cb_conn.php";

    //die id welche bearbeitet werden soll wird aus der session genommen
    $selid = $_SESSION["editid"];
    //falls es einen fehler gibt und die id = 0 ist
    if($selid != null){
        //die gewählte news wird per session id aus der datenbank genommen
        $seleditnews = "SELECT * FROM news WHERE newsID = '$selid'";
        $result = mysqli_query($conn, $seleditnews);
        $row = mysqli_fetch_assoc($result);

        //die verschiedenen daten und felder werden als variabeln defniert
        $title = $row["titel"];
        $content = $row["inhalt"];
        $datefrom = $row["gueltigVon"];
        $dateto = $row["gueltigBis"];
        $category = $row["kid"];
        $image = $row["bild"];
        $link = $row["link"];
        $author = $row["autor"];
        $id = $row["newsID"];
        $createdate = $row["erstelltam"];
        //die kategorie wird von id zu string gemacht
        $kategorie = "SELECT * FROM kategories WHERE kid = '$category'";
        $result3 = mysqli_query($conn, $kategorie);
        $row3 = mysqli_fetch_assoc($result3);
        $categorysel = $row3["kategorie"];

        //autor wird von id zu string gemacht
        $autor = "SELECT Benutzername FROM users WHERE uid = '$author'";
        $result4 = mysqli_query($conn, $autor);
        $row2 = mysqli_fetch_assoc($result4);
        $autorsel = $row2["Benutzername"];
        
    } else{
        //der user wird auf den start geleitet wenn die id = 0 ist
        header("location: index.php");
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>News editieren</title>
</head>
<body>
<a href="index.php"><img src="raphi_logo.png" id="logo" width="12%"></a>
 
    <div id='createnews'>
            <a href='index.php'><-Zurück zum Start</a>
            <h1 id='newstitle'>News editieren:</h1>
            <form id='news' action='edit_news.php' method='post'>
                <table id='createnewstable'>
                    <tr id='clines'>
                        <td id='ccells'><label for='title'>Titel:</label></td>
                        <td id='ccells'><input type='text' name='title' id='title' value='<?php echo $title ?>' required><br></td>
                    </tr>
                    <tr id='clines'>
                        <td id='ccells'><label for='content'>Inhalt:</label></td>
                        <td id='ccells'><textarea name='content' id='content' cols='30' rows='10' required><?php echo $content ?></textarea></td><br>
                    </tr>
                    <tr id='clines'>
                        <td id='ccells'><label for='datefrom'>Gültig von:</label></td>
                        <td id='ccells'><input type='date' name='datefrom' id='datefrom' value='<?php echo $datefrom ?>' required><br></td>
                    </tr>
                    <tr id='clines'>
                        <td id='ccells'><label for='dateto'>bis: </label></td>
                        <td id='ccells'><input type='date' name='dateto' id='dateto' value='<?php echo $dateto ?>' required></td><br>
                    </tr>
                    <tr id='clines'>
                        <td id='ccells'><label for='catlist'>Kategorie:</label></td>
                        <?php //gleicher kategorie dropdown algorithmus
                        echo "<td id='ccells'><select id='catlist' name='catlist'>";
                        $catquery = "SELECT * FROM kategories";
                        $catresult = mysqli_query($conn, $catquery);
                        foreach($catresult as $i){
                            $catoption = $i['kategorie'];
                            if($catoption == $categorysel){
                                /*damit die schon vorher ausgewählte kategorie als default gesetzt ist beim bearbeiten,
                                wird überprüft ob beim durchgehen aller kategorien die kategorie einmal gleich die 
                                kategorie aus der datenbank ist. falls ja wird diese als selected markiert*/
                                echo "<option value='$categorysel' selected='selected'>$categorysel</option>";
                            }else{
                                echo "<option value='$catoption'>$catoption</option>";
                            }
                        } ?>
                        </select>
                        </td>
                        <td id='ccells'><a href='allcategories.php'>Neue Kategorie erstellen</a></td><br>
                    </tr> 
                    <tr id='clines'>
                        <td id='ccells'><label for='img'>Bild(als Link einfügen):</label></td>
                        <td id='ccells'><input type='url' id='img' name='img' value='<?php echo $image ?>' required></td><br>
                    </tr>
                    <tr id='clines'>
                        <td id='ccells'><label for='link' >Quelle einfügen:</label></td>
                        <td id='ccells'><input type='url' id='source' name='source' value='<?php echo $link ?>' required></td><br>
                    </tr>
                
                </table><br><br> 
                <input type='submit' name='update' id='update' value="speichern"><br>
                <a href="index.php"><-zurück zum Start(speichert nicht!!)</a>
            </form>
        </div>

    <?php
        require "cb_conn.php";
        if(isset($_POST['update'])){
            
            //es werden die überschreibungswerte aus dem bearbeitungsform definiert
            $newtitle = trim($_POST["title"]);
            $newcontent = trim($_POST["content"]);
            $newdatefrom = trim($_POST["datefrom"]);
            $newdateto = trim($_POST["dateto"]);
            $newcategory = trim($_POST["catlist"]);
            $newimage = trim($_POST["img"]);
            $newsource = trim($_POST["source"]);

            if($newdateto < $newdatefrom){
                echo "<h4>Gültigkeitsdatum kann nicht in der Vergangenheit sein!</h4>";
            }
            else{
                //update statement wird vorbereitet
                $inputnew = $conn -> prepare("UPDATE news SET titel = ?, inhalt = ?, gueltigVon = ?, gueltigBis = ?, kid = ?, link = ?, bild = ?, autor = ? WHERE newsID = '$selid' ");
                $inputnew -> bind_param("ssssssss", $newtitle, $newcontent, $newdatefrom, $newdateto, $newkid, $newsource, $newimage, $author);

                //kategorie wird von id zu string
                $catid = "SELECT kid FROM kategories WHERE kategorie = '$newcategory'";
                $query = mysqli_query($conn, $catid);
                $id = mysqli_fetch_assoc($query);
                $newkid = $id["kid"];

                //update wird ausgeführt
                $inputnew -> execute();   
                header("location: index.php");            
        }
    }
?>
</body>
</html>