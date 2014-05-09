<?php
/*
    Document   : uzivatelia
    Created on : 20-Apr-2014
    Author     : Stefan Veres
*/
include './../pages2/pak/DBconn.php';
include './../pages2/pak/Pom.php';

            //$message = "";
            try {
                $bol = DBconn::initDB();
                
                if($bol == true){
                    $message = "DATABASE SUCCESSFULLY INITIALIZED!";
                } else {
                    $message = "DATABASE HAS BEEN ALREADY INITIALIZED!!";
                }

            } catch (SQLException $e) {
                echo $e->getMessage();
                $message= "SOMETHING WENT WRONG WITH DB!";
            }

        ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="newcss.css">
        <title>SEM PROJ</title>
    </head>
    <body>

        <!-- SPATNE TLACITKO:-->
        <div id=paticka>
            <form action = "P1.php" method = "post">
                <input type="submit" value="BACK" />
            </form>
        </div>
        
        <!-- TEXT O USPECHU:-->
        <h5 id=menu>
            <?php echo $message; ?>
        </h5>

    </body>
</html>
