<?php 

include './../pages2/pak/DBconn.php';
include './../pages2/pak/Pom.php';

/**
 * Spracovava udaje z registracie
 *
 * @author Stefan Veres
 */

session_start();

try {
    Pom::zapisDbUser(); 
    $message= "REGISTRATION WAS SUCCESSFUL!";
                
} catch (SQLException $e) {
    echo "Caught exception: ", $e->getMessage(), "\n";
    $message= "SOMETHING WENT WRONG WITH DB!";          
}

$fn = filter_input(INPUT_POST, 'first_name');

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="newcss.css">
        <title>REGISTRATION</title>
    </head>

    <body>

        <h3> <?php echo $fn; ?></h3>
        
        <h3 id=podmenu> <?php echo $message; ?></h3>
        
        <div id=paticka>
            <form action="P1.php" method="post">
                <input type="submit" value="BACK" />
            </form>
        </div>
        
    </body>
</html>
