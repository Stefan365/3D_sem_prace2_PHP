<?php
//import('pak.*');

/**
 * Vstupna stranka aplikacie.
 *
 * @author Stefan Veres
 */
Pom::nastavMessage("message");

$message = $_SESSION['message'];
$_SESSION['message'] = "";

Pom::cleanSesQuest();
$initDb = "";

        //inicializacia DB
        if(!Pom::existsT_USER()){
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
