<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <input type="text" name="datefrom" id="datefrom" required><br>
        <label for="dateto">bis: </label>
        <input type="text" name="dateto" id="dateto" required><br>
        <label for="createdate">Erstellt am: </label>
        <input type="date" name="createdate" id="createdate" required><br>
        <label for="category">Category:</label>
        <input type="text" id="category" name="category"required><br>
        <label for="img">Bild zum Artikel</label>
        <input type="file" id="img" name="img"><br>
        <label for="link" >Quelle einfügen</label>
        <input type="url" id="source" name="source"required><br>
        <label for="autor">autor</label>
        <input type="text" id="autor" name="autor"><br>
        <input type="submit" name="submit" id="submit">
        <?php
        require "cb_conn.php";
        if(isset($_POST["submit"])){
            
            
            $input = $conn -> prepare("INSERT INTO news(titel, inhalt, gueltigVon, gueltigBis, erstelltam, kid, link, bild, autor)");
            //$input -> bind_param("");

            $title = $_POST["title"];
            $content = $_POST["content"];
            $datefrom = $_POST["datefrom"];
            $dateto = $_POST["dateto"];
            $category = $_POST["category"];
            $cratedate = $_POST["createdate"];
            $image = $_POST["img"];
            $source = $_POST["source"];
            $autor = $_POST["autor"];

            $catchose = $conn -> query("SELECT * FROM kategories WHERE kategorie = '$category'");
            if(mysqli_num_rows($catchose) == 0){
                $catinput = $conn -> prepare("INSERT INTO kategories(kategorie) VALUES(?)");
                $catinput -> bind_param("s", $category);
                $catinput -> execute();
            }
            else {
                $catid = $conn -> query("SELECT kid FROM kategories WHERE kategorie = '$category'");
            }
            
        }

        ?>
    </form>
</body>
</html>