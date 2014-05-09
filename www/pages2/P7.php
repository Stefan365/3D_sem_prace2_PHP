<?php

include './../pages2/pak/DBconn.php';
include './../pages2/pak/Pom.php';

session_start();

/**
 * Adminovske prostredie na upravu dat usera. (neskvor zvazit zlucenie s P5)
 *
 * @author Stefan Veres
 */
        $message = $_SESSION['message'];
        $_SESSION['message'] = "";


        $uid = $_SESSION['uid'];
        $lg = $_SESSION['login'];

        //A.Vylouceni neautorizovaneho pristupu:
        if (!Pom::isAdmin($uid)) {
            $_SESSION['message'] = "PLEASE LOGIN MY DEAR ADMIN!";

            //dispatch
            header("Location: P1.php");
            die();
        }
        
        $comboName = filter_input(INPUT_POST, 'sel_user');
        $sel_uid = Pom::getIdFromComboName($comboName);

        //zapis to do session:
        $_SESSION['sel_user'] = $comboName;

        
        try {
            $fn = DBconn::getUserFn($sel_uid);
            $ln = DBconn::getUserLn($sel_uid);
            $pw = DBconn::getUserPw($sel_uid);
            $role = DBconn::getUserRole($sel_uid);
        
        } catch (SQLException $x) {
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

        <h3>DATA UPDATE:</h3>
        
        
        <form action="P7_1.php" method="post">
            FIRST NAME  : <input type="text" value="<?php echo $fn; ?>" name="first_name" /> <br/>
            LAST NAME   : <input type="text" value="<?php echo $ln; ?>" name="last_name" /> <br/>
            NEW PASSWORD: <input type="password" name="password" /> <br/>
            ROLE        : <input type="text" value="<?php echo $role; ?>" name="role" /> <br/>
            
            <input type="submit" value="SAVE" />
        </form>
        
            
        <div>
            <form action="P7_2.php" method="post">
                <input type="submit" value="DELETE USER" />
            </form>
        </div>

        <div id=paticka>
            <form action="P6.php" method="post">
                <input type="submit" value="BACK" />
            </form>
        </div>
        
        <h5 id=podmenu1> <font color="red">
            <?php echo $message; ?> 
            </font>
        </h5>

        
    </body>
</html>

            
                
            
