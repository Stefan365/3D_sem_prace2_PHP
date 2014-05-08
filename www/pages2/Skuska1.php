<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//header("Location: Skuska.php");
//die();
//redirect('Skuska.php', 301);
$lg = "kamil";
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="newcss.css">
        <title><?php echo $lg; ?></title>
    </head>

<?php
class Skuska1{    
    static $DBHOST = "localhost";
    static $USER = "root";
    static $PASSWORD = "";
    static $DATABASE = "php_project1";
    static $connection;
    
    static function connect(){
        
        Skuska1::$connection = mysql_connect(Skuska1::$DBHOST, Skuska1::$USER, Skuska1::$PASSWORD);
        mysql_select_db(Skuska1::$DATABASE);
        mysql_set_charset('utf8');
        //nastavenie kodovania DB na utf-8:
        $sql = "SET NAMES 'utf8'";
        mysql_query($sql);
        //mysql_close();

    }
    
    //25.
    /**
     * Ziska zoznam hlaviciek dotaznikovych tabuliek.
     *
     * @return zoznam hlavicie vsetkych dotaznikovych tabuliek.
     *
     */
    public static function getQuestHeaders($tn) {
        $listHead = array();
        
        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '" 
                . $tn . "' AND TABLE_SCHEMA = '" . Skuska1::$DATABASE."'";
        
        mysql_select_db(Skuska1::$DATABASE);
        
        $result = mysql_query($sql);

        while ($row = mysql_fetch_row($result)) {
            foreach ($row as &$item) {
                array_push($listHead, $item);
            }
        }

        mysql_close();

        return $listHead;
    }
    
}

//spusti:
Skuska1::connect();

      $pole = Skuska1::getQuestHeaders("T_USER");
      echo  "<table border=\"2\">";
      //A. Hlavicka:
      echo "<tr>";

            foreach ($pole as &$item) {
                echo "<td><b>". $item . "</b></td>";
            }
      echo "</tr>";  
      echo "</table>";

Skuska1::connect();

//$cols = Pom::getHeader($questionaire);
$query = "SELECT * from T_USER";
$result = mysql_query($query);

$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = 'T_USER' AND TABLE_SCHEMA = '"
        .Skuska1::$DATABASE."'";

mysql_select_db(Skuska1::$DATABASE);
$result1 = mysql_query($sql);
     

      if ($result == null) {
          echo "DB Error, could not list tables\n";
      }      

      //Tabulka:
      echo  "<table border=\"2\">";
      //A. Hlavicka:
      echo "<tr>";
      while ($row1 = mysql_fetch_row($result1)) {
      
          echo "<b>";
          
          foreach ($row1 as &$item1) {
              echo "<td><b>". $item1 . "</b></td>";
          }
      }
      echo "</tr>";  
      
      //B. Samotne telo:
      while ($row = mysql_fetch_row($result)) {
          echo "<tr>";
          foreach ($row as &$item) {
              echo "<td>". $item . "</td>";
          }
          echo "</tr>";
      }
      echo  "</table>";
?>

    <body>
</html>
