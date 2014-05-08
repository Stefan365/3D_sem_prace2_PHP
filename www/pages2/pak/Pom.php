<?php 
/**
 *
 * @author Stefan
 */

class Pom {

    //1.0
    /**
     * Zapise atributy do DB.
     *
     * @param request pozadavek od klienta.
     * @throws java.sql.SQLException
     *
     */
    static function zapisDbUser() {

        $fn = filter_input(INPUT_POST, 'first_name');
        $ln = filter_input(INPUT_POST, 'last_name');
        $lg = filter_input(INPUT_POST, 'login');
        $pw = filter_input(INPUT_POST, 'password');

        //sifrovanie hesla:
        //$pwc = CryptMD5::crypt($pw);

        //zapis hodnoty do DB:
        DBconn::insertValuesUser($fn, $ln, $lg, $pw, "U");

    }

    //1.1
    /**
     * Zapise atributy do DB.
     *
     * @param uid
     * @param request pozadavek od klienta.
     * @throws java.sql.SQLException
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
            $pw = $pwOld;
        } else {
            //sifrovanie hesla:
            $pw = CryptMD5::crypt($pw);
        }

        //zapis hodnoty do DB:
        if ($role == null || $role == "" ){
            DBconn::updateValuesUser($uid, $fn, $ln, $pw);
        } else {
            DBconn::updateValuesUserA($uid, $fn, $ln, $pw, $role);
        }
    }
    
    //2.0
    /**
     * Zapise atributy do Session (po kontrole hesla).
     *
     * @param session klientuv session.
     * @param request pozadavek od klienta.
     * @throws java.sql.SQLException
     *
     */
    public static function zapisSesUser() {
        
        $lg = filter_input(INPUT_POST, 'login');
        $pw = filter_input(INPUT_POST, 'password');
        //sifrovanie hesla:
        $pwc = CryptMD5::crypt($pw);

        $uid = DBconn::getUserId($lg);
        $fn = DBconn::getUserFn($uid);
        $ln = DBconn::getUserLn($uid);
        //$rol = DBconn::getUserRole($uid);

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
     * @param session klientuv session.
     * @throws java.sql.SQLException
     *
     */
    public static function zapisSesFnLnPw() {
       

        //Nech to najprv zapise do DB, a potom, ked sa to podari sa na to odvolava.!!!
         $uid = $_SESSION['uid'];
         $fn = DBconn::getUserFn($uid);
         $ln = DBconn::getUserLn($uid);
         $pw = DBconn::getUserPw($uid);
         
        //Zapis do session, aby to bolo stale poruke:
        $_SESSION['first_name'] = $fn;
        $_SESSION['last_name'] = $ln;
        // zapis pw sa len zdanlivo bije vid metoda vyssie, tato metoda ma sirsie 
        // pouzite, preto sa tieto 2 zapisy nebiju.
        $_SESSION['password'] = $pw;
        
    }

    //2.2
    /**
     * Vynuluje hodnoty session zodpovedajuce userovi.
     *
     * @param session klientuv session.
     *
     */
    public static function cleanSesQuest() {
        $_SESSION['uid'] = "";
        $_SESSION['login'] = "";
        $_SESSION['first_name'] = "";
        $_SESSION['last_name'] = "";
        $_SESSION['password'] = "";
        $_SESSION['questionaire'] = "";
        $_SESSION['q_table'] = "";
        $_SESSION['sel_user'] = "";         
    }

    //3.
    /**
     * inicializuje messsage.
     *
     * @param attr atribut session
     *
     */
    public static function nastavMessage($attr) {

        $mess =  $_SESSION[$attr];
        if ($mess == null) {
            //Este nebolo definovane:
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

        switch(q_tab){
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
     * @return
     */
    public static function checkDbUserQueries($uid) {

        //array   <List<String>> listAll = new ArrayList<>();
        //List<String> listYes = new ArrayList<>(), listNo = new ArrayList<>();

        $query1 = "SELECT q_tableName from T_QUERY";

        $preQuery = "SELECT user_id from ";
        $postQuery = " WHERE user_id = " . $uid;
        $listYes = array();
        $listNo = array();
        $listAll = array();

        /*
        foreach ($pole as &$value) {
            echo "*".$value."*<br/>";
        }*/

        try {
            
            $result1 = mysql_query($query1);
            
            while (list($q_tableName) = mysql_fetch_array($result1)) {
                $tn = $q_tableName;
            
                //prohledavani dotaznikovych tabulek: 
                $query2 = $preQuery.$tn.$postQuery;

                $result2 = mysql_query($query2);
                while (list($user_id) = mysql_fetch_array($result2)) {
                    $userId = $user_id;
                }
                if (($userId != null) && !$userId != "") {
                    array_push($listYes, $tn);
                    $userId = "";
                } else {
                    array_push($listNo, $tn);
                    listNo.add(tn);
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
       
            $strBut = "";
            $strBut = $strBut."<div>\n";
            $strBut = $strBut."<form action=\"P4.php\" method=\"post\">\n";
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
        $query = "SELECT role from T_USER where id =" . $uid;

        try {
            //$result = mysql_db_query(DBconn::$DATABASE, $query, DBconn::$connection);
            $result = mysql_query($query);
            while (list($role) = mysql_fetch_array($result)) {
                $rol = $role;
            }
            mysql_close();
            return ($rol == "A");
            
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
     * @return 
     *
     */
    public static function checkPassword($lg, $pw) {

        $query = "SELECT password from T_USER WHERE login LIKE '" . $lg . "'";
        $realPw = "";
        //pw netreba sifrovat, lebo prichadza uz zasifrovane.
        
        try {

            $result = mysql_query($query);
            while (list($password) = mysql_fetch_array($result)) {
                $realPw = $password;
            }
            mysql_close();
            return ($realPw == null ? false : ($realPw == $pw));

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

        $comboNames = array();
        $query = "SELECT id, first_name, last_name from T_USER where role NOT LIKE 'A'";
        
        try {
            //$result = mysql_db_query(DBconn::$DATABASE, $query, DBconn::$connection);
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
     * @throws java.sql.SQLException
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
     * @throws java.sql.SQLException
     */
    public static function deleteDbId($uid) {
        
        $queryTables = Pom::getQueryTableNames();
        $queries = array();
        
        foreach ($queryTables as &$tab) {
            $sqlq = "DELETE FROM " . $tab . " WHERE user_id = " . $uid;
            array_push($queries, $sqlq);
        }
        $sqlu = "DELETE FROM T_USER WHERE id = " . $uid;
        
        //deleting in queries tables:
        foreach ($queries as &$sql) {
            try {
                //mysql_db_query(DBconn::$DATABASE, $sql, DBconn::$connection);
                mysql_query($sql);
            
            } catch (SQLException $e) {
                echo "Caught exception: ", $e->getMessage(), "\n";
            } 
        }
        
        
        //deleting in T_USER table:
        try {
            //mysql_db_query(DBconn::$DATABASE, $sqlu, DBconn::$connection);
            mysql_query($sqlu);
            
        } catch (SQLException $e) {
            echo "Caught exception: ", $e->getMessage(), "\n";
        } 
        
        mysql_close();

    }

    //19.
    /**
     * Vrati zoznam mien DB tabuliek dotaznikov
     *
     * @return zoznam databazovych tabuliek, ktore zodpovedaju dotaznikom.
     * @throws java.sql.SQLException
     */
    private static function getQueryTableNames() {

        $queryTables = array();
        $query = "SELECT q_tableName FROM T_QUERY";
        
        try {
            //$result = mysql_db_query(DBconn::$DATABASE, $query, DBconn::$connection);
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
        $str = "<div id=\"patickaR\">\n"
        . "<form action=\"P6.php\" method=\"post\">\n"
        . "<input type=\"submit\" value=\"GO ADMIN\"/>\n"
        . "</form>\n"
        . "</div>\n"
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
    
        $str = "<div id=\"patickaR\">\n"
        . "<form action=\"P1_1.php\" method=\"post\">\n"
        . "<input type=\"submit\" value=\"INIT DB\"/>\n"
        . "</form>\n"
        . "</div>\n"
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
        $str = "<div id=\"patickaR\">\n"
        . "<form action=\"P4.php\" method=\"post\">\n"
        . "<input type=\"submit\" value=\"GO USER\"/>\n"
        . "</form>\n"
        . "</div>\n"
        . "<br/>";
        
        return $str;
    }

    //23.
    /**
     * Zjistuje jestli existuje DB tabulka T_USER, 
     * na zaklade ceho usoudi, jestli ma spustit inicializaci DB.
     *
     * @return ano/ne pro existenci T_USER v databazi.
     */
    public static function existsT_USER() {
        
        try {
            $sql = "SELECT * FROM T_USER";
            //mysql_db_query(DBconn::$DATABASE, $sql, DBconn::$connection);
            mysql_query($sql);
            
            mysql_close();
            return true;
        } catch (SQLException $e) {
            echo "Caught exception: ", $e->getMessage(), "\n";
            mysql_close();
            return false;
        } 
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
        $listIds = array();
        $query = "SELECT id from T_USER";
        
        //$result = mysql_db_query(DBconn::$DATABASE, $query, DBconn::$connection);
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
        
        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '" 
                . $tn . "' AND TABLE_SCHEMA = '" . DBconn::$DATABASE."'";
        
        mysql_select_db(DBconn::$DATABASE);
        
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
    private static function getQuestions($tn) {
        
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
