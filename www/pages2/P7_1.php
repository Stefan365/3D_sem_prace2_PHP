<?php

/**
 * spracuje dotaz zo zmien dat usera.
 *
 * @author Stefan Veres
 */


        $uid = $_SESSION['uid'];
        $lg = $_SESSION['login'];
        
        //A.Vylouceni neautorizovaneho pristupu:
        if (!Pom::isAdmin($uid)) {
            $_SESSION['message'] = "PLEASE LOGIN MY DEAR ADMIN!";

            //dispatch
            header("Location: P1.php");
            die();
        }

        $comboName = $_SESSION['sel_user'];
        $sel_uid = Pom::getIdFromComboName($comboName);
        
        try {
            //zapis danych hodnot do DB:
            Pom::updateDbUserApp($sel_uid);
          
        } catch (SQLException $ex) {
            echo "Caught exception: ", $ex->getMessage(), "\n";
            $_SESSION['message'] = "TRY IT AGAIN PLEASE, SOME SQL ERROR!";
            
            //Posli spat: 
            header("Location: P6.php");
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
        <h3> ADMIN USER UPDATE: </h3>
        
        
        <h3 id=podmenu> ADMIN DATA UPDATE OF USER <?php echo $comboName; ?> WAS SUCCESSFUL!</h3>
        
        <div id=paticka>
            <form action="P6.php" method="post">
                <input type="submit" value="BACK" />
            </form>
        </div>
        
    </body>
</html>


        