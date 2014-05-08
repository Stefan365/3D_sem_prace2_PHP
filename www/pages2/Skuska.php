<?php

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
$pole = array("A","B","C");
$pole1 = array("A","B","C");
$pole2 = array("A","B","C");
$pole3 = array("A","B","C");

$all = array();

array_push($all, $pole);
array_push($all, $pole1);
array_push($all, $pole2);
array_push($all, $pole3);


echo $all[0][1];

/* * class Skuska{
 
    
    static $DBHOST = "localhost";
    static $USER = "root";
    static $PASSWORD = "";
    static $DATABASE = "php_project1";
    static $connection;
    
    static function connect(){
        
        Skuska::$connection = mysql_connect(Skuska::$DBHOST, Skuska::$USER, Skuska::$PASSWORD);
        mysql_select_db(Skuska::$DATABASE);
        mysql_set_charset('utf8');
        //nastavenie kodovania DB na utf-8:
        $sql = "SET NAMES 'utf8'";
        mysql_query($sql);
        //mysql_close();

    }
    
    static $DATABASE = "php_project1";
    
    public static function getIdFromComboName($cn) {

        $zoz = explode(",", $cn );
        $uid = $zoz[0];
        return $uid;
    }

    public static function createYesButtons(array $li) {

        $listYes = array();
        
        foreach ($li as &$value) {
            $tn = $value;
            $page = substr($tn, -2, 2);
       
            $strBut = "";
            $strBut = $strBut."<div>\n";
            $strBut = $strBut."<form action=\"fourth\" method=\"post\">\n";
            $strBut = $strBut."<input type=\"hidden\" name=\"questionaire\" value=\"".$tn."\"/>\n";
            $strBut = $strBut."<input type=\"submit\" value=\"".$page."      \"/>\n";
            $strBut = $strBut."</form>\n";
            $strBut = $strBut."</div>\n";
            
            array_push($listYes, $strBut);        
            
        }
       

        return $listYes;
    }
    
        //10.
    /**
     * Zkontroluje kolko a ktore z dotaznikov dany uzivatel este nevyplnil a
     * vytvori prislusny xhtml text.
     *
     * @param li login.
     * @return list of xhtml texts of buttons.
     *
     */
/*
        private static function createNoButtons(array $li) {

        $listNo = array();
        
        foreach ($li as &$value) {
            $tn = $value;
            $page = substr($tn, -2, 2);

            //TVORBA ODOSIELACIEHO TLACITKA:
            $strBut = "";
            $strBut = $strBut."<div>\n";
            $strBut = $strBut."<form action=\"".$page.".xhtml\" method=\"post\">\n";
            $strBut = $strBut."<input type=\"submit\" value=\"".$page." (new)\"/>\n";
            $strBut = $strBut."</form>\n";
            $strBut = $strBut."</div>\n";
            
            array_push($listNo, $strBut);        
            
        }
        return $listNo;
    }

    //11.
    /**
     * Vytvori vsetky potrebne tlacitka, tj. vytvori prislusny xhtml text.
     *
     * @param $lia
     * @return list of xhtml texts of buttons.
     *
     */
 /*    public static function createAllButtons(array $lia) {

        $listYesButt = Skuska::createYesButtons($lia[0]);
        $listNoButt = Skuska::createNoButtons($lia[1]);
        
        $listAllButt = array();
        array_push($listAllButt, $listYesButt);
        array_push($listAllButt, $listNoButt);
        
        $str = "";

        for ($i = 0; $i < 2; $i++) {
            foreach ($listAllButt[$i] as &$butt) {
                $str = $str.$butt;
            }
            $str = $str."<br/>";
            $str = $str."<br/>";
        }
       return $str;
    }
    
    //25.
    /**
     * Ziska zoznam hlaviciek dotaznikovych tabuliek.
     *
     * @return zoznam hlavicie vsetkych dotaznikovych tabuliek.
     *
     */
 /*   public static function getQuestHeaders($tn) {
        $listHead = array();
        
        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '" 
                . $tn . "' AND TABLE_SCHEMA = '" . Skuska::$DATABASE."'";
        
        mysql_select_db(Skuska::$DATABASE);
        
        $result = mysql_query($sql);
     
        while ($row = mysql_fetch_row($result)) {
            foreach ($row as &$item) {
                array_push($listHead, $item);
            }
        }
/*
        while(list($column_name)= mysql_fetch_array($result)) {
            foreach ($column_name as &$item) {
                echo $item;
                array_push($listHead, $item);
            }
        }
  */      
        /*
        while ($row = mysql_fetch_row($result)) {
            foreach ($row as &$item) {
                array_push($listHead, $item);
            }
        }*/
        
   //     mysql_close();
   //     return $listHead;
   // }
//}