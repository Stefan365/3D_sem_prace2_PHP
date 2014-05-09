<?php

include './../pages2/pak/DBconn.php';
include './../pages2/pak/Pom.php';

session_start();

/*
    Document   : uzivatelia
    Created on : 08-Mar-2014, 11:27:55
    Author     : Stefan Veres
*/

$lg = $_SESSION['login'];
$pwc = $_SESSION['password'];
$uid = $_SESSION['uid'];

        //A. Kontrola jestli je uzivatel prihlaseny (keby chcel obist prihlasovaciu stranku)
        if (!Pom::checkPassword($lg, $pwc)){
            $_SESSION['message'] = "PLEASE LOGIN OR REGISTER!";
            header("Location: P1.php");
            die();
        }




$tn =  $_SESSION['questionaire'];
        

?>

<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="newcss.css">
        <title><?php echo $lg; ?></title>
    </head>
    <body>



        <?php
        
            //Konstrukcia tabulky:
            try{
                $questions = Pom::getQuestions($tn);
                
                DBconn::connect();
                
                $query = "SELECT * FROM $tn WHERE user_id = '$uid'";
                $result = mysql_query($query);
                
                $answers = mysql_fetch_row($result);
                    
                
                $all = array();
                array_push($all, $questions);
                array_push($all, $answers);
                $hlavicka = array("Question", "Answer");
                
                //Vykreslenie tabulky:
                echo  "<table border=\"2\">";
                //hlavicka:
                foreach ($hlavicka as &$item) {
                    echo "<td><b>". $item . "</b></td>";
                }
                //telo tabulky:
                for ($i = 0; $i < sizeof($questions); $i++){
                   echo "<tr>";
                   echo "<td>". $all[0][$i] . "</td>". "<td>". $all[1][$i + 1] . "</td>";
                   echo "</tr>";
                }
                echo "</table>";
                mysql_close();
                $message = "";

            } catch (SQLException $e) {
                echo "Caught exception: ", $ex->getMessage(), "\n";
                mysql_close();
                $message = "SOMETHING WENT WRONG WITH DB!";
            }
                
?>
        <h4 id=podpaticka> <font color = "red"> <?php echo $message; ?> </font></h4>
        
        <div id=paticka>
            <form action="P4.php" method="post">
                <input type="submit" value="BACK" />
            </form>
        </div>
        
    </body>
</html>
