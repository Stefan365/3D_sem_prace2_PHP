<?php

include './../pages2/pak/DBconn.php';
include './../pages2/pak/Pom.php';

/*
 * Prihlasovanie sa do systemu

   Document   : php projekt
   Created on : 20.04.2014
   Author     : Stefan Veres
*/


session_start();

$message = $_SESSION['message'];
$_SESSION['message'] = "";

?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="newcss.css">
        <title>SEM PROJ</title>
    </head>

    <body>

        <h3>User Login</h3>

        <form action="P3_1.php" method="post">
            LOGIN: <input type="text" name="login" /> <br/>
            PASSWORD: <input type="password" name="password" /> <br/>        
                <input type="hidden" value="P3" name="page" /> <br/>
            <input type="submit" value="SUBMIT" />

        </form>
        
        <div id=paticka>
            <form action="P1.php" method="post">
                <input type="submit" value="BACK" />
            </form>

        </div>
        
        <!-- message: -->
        <h5 id=podmenu1> <font color="red">
            <?php echo $message; ?> 
            </font>
        </h5>

        
    </body>
</html>
