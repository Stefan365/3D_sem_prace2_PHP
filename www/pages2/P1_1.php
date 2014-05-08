<?php--
/*
    Document   : uzivatelia
    Created on : 20-Apr-2014
    Author     : Stefan Veres
*/
//use C:\Users\User\Dropbox\IIVOS_STV\Netbeans\TODOLIST\sem_praca_3d\www\pages2\pak\DBconn.php;
//import('pak.DBconn.php');
//use pak\DBconn.php;

//require_once 'pak/DBconn.php';
//require_once 'C:/Users/User/Dropbox/IIVOS_STV/Netbeans/TODOLIST/sem_praca_3d/www/pages2/pak/DBconn.php';
require __DIR__ . '/../www/pages2/pak/DBconn.php';

//loadClass(DBconn);
//require_once 'Nette/loader.php';
//require_once 'pak';

//Debug::$strictMode = TRUE;
//Debug::enable(Debug::DETECT, dirname(__FILE__).'/var/log/errors.txt');


?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="newcss.css">
        <title>SEMPRE PHP</title>
    </head>
    <body>


        <?php
            $message = "";
            $con = new DBconn();
            $bol = DBconn::initDB();
                echo "BOL: *".$bol."*";
                
            try {
                if($bol == true){
                    $message = "DATABASE SUCCESSFULLY INITIALIZED!";
                } else {
                    $message = "DATABASE HAS BEEN ALREADY INITIALIZED!!";
                }

            } catch (SQLException $e) {
                echo "Caught exception: ", $e->getMessage(), "\n";
                $sprava = "SOMETHING WENT WRONG WITH DB!";
            }

        ?>
        <!-- SPATNE TLACITKO:-->
        <div id=paticka>
            <form action = "P1.php" method = "post">
                <input type="submit" value="BACK" />
            </form>
        </div>
        <!-- TEXT O USPECHU:-->
        <h5 id="podmenu1">
            <?php echo $sprava; ?>
        </h5>

    </body>
</html>
