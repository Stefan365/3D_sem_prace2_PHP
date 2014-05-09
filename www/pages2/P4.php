<?php 

include './../pages2/pak/DBconn.php';
include './../pages2/pak/Pom.php';

session_start();

/**
 *
 * @author Stefan Veres
 * 
 * Hlavna uzivatelska stranka
 * 
 */

?>
<html>
    <head>

        <?php

        //pro zobrazzeni dotazniku:
        $tD =  filter_input(INPUT_POST, 'questionaire');
        $_SESSION['questionaire'] = $tD;
        
        //sprava o neuspechu:
        $message = $_SESSION['message'];
        $_SESSION['message'] = ""; //nasledne vynulovanie spravy, aby sa nepouzila nahodou 2 krat.

        $uid = $_SESSION['uid'];
        $lg = $_SESSION['login'];
        $pwc = $_SESSION['password'];
        $goAdmin = "";
        
        //A. Kontrola jestli je uzivatel prihlaseny (keby chcel obist prihlasovaciu stranku)
        if (!Pom::checkPassword($lg, $pwc)){
            $_SESSION['message'] = "TRY IT AGAIN PLEASE, INCORRECT LOGIN OR PASSWORD!";
            header("Location: P1.php");
            die();
        }

        if (Pom::isAdmin($uid)){
            $goAdmin = Pom::goAdminText();
        }
        
        //B. Kontrola jestli bol vybrany dotaznik na zobrazenie: 
        //if ($tD == null or $tD == ""){
        if ($tD != null AND $tD != ""){
            //zobrazenie vyplneneho dotazniku:
            header("Location: table.php");
            die();
        }

        //Kontrola jestli dany dotaznik jiz byl vyplnen. pokud jo, otevra se jenom 
        //okno se zobrazenim daneho dotazniku.
        //tvorba prislusnych dotaznikovych tlacitek:
        $htmlButtons = Pom::createAllButtons(Pom::checkDbUserQueries($uid));

?>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="newcss.css">
        <title>SEMPRE PHP</title>
    </head>

    <body>

        <h3><?php echo $lg; ?></h3>
        <?php echo $htmlButtons; ?>
        
        <!-- logout button:-->
        <div id=hlavickaR>
            <form action="P1.php" method="post">
                <input type="submit" value="LOGOUT"/>
            </form>
        </div>
        
        <!-- change user data button: -->
        <div id=paticka>
            <form action="P5.php" method="post">
                <input type="submit" value="USER DATA"/>
            </form>
        </div>
        
        
        <!-- admin button: -->
        <?php echo $goAdmin; ?>
        
        
        <!-- message: -->
        <h5 id=podmenu1> <font color="red">
            <?php echo $message; ?> 
            </font>
        </h5>
        
   </body>
</html>


