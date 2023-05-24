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
    <?php 
        require "cb_conn.php";
        $currentdate = date("Y-m-d");
        $correct = "SELECT * FROM news";
        $result = mysqli_query($conn, $correct);
        foreach ($result as $i) {
            
            $title = $i["titel"];
            $content = $i["inhalt"];
            $datefrom = $i["gueltigVon"];
            $dateto = $i["gueltigBis"];
            $category = $i["kid"];
            $image = $i["bild"];
            $link = $i["link"];
            $author = $i["autor"];
            //category from number to string
            $kategorie = "SELECT * FROM kategories WHERE kid = '$category'";
            $result3 = mysqli_query($conn, $kategorie);
            $row2 = mysqli_fetch_assoc($result3);
            $categorysel = $row2["kategorie"];
            //autor from number to string
            $autor = "SELECT Benutzername FROM users WHERE uid = '$author'";
            $result4 = mysqli_query($conn, $autor);
            $row2 = mysqli_fetch_assoc($result4);
            $autorsel = $row2["Benutzername"];

            echo "<div id='news'> Titel: $title <br> Inhalt: $content <br> Gültig von: $datefrom <br> Gültig bis: $dateto <br> Kategorie: $categorysel <br> Bild: <img src='$image'> <br> Link:<a href='$link' target ='_blank'>quelle</a> <br> Autor: $autorsel <br> </div><br>";
        
            
        }
        $catcount = "SELECT COUNT(*) AS num_rows FROM kategories";
        $result2 = mysqli_query($conn, $catcount);
        $row2 = mysqli_fetch_assoc($result2);

        /*$catname = "SELECT name";
        for($y = 0; $y < $row2["num_rows"]; $y++){
            echo "<select name='sort' id='sort'>
            <option value=''"
        }*/
    
    ?>
</body>
</html>