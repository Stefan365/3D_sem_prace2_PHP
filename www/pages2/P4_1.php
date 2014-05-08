<?php 



/**
 * Spracuje dotaz ze stranek dotaznikov.
 * 
 * @author Stefan Veres
 */

        
        $uid = $_SESSION['uid'];
        $lg = $_SESSION['login'];
        $pw = $_SESSION['password'];
        
        //A. Kontrola jestli je uzivatel prihlaseny (keby chcel obist prihlasovaciu stranku)
        if (!Pom::checkPassword($lg, $pw)){
            $_SESSION['message'] = "PLEASE LOGIN OR REGISTER!";
            header("Location: P1.php");
            die();
        }

        try {
            //zapis do DB: 
            Pom::zapisDbQuest();

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
        <title><?php echo $lg;?></title>
    </head>

    <body>

        <h3 id=podmenu>"QUESTIONARY SUCCESSFULY SUBMITTED!"</h3>
            
        
        <div id=paticka>
            <form action="P4.php" method="post">
                <input type="submit" value="BACK" />
            </form>
        </div>
        

    </body>
</html>


        

