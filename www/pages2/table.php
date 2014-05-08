<?php
/*
    Document   : uzivatelia
    Created on : 08-Mar-2014, 11:27:55
    Author     : Stefan Veres
*/

$lg = $_SESSION['login'];
$pw = $_SESSION['password'];
$uid = $_SESSION['uid'];
$sprava = "";
//$ques = $_SESSION['questionaire'];
$ques = filter_input(INPUT_POST, 'questionaire');


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
            $message = "";
            //$pag =  filter_input(INPUT_POST, 'page');
            if ( $pag == "P1") {
            //ochrana pred F5. (opakovane zapisovanie uz raz zadanych udajov)
            }
            //Konstrukcia tabulky:
            try{
                $questions = Pom::getHeader($ques);
                
                DBconn::connect();
                $query = "SELECT * FROM " . $ques ." WHERE user_id = '" . $uid . "'";
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
                for ($i = 0; $i < $sizeof($questions); $i++){
                   echo "<tr>";
                   echo "<td>". $all[0][i] . "</td>". "<td>". $all[1][i] . "</td>";
                   echo "</tr>";
                }
                echo "</table>";
                mysql_close();

            } catch (SQLException $e) {
                echo "Caught exception: ", $ex->getMessage(), "\n";
                mysql_close();
                $sprava = "SOMETHING WENT WRONG WITH DB!";
            }
                
?>
        <h4 id=podpaticka> <font color = "red"> <?php echo $sprava; ?> </font></h4>
    </body>
</html>
