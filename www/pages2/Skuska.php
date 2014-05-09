<?php

include './../pages2/pak/DBconn.php';
include './../pages2/pak/Pom.php';
//include './../pages2/pak/CryptMD5.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



/*
echo "1:<br/>";
foreach ($pole as &$value) {
    echo "1*".$value."*<br/>";
}

$pole = array();
echo "2:<br/>";
foreach ($pole as &$value) {
    echo "2*".$value."*<br/>";
}
 * 


$rest = substr("abcdef", 0, 2);
echo "3: *".$rest."*<br/>";

$poleB = Skuska::createYesButtons($pole);

foreach ($poleB as &$val) {
    echo $val;
}
 
$poleY = array();
$poleN = array();
$poleAll = array();


array_push($poleY, "T_Q1");
array_push($poleY, "T_Q2");
array_push($poleY, "T_Q3");

array_push($poleN, "T_Q4");
array_push($poleN, "T_Q5");
array_push($poleN, "T_Q6");

array_push($poleAll, $poleY);
array_push($poleAll, $poleN);

$all = Skuska::createAllButtons($poleAll);

echo $all;
*/
//echo "3: *".Skuska::getIdFromComboName("1, karol stvrty") . "*";
//
/*
Skuska::connect();
$pole = Skuska::getQuestHeaders("T_USER");
      echo  "<table border=\"2\">";
      //A. Hlavicka:
      echo "<tr>";

            foreach ($pole as &$item) {
                echo "<td><b>". $item . "</b></td>";
            }
*/
/*
$pole = array("A","B","C");
$pole1 = array("A","B","C");
$pole2 = array("A","B","C");
$pole3 = array("A","B","C");

$all = array();

array_push($all, $pole);
array_push($all, $pole1);
array_push($all, $pole2);
array_push($all, $pole3);
*/

//echo $all[0][1];
/*
$ple = Skuska::getAllUsersId();

            foreach ($ple as &$item) {
                echo "<td><b>*". $item . "*</b></td>";
            }
?>
            <script type="text/javascript">
                window.open("table.php"); 
            </script>
*/
//Pom::deleteDbId(1);
/*
DBconn::connect();
$arr = array();
$tn = "T_Q1";
$id = "2";

$sql1 = "DELETE FROM $tn WHERE user_id = $id";
$sql2 = "DELETE FROM T_Q2 WHERE user_id = $id";
//$sql3 = "DELETE FROM T_USER WHERE id = $id";

array_push($arr, $sql1);
array_push($arr, $sql2);
//array_push($arr, $sql3);


            foreach ($arr as &$item) {
                mysql_query($item);
            }




echo "<h1>DONE!</h1>";

$bol = Pom::existsT_USER();
if($bol){
    echo "<h1>YES!</h1>";
}else {
    echo "<h1>NO!</h1>";
}
*/

$pw = "a";
$pwc = CryptMD5::crypt($pw);

echo "<h1>$pwc</h1>";


 
