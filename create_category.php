<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Categories</title>
</head>
<body>
<a href="index.php"><img src="logo.png" id="logo" width="10%"></a>
    <form id="categories" action="create_category.php" method="post">
        <label for="cat">Categorie name</label>
        <input type="text" name="cat" id="cat">
        <input type="submit" name="submit" id="submit">
    </form>

    <?php 
    require "cb_conn.php";
    if(isset($_POST["submit"])){
        $prepare = $conn -> prepare("INSERT INTO kategories(kategorie) VALUES(?)");
        $prepare -> bind_param("s", $name);

        $name = $_POST["cat"];

        $prove = $conn -> query("SELECT * FROM kategories WHERE kategorie = '$name'");
        if(mysqli_num_rows($prove) == 0){
            $prepare -> execute();
            header("location: create_news.php");
        } else{
            echo "the Category: $name already exists";
        }
    }
    ?>

</body>
</html>