<?php 

include './../pages2/pak/DBconn.php';
include './../pages2/pak/Pom.php';

session_start();

/**
 * @author Stefan Veres
 */

$message = $_SESSION['message'];
$_SESSION['message'] = "";


        $uid = $_SESSION['uid'];
        $lg = $_SESSION['login'];
        $pw = $_SESSION['password'];
        $fn = $_SESSION['first_name'];
        $ln = $_SESSION['last_name'];
            
        //A. Kontrola jestli je uzivatel prihlaseny (keby chcel obist prihlasovaciu stranku)
        if (!Pom::checkPassword($lg, $pw)){
            $_SESSION['message'] = "PLEASE LOGIN OR REGISTER!";
            //dispatch
            header("Location: P1.php");
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
        
        
        <form action="P5_1.php" method="post">
            FIRST NAME  : <input type="text" value="<?php echo $fn; ?>" name="first_name" /> <br/>
            LAST NAME   : <input type="text" value="<?php echo $ln; ?>" name="last_name" /> <br/>
            NEW PASSWORD: <input type="password" name="password" /> <br/>
                          <input type="hidden" value="P5" name="page" /> <br/>
            <input type="submit" value="SAVE" />
        </form>
        
        <div id=paticka>
            <form action="P4.php" method="post">
                <input type="submit" value="BACK" />
            </form>
        </div>
        
        <h5 id=podmenu1> <font color="red">
            <?php echo $message; ?> 
            </font>
        </h5>

        
    </body>
</html>


