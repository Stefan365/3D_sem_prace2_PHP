<?php


/**
 * Vstupna stranka aplikacie.
 *
 * @author Stefan Veres
 */

include './../pages2/pak/DBconn.php';
include './../pages2/pak/Pom.php';
 
session_start();
Pom::nastavMessage("message");
Pom::cleanSesQuest();

$message = $_SESSION['message'];
$_SESSION['message'] = "";

DBconn::initDbSettings();

$initDb = "";

        //inicializacia DB
        if(!DBconn::existsT_USER()){
            //echo "<h1>KAROLKO</h1>";
            $initDb = Pom::initDbText();
        } 

?>   
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="newcss.css">
        <title>SEMPRE PHP</title>
    </head>

    <body>

        <h3>Uvodna stranka</h3>

        <div>
            <form action = "P2.php" method = "post">
                <input type="submit" value="REGISTRATION" />
            </form>
            
            <form action = "P3.php" method = "post">
                <input type="submit" value="LOGIN" />
            </form>
        </div>

        <h3 id="podmenu">WELCOME TO MY PAGES!</h3>

        <?-- sprava pro pripadne neuspesne prihlaseni/registraci: --?>
        <h5 id = podmenu1> <font color="red"> <?php echo $message;  ?></font></h5>
        
        <!-- INIT DB:-->
        <?php echo $initDb; ?>
        
        <!-- message: -->
        <h5 id=podmenu1> <font color="red">
            <?php echo $message; ?> 
            </font>
        </h5>



    </body>
</html>
