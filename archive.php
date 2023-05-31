<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Archive</title>
</head>
<body>
    <a href="index.php"><img src="raphi_logo.png" id="logo" width="12%"></a>
    <h1>Archiv</h1>
    <?php 
        require "cb_conn.php";
        //das heutige datum wird definiert
        $currentdate = date("Y-m-d");

        //es nimmt alle datensätze der news welche nicht mehr gültig sind
        //es sortiert nach neustem
        //limit sorgt dafür, dass nur die letzten 5 gezogen werden
        $correct = "SELECT * FROM news WHERE gueltigBis <= '$currentdate' ORDER BY erstelltam DESC LIMIT 5";
        $result = mysqli_query($conn, $correct);
        //läuft durch alle einträge die ins muster passen
        foreach ($result as $i) {


            //query variabeln definieren
            $title = $i["titel"];
            $content = $i["inhalt"];
            $datefrom = $i["gueltigVon"];
            $dateto = $i["gueltigBis"];
            $createdate = $i["erstelltam"];
            $category = $i["kid"];
            $image = $i["bild"];
            $link = $i["link"];
            $author = $i["autor"];
            //aus kid wird ein string mit der Kategorie gemacht
            $kategorie = "SELECT * FROM kategories WHERE kid = '$category'";
            $result3 = mysqli_query($conn, $kategorie);
            $row2 = mysqli_fetch_assoc($result3);
            $categorysel = $row2["kategorie"];
            //autor wird von id in string umgewandelt
            $autor = "SELECT Benutzername FROM users WHERE uid = '$author'";
            $result4 = mysqli_query($conn, $autor);
            $row2 = mysqli_fetch_assoc($result4);
            $autorsel = $row2["Benutzername"];

            //news werden im passenden muster ausgegeben
            echo "<div id='news'> Titel: <g id='newstitle'>$title</g> <br>
            <div id='newsinhalt'>Inhalt: $content</div>
            <img src='$image' width= 10%> 
            <br> Erstellt am: $createdate<br> Gültig von: $datefrom <br>
            Gültig bis: $dateto <br>
            Kategorie: $categorysel <br> 
            <br> Link:<a href='$link' target ='_blank'>quelle</a> 
            <br> Autor: $autorsel 
            <br> </div><br>";
            
            
        }

        
    
    ?>
</body>
</html>