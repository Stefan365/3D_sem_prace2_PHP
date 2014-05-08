<?php 

include './../pages2/pak/DBconn.php';
include './../pages2/pak/Pom.php';

session_start();

/**
 * spracuje dotaz zo zmien dat usera.
 *
 * @author Stefan Veres
 */

        $lg = $_SESSION['login'];
        $pw = $_SESSION['password'];
        $uid = $_SESSION['uid'];
            
        //A. Kontrola jestli je uzivatel prihlaseny (keby chcel obist prihlasovaciu stranku)
        if (!Pom::checkPassword($lg, $pw)){
            $_SESSION['message'] = "LOGIN INCORRECT, PLEASE LOGIN AGAIN!";
            header("Location: P1.php");
            die();
        }

        try {
            //zapis danych hodnot do DB:
            Pom::updateDbUserApp($uid);
            //pokud byl zapis uspesny, zapiseme ich i do session, aby boli po ruke:
            Pom::zapisSesFnLnPw();
            
        } catch (SQLException $x) {
            echo "Caught exception: ", $ex->getMessage(), "\n";
            $_SESSION['message'] = "TRY IT AGAIN PLEASE, SOME SQL ERROR!";
            //Posli spat: 
            header("Location: P4.php");
            die();  
        }
        ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="newcss.css">
        <title><?php echo $lg; ?></title>
    </head>

    <body>
        <h3>DATA UPDATE</h3>
        <?php $fn = $_SESSION['first_name']; ?>
        
        <h3> <?php echo $fn; ?></h3>
        
        
        <h3 id=podmenu> REGISTRATION WAS SUCCESSFUL!</h3>
        
        <div id=paticka>
            <form action="P4.php" method="post">
                <input type="submit" value="BACK" />
            </form>
        </div>
        
    </body>
</html>


