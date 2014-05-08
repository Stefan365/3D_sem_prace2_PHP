<?php 


/**
 *
 * @author Stefan Veres
 * 
 */
?>
<html>
    <head>

        <?php

        //pro zobrazzeni dotazniku:
        $tableDepict =  filter_input(INPUT_POST, 'questionaire');
        
        //sprava o neuspechu:
        $message = $_SESSION['message'];
        $_SESSION['message'] = ""; //nasledne vynulovanie spravy, aby sa nepouzila nahodou 2 krat.

        $uid = $_SESSION['uid'];
        $lg = $_SESSION['login'];
        $pw = $_SESSION['password'];
        $goAdmin = "";
        
        //A. Kontrola jestli je uzivatel prihlaseny (keby chcel obist prihlasovaciu stranku)
        if (!Pom::checkPassword($lg, $pw)){
            $_SESSION['message'] = "TRY IT AGAIN PLEASE, INCORRECT LOGIN OR PASSWORD!";
            header("Location: P1.php");
            die();
        }

        if (Pom::isAdmin($uid)){
            $goAdmin = Pom::goAdminText();
        }
        
        //B. Kontrola jestli bol vybrany dotaznik na zobrazenie: 
        if (!($tableDepict == null || $tableDepict =="")){
            ?>
            <script type="text/javascript">
                window.open("table.php"); 
            </script>
            <?php
            //toto zdanlivo zbytocne presmerovanie je kvoli zabraneniu 
            //vykakovaniu posledne zvoleneho dotaznika pri stlaceni F5.
            header("Location: P4.php");
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

        <h5><?php echo $lg; ?></h5>
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
        
        
        <div id=paticka>
            <form action="P1.php" method="post">
                <input type="submit" value="BACK" />
            </form>

        </div>
        
        <!--admin button:-->
        <?php echo $goAdmin; ?>
        
        <!-- message: -->
        <h5 id=podmenu1> <font color="red">
            <?php echo $message; ?> 
            </font>
        </h5>
        
   </body>
</html>


