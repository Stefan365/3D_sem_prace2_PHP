<?php

include './../pages2/pak/DBconn.php';
include './../pages2/pak/Pom.php';

session_start();

/**
 * Admin page
 *
 * @author Stefan Veres
 */

        Pom::nastavMessage("sel_user");

        $message = $_SESSION['message'];
        $_SESSION['message'] = "";
        
        //vynulovanie pripadne obsahu sel_user:
        $_SESSION['sel_user'] = "";
        
        $uid = $_SESSION['uid'];

        //A.Vylouceni neautorizovaneho pristupu:
        if (!Pom::isAdmin($uid)) {
            $_SESSION['message'] = "PLEASE LOGIN MY DEAR ADMIN!";

            //dispatch
            header("Location: P1.php");
            die();
        }
        
        $lg = $_SESSION['login'];
        $goUser = Pom::goUserText();

        try {
            $combo = Pom::createComboFinal();
        }  catch (SQLException $x) {
            $combo = "";
            echo "Caught exception: ", $ex->getMessage(), "\n";
        }
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="newcss.css">
        <title><?php echo $lg; ?></title>
    </head>

    <body>

        <h3>SELECT USER:</h3>
        
        <!-- //Combo box/TLACITKO NA ZMENU USER DATA: -->
        <div>
            <form action="P7.php" method="post">
                <?php echo $combo; ?>
                <input type="submit" value="USER DATA" />
            </form>
        </div>
        
        <!-- logout button: -->
        <div id = hlavickaR>
            <form action="P1.php" method="post">
                <input type="submit" value="LOGOUT" />
            </form>
        </div>

        <!-- SPATNE TLACITKO -->
        <div id = paticka>
            <form action="P4.php" method="post">
                <input type="submit" value="BACK" />
            </form>
        </div>
        
        <!-- go user tlacitko -->
        <?php echo $goUser; ?>

        
        <h5 id=podmenu1> <font color="red">
            <?php echo $message; ?> 
            </font>
        </h5>

        
    </body>
</html>

