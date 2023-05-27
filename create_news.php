<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Write News</title>
</head>
<body>
<a href="index.php">home</a>
    <form id="news" action="create_news.php" method="post">
        <p>Please enter your news</p>
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required><br>
        <label for="content">Content:</label>
        <textarea name="content" id="content" cols="30" rows="10" required></textarea><br>
        <label for="datefrom">Gültig von:</label>
        <input type="date" name="datefrom" id="datefrom" required><br>
        <label for="dateto">bis: </label>
        <input type="date" name="dateto" id="dateto" required><br>
        <label for="catlist">Kategorie:</label>
        <?php require "cb_conn.php";
        $catquery= "SELECT * FROM kategories";
        $catresult = mysqli_query($conn, $catquery);
        echo "<select id='calist' name='catlist'>";
        foreach($catresult as $i){
            $catoption = $i["kategorie"];
            echo "<option>$catoption</option>";
        } 
        echo "</select>";?>
        <a href="allcategories.php">Neue Kategorie erstellen</a><br>
        <label for="img">Bild zum Artikel</label>
        <input type="url" id="img" name="img" required><br>
        <label for="link" >Quelle einfügen</label>
        <input type="url" id="source" name="source" required><br>
        <input type="submit" name="submit" id="submit">


        <?php
        require "cb_conn.php";
        print_r($_SESSION);
        if(isset($_POST["submit"])){
            
            //prepared Statement
            $input = $conn -> prepare("INSERT INTO news(titel, inhalt, gueltigVon, gueltigBis, erstelltam, kid, link, bild, autor) VALUES(?,?,?,?,?,?,?,?,?)");
            $input -> bind_param("sssssssss", $title, $content, $datefrom, $dateto, $CurrentDate, $kid, $source, $image, $autor);

            //define variables
            $title = $_POST["title"];
            $content = $_POST["content"];
            $datefrom = $_POST["datefrom"];
            $dateto = $_POST["dateto"];
            $category = $catoption;
            $CurrentDate = date("Y-m-d");
            $image = $_POST["img"];
            $source = $_POST["source"];
            $autor = $_SESSION["userid"];

            //define the queries to prove the values
            $titleprove = $conn -> query("SELECT * FROM news WHERE titel= '$title'");
            $catchose = $conn -> query("SELECT * FROM kategories WHERE kategorie = '$category'");

            

            //if the category doesnt exists it will be inserted into kategories
            if($dateto < $CurrentDate && $dateto < $datefrom){
                echo "can't be in the past";
            }
            else{
                if(mysqli_num_rows($catchose) == 0){
                    echo "Kategorie existiert nicht";

                }
                //if category exists
                elseif (mysqli_num_rows($catchose) > 0){
                    $catid = "SELECT kid FROM kategories WHERE kategorie = '$category'";

                    //the id from the input category is selected
                    $query = mysqli_query($conn, $catid);
                    $id = mysqli_fetch_assoc($query);
                    $kid = $id["kid"];
                    if(mysqli_num_rows($titleprove) == 0){
                        $input -> execute();                        

                    }
                    else{
                        echo "the title: $title, already exists";
                    }
                }
            }
            
        }
       
        
        ?>
    </form>
</body>
</html>