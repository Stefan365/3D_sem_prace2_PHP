 <?php 

//include './../pages2/pak/DBconn.php';
//include './../pages2/pak/CryptMD5.php';

/**
 * 
 *
 * @author Stefan
 */

class Pom {

    //1.0
    /**
     * Zapise atributy do DB.
     *
     * @throws SQLException
     */
    static function zapisDbUser() {

        $fn = filter_input(INPUT_POST, 'first_name');
        $ln = filter_input(INPUT_POST, 'last_name');
        $lg = filter_input(INPUT_POST, 'login');
        $pw = filter_input(INPUT_POST, 'password');

        //sifrovanie hesla:
        $pwc = CryptMD5::crypt($pw);

        //zapis hodnoty do DB:
        DBconn::insertValuesUser($fn, $ln, $lg, $pwc, "U");

    }

    //1.1
    /**
     * Zapise atributy do DB.
     *
     * @param uid
     * @throws SQLException
     *
     */
    public static function updateDbUserApp($uid) {

        $fn = filter_input(INPUT_POST, 'first_name');
        $ln = filter_input(INPUT_POST, 'last_name');
        $role = filter_input(INPUT_POST, 'role');
        $pw = filter_input(INPUT_POST, 'password');
        
        //pokud je policko prazdne, tak neudelej nic, jinak hesla vymen:
        if ($pw == ""){
            $pwOld = DBconn::getUserPw($uid);
            $pwc = $pwOld;
        } else {
            //sifrovanie hesla:
            $pwc = CryptMD5::crypt($pw);
        }

        //zapis hodnoty do DB:
        if ($role == null || $role == "" ){
            DBconn::updateValuesUserA($uid, $fn, $ln, $pwc);
        } else {
            DBconn::updateValuesUser($uid, $fn, $ln, $pwc, $role);
        }
    }
    
    //2.0
    /**
     * Zapise atributy do Session (po kontrole hesla).
     *
     * @throws SQLException
     *
     */
    public static function zapisSesUser() {
        
        $lg = filter_input(INPUT_POST, 'login');
        $pw = filter_input(INPUT_POST, 'password');
        
        //echo "<h1> LG:*".$lg."*</h1>";
        
        //sifrovanie hesla:
        $pwc = CryptMD5::crypt($pw);

        $uid = DBconn::getUserId($lg);
        $fn = DBconn::getUserFn($uid);
        $ln = DBconn::getUserLn($uid);
        
        $_SESSION['uid'] = $uid;
        $_SESSION['login'] = $lg;
        $_SESSION['first_name'] = $fn;
        $_SESSION['last_name'] = $ln;
        $_SESSION['password'] = $pwc;
        //$_SESSION['role'] = $rol;
        
    }

    //2.1
    /**
     * Zapise tie atributy do session, ale len tie, ktore sa menia.
     *
     * @throws SQLException
     *
     */
    public static function zapisSesFnLnPw() {
       

        //Nech to najprv zapise do DB, a potom, ked sa to podari sa na to odvolava.!!!
         $uid = $_SESSION['uid'];
         $fn = DBconn::getUserFn($uid);
         $ln = DBconn::getUserLn($uid);
         $pwc = DBconn::getUserPw($uid);
         
        //Zapis do session, aby to bolo stale poruke:
        $_SESSION['first_name'] = $fn;
        $_SESSION['last_name'] = $ln;
        // zapis pw sa len zdanlivo bije vid metoda vyssie, tato metoda ma sirsie 
        // pouzite, preto sa tieto 2 zapisy nebiju.
        $_SESSION['password'] = $pwc;
        
    }

    //2.2
    /**
     * Vynuluje hodnoty session zodpovedajuce userovi.
     *
     */
    public static function cleanSesQuest() {
        $_SESSION['uid'] = "";
        $_SESSION['login'] = "";
        $_SESSION['first_name'] = "";
        $_SESSION['last_name'] = "";
        $_SESSION['password'] = "";
        $_SESSION['questionaire'] = "";
        $_SESSION['sel_user'] = "";         
    }

    //3.
    /**
     * inicializuje messsage.
     *
     * @param attr atribute of session
     *
     */
    public static function nastavMessage($attr) {

        
        try {
            $s = $_SESSION[$attr];
            
        } catch (Exception $e) {
            //echo "Caught exception: ", $e->getMessage(), "\n";
            $_SESSION[$attr] = "";
        } 
        
    }

    //4.
    /**
     * Zapise hodnoty z dotazniku do DB.
     * 
     */
    public static function zapisDbQuest() {

        $uid = $_SESSION['uid'];
        $gen = filter_input(INPUT_POST, 'gender');
        $ag = filter_input(INPUT_POST, 'age_group');
        $ed = filter_input(INPUT_POST, 'education');
        $ig = filter_input(INPUT_POST, 'income');
        $q1 = filter_input(INPUT_POST, 'q1');
        $q2 = filter_input(INPUT_POST, 'q2');
        $q3 = filter_input(INPUT_POST, 'q3');
        
        $q_tab = filter_input(INPUT_POST, 'questionaire');

        switch($q_tab){
            case "T_Q1":
                $q4 = "";
                $q5 = "";
                $q6 = "";
                $q7 = "";
                break;
            case "T_Q2":
                $q4 = filter_input(INPUT_POST, 'q4');
                $q5 = filter_input(INPUT_POST, 'q5');
                $q6 = filter_input(INPUT_POST, 'q6');
                $q7 = filter_input(INPUT_POST, 'q7');
                break;
            
        }
        
        //zapis hodnoty do DB:
        if ($q_tab != "") {
            DBconn::insertValuesQ($q_tab, $gen, $ag, $ed, $ig, $q1, $q2, $q3, $q4, $q5, $q6, $q7, $uid);
        }
    }


    //8.
    /**
     * Zkontroluje kolko a ktore z dotaznikov dany uzivatel uz vyplnil.
     *
     * @param uid user id.
     * @return list of questionaires DB table names.
     */
    public static function checkDbUserQueries($uid) {

        DBconn::connect();
        
        $query1 = "SELECT q_tableName from T_QUERY";

        $preQuery = "SELECT user_id from ";
        $postQuery = " WHERE user_id = " . $uid;
        $listYes = array();
        $listNo = array();
        $listAll = array();

        try {
            
            $result1 = mysql_query($query1);
            
            while(list($q_tableName) = mysql_fetch_array($result1)){
                $tn = $q_tableName;
            
                //prohledavani dotaznikovych tabulek: 
                $query2 = $preQuery.$tn.$postQuery;

                $result2 = mysql_query($query2);
                list($user_id) = mysql_fetch_array($result2);
                
                
                if (($user_id != null) && $user_id != "") {
                    array_push($listYes, $tn);
                    $user_id = "";
                } else {
                    array_push($listNo, $tn);
                    $user_id = "";
                }
            }
            array_push($listAll, $listYes);
            array_push($listAll, $listNo);

            mysql_close();
            return $listAll;
            
        } catch (SQLException $e) {
            echo "Caught exception: ", $e->getMessage(), "\n";
            return null;
        } 
    }

    //9.
    /**
     * Zkontroluje kolko a ktore z dotaznikov dany uzivatel uz vyplnil a vytvori
     * prislusny xhtml text.
     *
     * @param li login.
     * @return list of xhtml texts of buttons.
     *
     */
    private static function createYesButtons(array $li) {

        $listYes = array();
        
        foreach ($li as &$value) {
            $tn = $value;
            $page = substr($tn, -2, 2);
       
            //echo "<h1>tbke: *". $tn . "*</h1>";
            
            $strBut = "";
            $strBut = $strBut."<div>";
            $strBut = $strBut."<form action=\"P4.php\" method=\"post\">";
            $strBut = $strBut."<input type=\"hidden\" name=\"questionaire\" value=\"".$tn."\"/>";
            $strBut = $strBut."<input type=\"submit\" value=\"".$page."     \"/>";
            $strBut = $strBut."</form>";
            $strBut = $strBut."</div>";
            
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
        private static function createNoButtons(array $li) {

        $listNo = array();
        
        foreach ($li as &$value) {
            $tn = $value;
            $page = substr($tn, -2, 2);

            //TVORBA ODOSIELACIEHO TLACITKA:
            $strBut = "";
            $strBut = $strBut."<div>";
            $strBut = $strBut."<form action=\"".$page.".xhtml\" method=\"post\">";
            $strBut = $strBut."<input type=\"submit\" value=\"".$page." (new)\"/>";
            $strBut = $strBut."</form>";
            $strBut = $strBut."</div>";
            
            array_push($listNo, $strBut);        
            
        }
        return $listNo;
    }

    //11.
    /**
     * Vytvori vsetky potrebne tlacitka, tj. vytvori prislusny xhtml text.
     *
     * @param $lia list of list Yes and No buttons.
     * @return list of xhtml texts of buttons.
     *
     */
     public static function createAllButtons(array $lia) {

        $listYesButt = Pom::createYesButtons($lia[0]);
        $listNoButt = Pom::createNoButtons($lia[1]);
        
        $listAllButt = array();
        array_push($listAllButt, $listYesButt);
        array_push($listAllButt, $listNoButt);
        
        $str = "";

        for ($i = 0; $i < 2; $i++) {
            foreach ($listAllButt[$i] as &$butt) {
                $str = $str.$butt;
            }
            $str = $str."<br/>";
        }
       return $str;
    }

    //12.
    /**
     * Zkontroluje jestli je user admin.
     *
     * @param uid id uzivatela.
     * @return true/false
     *
     */
    public static function isAdmin($uid) {
        // neskvor, aby sa to nedalo falsovat by sa to malo spravit tak,
        // ze sa skontroluje (zo session), jestli i prihlasene meno a heslo 
        // patria tomu istemu uid
        //
        DBconn::connect();
        
        $query = "SELECT role from T_USER where id =" . $uid;

        try {
            $result = mysql_query($query);
            list($role) = mysql_fetch_row($result);
            
            mysql_close();
            return ($role == "A");
            
        } catch (SQLException $e) {
            echo "Caught exception: ", $e->getMessage(), "\n";
            mysql_close();
            return false;
        }
    }
    
    //13.
    /**
     * Zkontroluje spravnost hesla pri prihlasovani.
     *
     * @param lg login.
     * @param pw password.
     * @return true/false
     *
     */
    public static function checkPassword($lg, $pwc) {
        
        DBconn::connect();
        
        $query = "SELECT password from T_USER WHERE login LIKE '" . $lg . "'";
        //pw netreba sifrovat, lebo prichadza uz zasifrovane.
        
        try {

            $result = mysql_query($query);
            list($password) = mysql_fetch_array($result);
            $realPw = $password;
            
            mysql_close();
            return ($realPw == null ? false : ($realPw == $pwc));

        } catch (SQLException $e) {
            echo "Caught exception: ", $e->getMessage(), "\n";
            mysql_close();
            return false;
        } 
    }

    //14.
    /**
     * Vrati zoznam mien + id vsetkych zaregistrovanych userov v systeme,
     * tj. len tych ktori niesu Admini.(aby sa nemohli navzajom vymazat, resp.
     * upravovat si udaje)
     *
     * @return zoznam mien + id na tvorbu combo boxu.
     *
     */
    private static function getComboNames() {
        
        DBconn::connect();
        
        $comboNames = array();
        $query = "SELECT id, first_name, last_name from T_USER where role NOT LIKE 'A'";
        
        try {
            
            $result = mysql_query($query);
            
            while (list($id, $first_name, $last_name) = mysql_fetch_array($result)) {
                $cn = $id . ", " . $first_name . " " . $last_name;
                array_push($comboNames, $cn);
            }
            mysql_close();
            return $comboNames;

        } catch (SQLException $e) {
            echo "Caught exception: ", $e->getMessage(), "\n";
            mysql_close();
            return null;
        }
    }

    //15.
    /**
     * Vrati zoznam html kodov pre tvorbu comboboxu.
     *
     * @return zoznam html kodu na tvorbu combo boxu.
     */
    private static function createComboList(array $cns) {

        $comboItems = array();

        $strCom = "<div>\n" . "<select name=\"sel_user\" size=\"1\">\n";
        //vlozenie hlavicky:
        array_push($comboItems, $strCom);
        
        foreach ($cns as &$cn) {
            //TVORBA COMBO POLOZKY:
            $strCom = "<option value=\"" . $cn . "\">" . $cn . "</option>\n";
            array_push($comboItems, $strCom);
        }
        //vlozenie paticky:
        $strCom = "</select>" + "\n" + "</div>" + "\n";
        array_push($comboItems, $strCom);
        
        return $comboItems;
    }

    //16.
    /**
     * Vytvori vsetky potrebne tlacitka, tj. vytvori prislusny xhtml text.
     *
     * @return string of xhtml texts of for creating combobox.
     * @throws SQLException
     *
     */
    public static function createComboFinal() {

        $combo = Pom::getComboNames();
        $combos = Pom::createComboList($combo);

        $str = "";

        foreach ($combos as &$combo) {
            $str = $str . $combo;
        }
        $str = $str . "<br/>";
        
        return $str;
    }

    //17.
    /**
     * Ziska user id z nazvu combo polozky.
     * 
     * @param cn combo item name
     * @return string of user id.
     */
    public static function getIdFromComboName($cn) {

        $zoz = explode(",", $cn );
        $uid = $zoz[0];
        return $uid;
    }

    //18.
    /**
     * Vymaze z Databazy vsetky zaznamy usera s dany id.
     * 
     * @param uid user id
     * @throws SQLException
     */
    public static function deleteDbId($uid) {
        
        
        $queryTables = Pom::getQueryTableNames();
        
        DBconn::connect();
                
        $queries = array();
        
        foreach ($queryTables as &$tab) {
            $sqlq = "DELETE FROM $tab WHERE user_id = $uid";
            array_push($queries, $sqlq);
        }
        $sqlu = "DELETE FROM T_USER WHERE id = $uid";
        array_push($queries, $sqlu);
        
        
        //deleting in queries tables:
        foreach ($queries as &$sql) {
            try {
                mysql_query($sql);
            } catch (SQLException $e) {
                echo "Caught exception: ", $e->getMessage(), "\n";
            } 
        }
        mysql_close();
    }

    //19.
    /**
     * Vrati zoznam mien DB tabuliek dotaznikov
     *
     * @return zoznam databazovych tabuliek, ktore zodpovedaju dotaznikom.
     * @throws SQLException
     */
    private static function getQueryTableNames() {
        
        DBconn::connect();
        
        $queryTables = array();
        $query = "SELECT q_tableName FROM T_QUERY";
        
        try {
            
            $result = mysql_query($query);
            
            while (list($q_tableName)  = mysql_fetch_array($result)) {
                array_push($queryTables, $q_tableName);
            }
            
            mysql_close();
            return $queryTables;

        } catch (SQLException $e) {
            echo "Caught exception: ", $e->getMessage(), "\n";
            mysql_close();
            return null;
        } 
    }
    
    //20.
    /**
     * Vrati html text pre tvorbu tlacitka pre prepnutie sa fo admin rezimu.
     *
     * @return html string pre tvorbu tlacitka GO ADMIN.
     */
    public static function goAdminText() {
    
        //change usder data button:
        $str = "<div id=\"patickaR\">"
        . "<form action=\"P6.php\" method=\"post\">"
        . "<input type=\"submit\" value=\"GO ADMIN\"/>"
        . "</form>"
        . "</div>"
        . "<br/>";
        
        return $str;
    }
    
    //21.
    /**
     * Vrati html text pre tvorbu tlacitka pre inicializaciu databazy.
     *
     * @return html string pre tvorbu tlacitka na inicializaci DB.
     */
    public static function initDbText() {
    
        $str = "<div id=\"patickaR\">"
        . "<form action=\"P1_1.php\" method=\"post\">"
        . "<input type=\"submit\" value=\"INIT DB\"/>"
        . "</form>"
        . "</div>"
        . "<br/>";
        
        return $str;
    }

    //22.
    /**
     * Vrati html text pre tvorbu tlacitka pre prepnutie sa admina spat do rezimu 
     * bezneho usera.
     *
     * @return html string pre tvorbu tlacitka na prepnutie do user modu.
     */
    public static function goUserText() {
    
        //change usder data button:
        $str = "<div id=\"patickaR\">"
        . "<form action=\"P4.php\" method=\"post\">"
        . "<input type=\"submit\" value=\"GO USER\"/>"
        . "</form>"
        . "</div>"
        . "<br/>";
        
        return $str;
    }

    
    //24.
    /**
     * Ziska zoznam id vsetkych uzivatelov.
     *
     * @return zoznam id vsetkych uzivatelov.
     * @throws java.sql.SQLException
     *
     */
    public static function getAllUsersId() {
        
        DBconn::connect();
        
        $listIds = array();
        $query = "SELECT id from T_USER";
        
        $result = mysql_query($query);
            
        while (list($id)  = mysql_fetch_array($result)) {
            array_push($listIds, $id);
        }
            
        mysql_close();
        return $listIds;
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
        DBconn::connect();
        
        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '" 
                . $tn . "' AND TABLE_SCHEMA = '" . DBconn::$DATABASE."'";
        
        //mysql_select_db(DBconn::$DATABASE);
        
        $result = mysql_query($sql);

        while ($row = mysql_fetch_row($result)) {
            foreach ($row as &$item) {
                array_push($listHead, $item);
            }
        }

        mysql_close();

        return $listHead;
    }
    
    //26.
    /**
     * Vrati zoznam dotaznikovych otazok, podla zadaneho typu dotazniku.
     *
     * @param tn DB questionaire table name.
     * @param uid ID usera.
     *
     */
    public static function getQuestions($tn) {
        
        $listQuest = array();
        
        switch ($tn){ 
                
        case "T_Q1":
            
            array_push($listQuest, "Gender");
            array_push($listQuest, "Age group");
            array_push($listQuest, "Education");
            array_push($listQuest, "Income");
            array_push($listQuest, "where did you buy your last piece of furniture?");
            array_push($listQuest, "Are you satisfied with it? (1 = not at all, 5 = very)");
            array_push($listQuest, "Are you going to choose the same seller again?");
            break;

        case "T_Q2":

            array_push($listQuest, "Gender");
            array_push($listQuest, "Age group");
            array_push($listQuest, "Education");
            array_push($listQuest, "Income");
            array_push($listQuest, "Where do you live?");
            array_push($listQuest, "Where do you live?");
            array_push($listQuest, "Do you have central heating?");
            array_push($listQuest, "Do you have hot water tap?");
            array_push($listQuest, "Do you have TV set?");
            array_push($listQuest, "Do you have PC with internet?");
            array_push($listQuest, "Are you happy with your living standard? \n ( 1 = not at all, 5 = very)");
            break;
        }
        
        return $listQuest;   
    }
}
