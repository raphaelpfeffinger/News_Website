    <?php session_start(); ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <title>Index</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
            <?php
            require "cb_conn.php";
            //wenn der knopf gedrückt wird die gewählte news gelöscht wenn der user auch autor ist
            if(isset($_POST["delete"])){
                header("Cache-Control: no-cache, must-revalidate");
                $deleteid = $_POST["deleteid"];
                $delete = $conn -> prepare("DELETE FROM news WHERE newsID = ?");
                $delete -> bind_param("s", $deleteid);
                $delete -> execute();
                if($delete -> execute()){
                }
            //bei diesem knopf wird der user weitergeleitet auf edit_news.php
            } elseif(isset($_POST["edit"])){
                header("Cache-Control: no-cache, must-revalidate");
                //die gewählte id wird definiert
                $editid = $_POST["deleteid"];
                $_SESSION["editid"] = $editid;
                //die id wird in ein txt file kurzzeitig reingeschrieben
                header("location: edit_news.php");
            }
            //wenn der user nicht angemeldet ist, werden login und register angezeigt
            if(! isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] = 0){
                echo "<header>
                <a href='index.php'><img src='raphi_logo.png' id='logoindex' width='12%'></a>
                <nav>
                <ul>
                <li><a href='index.php' id='links'>Home</a></li>
                <li><a href='login.php' id='links'>Login</a></li>
                <li><a href='register.php' id='links'>Registrieren</a></li>
                <li><a href='archive.php' id='links'>Archiv</a></li>
                </ul></nav></header>";


            //wenn der benutzer angemeldet ist, kann man auf die create news seite
            //der logout button wird auch angezeigt
            } else if($_SESSION["loggedin"] = true){
                echo "<header>
                <a href='index.php'><img src='raphi_logo.png' id='logoindex' width='12%'></a>
                <nav>
                <ul>
                <li><a href='index.php' id='links'>Home</a></li>
                <li><a href='create_news.php'>Neue News erstellen</a></li>
                <li><a href='archive.php'>Archiv</a></li>
                <li><a href='change_password.php'>Passwort ändern</a></li>
                <li><form action='index.php' method='post'>
                <input type='submit' name='logout' id='logout' value='logout'>
                </form></li>
                <li><a href='profile.php'>Profil</a></li>
                
                </ul></nav></header><br><br>";



                

                //wenn logout gedrückt wird wird der user abgemeldet und auf die login seite geleitet
                if(isset($_POST["logout"])){
                    $_SESSION = array();
                    unset($_SESSION["loggedin"]);
                    unset($_SESSION["Benutzername"]);
                    unset($_SESSION["userid"]);
                    session_destroy();
                    header("Cache-Control: no-cache, must-revalidate");
                    header("location: login.php");
                
                }
                
                    
            }
            
            //die dropdown liste mit allen kategorien wird erstellt
            $catquery= "SELECT * FROM kategories";
            $catresult = mysqli_query($conn, $catquery);
            //select tag müssen for der foreach schleife aufgemacht werden
            echo "<br><br><br><br><br><form action='index.php' method='post'><select id='catlist' name='catlist'>";
            foreach($catresult as $i){
                //die options ändern dann mit jedem durchlauf
                $catoption = $i["kategorie"];
                echo "<option value='$catoption'>$catoption</option>";
            } 
            echo "</select>
            <input type='submit' id='sort' name='sort' value='Sortieren'>
            </form>";
            
            $currentdate = date("Y-m-d");

            //wenn ein filter gesetzt wurde um nach kategorien zu filtern
            if(isset($_POST["sort"])){
                //ein button wird angezeigt um den filter aufzuheben
                echo "<form action='index.php' method='post'>
                <input type='submit' name='cancelsort' id='cancelsort' value='Filter zurücksetzen'>
                </form>";


                //es wird die id der kategorie nach der sortiert wurde entnommen
                $sortcat = $_POST["catlist"];
                $sort = "SELECT * FROM kategories WHERE kategorie = '$sortcat'";
                $sortresult = mysqli_query($conn, $sort);
                $sortrow = mysqli_fetch_assoc($sortresult);
                $sortkid = $sortrow["kid"];

                //alle einträge welche die gewählte kategorie haben werden aus der tabelle genommen
                //sie werden nach erstellungsdatum geordnet
                $correct = "SELECT * FROM news WHERE kid = '$sortkid' ORDER BY erstelltam DESC";
                $result = mysqli_query($conn, $correct);
                foreach ($result as $i) {
                    
                    //es wird überprüft ob die einträge noch gültig sind
                    if ($i["gueltigBis"] > $currentdate && $i["gueltigVon"] <= $currentdate){
                        $title = $i["titel"];
                        $content = $i["inhalt"];
                        $datefrom = $i["gueltigVon"];
                        $dateto = $i["gueltigBis"];
                        $category = $i["kid"];
                        $image = $i["bild"];
                        $link = $i["link"];
                        $author = $i["autor"];
                        $createdate = $i["erstelltam"];
                        $id = $i["newsID"];
                        //kategorie wird von id zu einem string
                        $kategorie = "SELECT * FROM kategories WHERE kid = '$category'";
                        $result3 = mysqli_query($conn, $kategorie);
                        $row3 = mysqli_fetch_assoc($result3);
                        $categorysel = $row3["kategorie"];


                        //autor wird von id zu einem string
                        $autor = "SELECT Benutzername FROM users WHERE uid = '$author'";
                        $result4 = mysqli_query($conn, $autor);
                        $row2 = mysqli_fetch_assoc($result4);
                        $autorsel = $row2["Benutzername"];
                        
                        //es wird überprüft ob der angemeldete user auch autor ist
                        if($_SESSION["Benutzername"] == $autorsel){
                            //falls ja, werden auch noch edit und delete button angezeigt 
                            echo "<div id='news'><g id='newstitle'>$title</g>
                            <div id='newsinhalt'>Inhalt: $content</div><div id='image'><img src='$image' width= 10% id='newsimage'></div> <br>
                            
                            Gültig von: $datefrom <br>
                            Gültig bis: $dateto <br>
                            Erstellt am: $createdate <br>
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
                            //falls nicht nur die werte der news
                            echo "<div id='news'> 
                            <g id='newstitle'>$title</g>
                            <br> <div id='newsinhalt'>Inhalt: $content</div>
                            <br> Bild: <img src='$image' width= 10%> 
                            <br> Gültig von: $datefrom 
                            <br> Gültig bis: $dateto 
                            <br> Kategorie: $categorysel 
                            <br> Link:<a href='$link' target ='_blank'>quelle</a> 
                            <br> Autor: $autorsel <br> </div><br>";
                        }

                        
                    }

                }
                //falls der filter gelöscht werden soll
                if(isset($_POST["cancelsort"])){
                   unset($sortcat);
                   unset($sortkid);
                   
                }
            //gleicher block mit anzeigen wie oben nur ohne filter
            } else{
                $correct = "SELECT * FROM news ORDER BY erstelltam DESC";
                $result = mysqli_query($conn, $correct);
                foreach ($result as $i) {
                    if ($i["gueltigBis"] > $currentdate && $i["gueltigVon"] <= $currentdate){
                        $title = $i["titel"];
                        $content = $i["inhalt"];
                        $datefrom = $i["gueltigVon"];
                        $dateto = $i["gueltigBis"];
                        $createdate = $i["erstelltam"];
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
                        
                        if(isset($_SESSION["Benutzername"]) && $_SESSION["Benutzername"] == $autorsel){
                            echo "<div id='news'><g id='newstitle'>$title</g>
                            <div id='newsinhalt'>Inhalt: $content</div><div id='image'><img src='$image' width= 10% id='newsimage'></div> <br>
                            
                             Gültig von: $datefrom <br>
                             Gültig bis: $dateto <br>
                             Kategorie: $categorysel <br>
                             Erstellt am: $createdate <br>
                             Quelle:<a href='$link' target ='_blank'>quelle</a> <br>
                             Autor: $autorsel <br>
                        
                            <form action= 'index.php' method='post'>
                                <input type='hidden' id='deleteid' name='deleteid' value='$id'>
                                <input type='submit' name='delete' id='delete' value='delete'>
                                <input type='submit' name='edit' id='edit' value='edit'>
                            </form>
                            </div><br>";
                        
                        }else{

                            echo "<div id='news'> 
                            <g id='newstitle'>$title</g> <br> 
                            <div id='newsinhalt'>Inhalt: $content</div>
                            <br> <img src='$image' width= 10%> 
                            <br> Gültig von: $datefrom 
                            <br> Gültig bis: $dateto 
                            <br> Erstellt am: $createdate
                            <br> Kategorie: $categorysel
                            <br> Link:<a href='$link' target ='_blank'>quelle</a> 
                            <br> Autor: $autorsel <br> 
                            </div><br>";
                        }
                        
                    }
                }
            }
            ?>
        </body>
    </html>