<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Index</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <a href="index.php"><img src="raphi_logo.png" id="logo" width="12%"></a>
        <?php
        require "cb_conn.php";
        if(! isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] = 0){
            echo "<div id='loginpages'>
            <a href='index.php' id='links'>Home</a>
            <a href='login.php' id='links'>Login</a>
            <a href='register.php' id='links'>Register</a>
            <a href='archive.php' id='links'>Archive</a>
            </div>";
        } else if($_SESSION["loggedin"] = 1){
            echo "<div id='loggedinpages'>
            <a href='create_news.php'>make news</a>
            <form action='index.php' method='post'>
            <input type='submit' name='logout' id='logout' value='logout'>
            </form>
            <a href='archive.php'>Archive</a>
            </div>";
            echo "<a href='change_password.php'>change password</a>";
            if(isset($_POST["logout"])){
                $_SESSION = array();
                unset($_SESSION["loggedin"]);
                unset($_SESSION["Benutzername"]);
                session_destroy();
            }
            
                
        }
           
        
        $currentdate = date("Y-m-d");

        $correct = "SELECT * FROM news";
        $result = mysqli_query($conn, $correct);
        foreach ($result as $i) {
            
            if ($i["gueltigBis"] > $currentdate and $i["gueltigVon"] <= $currentdate){
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

                //image prep
                //$imagedata = file_get_contents($image);
                if($image == NULL){
                    $image = "no image";
                    echo "<div id='news'> Titel: $title <br>
                     Inhalt: $content <br>
                      Gültig von: $datefrom <br>
                       Gültig bis: $dateto <br>
                        Kategorie: $categorysel <br>
                         Link:<a href='$link' target ='_blank'>quelle</a> <br> Autor: $autorsel <br> </div><br>";
                }else{

                    echo "<div id='news'> Titel: $title <br> Inhalt: $content <br> Gültig von: $datefrom <br> Gültig bis: $dateto <br> Kategorie: $categorysel <br> Bild: <img src='$image' width= 10%> <br> Link:<a href='$link' target ='_blank'>quelle</a> <br> Autor: $autorsel <br> </div><br>";
                }
            }
            
            
        }
        
        

        ?>
    </body>
</html>