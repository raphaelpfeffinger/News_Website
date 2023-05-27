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
                <a href='change_password.php'>change password</a>
                </div>";
                if(isset($_POST["logout"])){
                    $_SESSION = array();
                    unset($_SESSION["loggedin"]);
                    unset($_SESSION["Benutzername"]);
                    unset($_SESSION["userid"]);
                    session_destroy();
                    header("Cache-Control: no-cache, must-revalidate");
                
                }
                
                    
            }
            $catquery= "SELECT * FROM kategories";
            $catresult = mysqli_query($conn, $catquery);
            echo "<select id='calist' name='catlist'>";
            foreach($catresult as $i){
                $catoption = $i["kategorie"];
                echo "<option>$catoption</option>";
            } 
            echo "</select>";
            
            $currentdate = date("Y-m-d");

            $correct = "SELECT * FROM news";
            $result = mysqli_query($conn, $correct);
            foreach ($result as $i) {
                
                if ($i["gueltigBis"] > $currentdate && $i["gueltigVon"] <= $currentdate){
                    $title = $i["titel"];
                    $content = $i["inhalt"];
                    $datefrom = $i["gueltigVon"];
                    $dateto = $i["gueltigBis"];
                    $category = $i["kid"];
                    $image = $i["bild"];
                    $link = $i["link"];
                    $author = $i["autor"];
                    $id = $i["newsID"];
                    //category from number to string
                    $kategorie = "SELECT * FROM kategories WHERE kid = '$category'";
                    $result3 = mysqli_query($conn, $kategorie);
                    $row3 = mysqli_fetch_assoc($result3);
                    $categorysel = $row3["kategorie"];


                    //autor from number to string
                    $autor = "SELECT Benutzername FROM users WHERE uid = '$author'";
                    $result4 = mysqli_query($conn, $autor);
                    $row2 = mysqli_fetch_assoc($result4);
                    $autorsel = $row2["Benutzername"];
                    
                    //image prep
                    if($_SESSION["Benutzername"] == $autorsel){
                        echo "<div id='news'><g id='newstitle'>$title</g>
                        <div id='newsinhalt'>Inhalt: $content</div><div id='image'><img src='$image' width= 10% id='newsimage'></div> <br>
                        
                        Gültig von: $datefrom <br>
                        Gültig bis: $dateto <br>
                        Kategorie: $categorysel <br>
                        Quelle:<a href='$link' target ='_blank'>quelle</a> <br>
                        Autor: $autorsel <br>
                       
                        <form action= 'index.php' method='post'>
                            <input type='hidden' id='deleteid' name='deleteid' value='$id'>
                            <input type='submit' name='delete' id='delete' value='delete'>
                            <input type='submit' name='edit' id='edit' value='edit'>
                        </form>
                        </div><br>";
                       
                    }else{

                        echo "<div id='news'> Titel: $title <br> <div id='newsinhalt'>Inhalt: $content</div><br> Gültig von: $datefrom <br> Gültig bis: $dateto <br> Kategorie: $categorysel <br> Bild: <img src='$image' width= 10%> <br> Link:<a href='$link' target ='_blank'>quelle</a> <br> Autor: $autorsel <br> </div><br>";
                    }

                    
                }
            }
            if(isset($_POST["delete"])){
                header("Cache-Control: no-cache, must-revalidate");
                $deleteid = $_POST["deleteid"];
                $delete = $conn -> prepare("DELETE FROM news WHERE titel = ? AND newsID = ?");
                $delete -> bind_param("ss", $title, $deleteid);
                $delete -> execute();
                if($delete -> execute()){
                    echo "successful";
                }
            } elseif(isset($_POST["edit"])){
                echo "lets got";
            }
                
                
            
            
            

            ?>
        </body>
    </html>