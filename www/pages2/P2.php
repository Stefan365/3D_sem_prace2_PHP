<?php

include './../pages2/pak/DBconn.php';
include './../pages2/pak/Pom.php';

/*
   Document   : Sem projekt 
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

        <h3>Registration</h3>

        <form action="P2_1.php" method="post">
            FIRST NAME: <input type="text" name="first_name" /> <br/>
            LAST NAME : <input type="text" name="last_name" /> <br/>
            LOGIN     : <input type="text" name="login" /> <br/>
            PASSWORD  : <input type="password" name="password" /> <br/>
                        <input type="hidden" value="P2" name="page" /> <br/>
            <input type="submit" value="SEND" />
        </form>
        
        <div id=paticka>
            <form action="P1.php" method="post">
                <input type="submit" value="BACK" />
            </form>
        </div>
        
        <h5 id=podmenu1> <font color="red">
            <?php echo $message; ?> 
            </font>
        </h5>

        
    </body>
</html>
<?php
?>