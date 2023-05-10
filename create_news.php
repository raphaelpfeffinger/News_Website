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
        <select id="category" name="category"><a href="create_category.php">create new category</a>
            <option value="Sport">Sport</option>
            <option value="Politics">Politics</option>
            <option value="Economy">Economy</option>
            <option value="weather">Weather</option>
            <option value="celebrities">Celebrities</option>
            <option value="dailynews">Daily News</option>
        <br><input type="submit" value="Submit" name="submit"><br>
        </select><br>
        <?php
        require "cb_conn.php";
        if(isset($_POST["submit"])){
            $title = $_POST["title"];
            $content = $_POST["content"];
            $datefrom = $_POST["datefrom"];
            $dateto = $_POST["dateto"];
            $category = $_POST["category"];
            
            $input = $conn -> prepare("INSERT INTO users(titel, inhalt, gueltigVon, gueltigBis, erstelltam,  )");
        }

        ?>
    </form>
</body>
</html>