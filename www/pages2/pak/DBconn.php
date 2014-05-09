<?php

include './../pages2/pak/CryptMD5.php';

/**
 *
 * @author Stefan Veres
 */
class DBconn {

    static $DBHOST = "localhost";
    static $DATABASE = "php_project1";
    static $USER = "root";
    static $PASSWORD = "";
    
    static $connection;
    
    static function connect(){
        DBconn::$connection = mysql_connect(DBconn::$DBHOST, DBconn::$USER, DBconn::$PASSWORD);
        mysql_select_db(DBconn::$DATABASE);
        mysql_set_charset('utf8');
    
    }
    
    static function initDbSettings(){
        DBconn::connect();
        
        mysql_set_charset('utf8');
        //nastavenie kodovania DB na utf-8:
        $sql = "SET NAMES 'utf8'";
        mysql_query($sql);
        
        mysql_close();
    }
    
    //1.0
    /**
     * Vytvori tabulku T_USER. Sluzi na ukladanie udajov o zaregistrocanych uzivateloch
     * 
     * @throws java.sql.SQLException
     */
    private static function createTableUser() {
        DBconn::connect();
        $sql = "CREATE TABLE T_USER"
            ." (id INTEGER not NULL AUTO_INCREMENT, first_name VARCHAR(30),"
            ." last_name VARCHAR(30),  login VARCHAR(30) NOT NULL, password VARCHAR(50) NOT NULL,"
            ." role VARCHAR(1),"
            
            ." PRIMARY KEY(id),"
            ." CONSTRAINT usr_UN UNIQUE(login))";

        //mysql_select_db(DBconn::$DATABASE);
        mysql_query($sql);
        mysql_close();
    }

    //1.1
     /**
     * Vytvori tabulku T_Q1. Dotaznikova tabulka 1.
     * 
     * @throws java.sql.SQLException
     */
    private static function createTableQ1() {
        DBconn::connect();
        
        $sql = "CREATE TABLE T_Q1"
            ." (id INTEGER NOT NULL AUTO_INCREMENT, gender VARCHAR(5) NOT NULL, "
            ." age_group VARCHAR(30) NOT NULL, education VARCHAR(30) NOT NULL, "
            ." income VARCHAR(30) NOT NULL,"
            ." q1 VARCHAR(15) NOT NULL, q2 VARCHAR(5) NOT NULL, q3 VARCHAR(5) NOT NULL,"
            ." user_id INTEGER NOT NULL,"
            
            ." PRIMARY KEY ( id ),"
            ." CONSTRAINT q1_FK FOREIGN KEY(user_id) REFERENCES t_user(id),"
            ." CONSTRAINT q1_UN UNIQUE(user_id))"; //uzivatel muze vyplnit anketu jen jednou

        //mysql_select_db(DBconn::$DATABASE);
        mysql_query($sql);
        mysql_close();
   }
    
    //1.2
    /**
     * Vytvori tabulku T_Q2. Dotaznikova tabulka 2.
     * 
     * @throws java.sql.SQLException
     */
    private static function createTableQ2() {
        DBconn::connect();
        
        $sql = "CREATE TABLE T_Q2"
            ." (id INTEGER NOT NULL AUTO_INCREMENT, gender VARCHAR(5) NOT NULL,"
            ." age_group VARCHAR(30) NOT NULL,  education VARCHAR(30) NOT NULL,"
            ." income VARCHAR(30) NOT NULL,"
            ." q1 VARCHAR(15) NOT NULL, q2 VARCHAR(15) NOT NULL, q3 VARCHAR(5) NOT NULL,"
            ." q4 VARCHAR(5) NOT NULL, q5 VARCHAR(5) NOT NULL, q6 VARCHAR(5) NOT NULL,"
            ." q7 VARCHAR(5) NOT NULL,"
            ." user_id INTEGER NOT NULL,"
            
            ." PRIMARY KEY(id),"
            ." CONSTRAINT q2_FK FOREIGN KEY(user_id) REFERENCES t_user(id),"
            ." CONSTRAINT q2_UN UNIQUE(user_id))"; //uzivatel muze vyplnit anketu jen jednou

        //mysql_select_db(DBconn::$DATABASE);
        mysql_query($sql);
        mysql_close();
    }
    
    //1.3
     /**
     * Vytvori tabulku T_QUERY. Tato tabulka predstavuje zoznam 
     * vs. dotaznikovych tabuliek v systeme.
     * 
     * @throws java.sql.SQLException
     */
    private static function createTableQueries() {
        DBconn::connect();
        
        $sql = "CREATE TABLE T_QUERY"
            ." (id INTEGER NOT NULL AUTO_INCREMENT, q_tableName VARCHAR(20) NOT NULL, "
            
            ." PRIMARY KEY(id),"
            ." CONSTRAINT q_UN UNIQUE(q_tableName))"; //dany dotaznik je v DB jen jednou

        //mysql_select_db(DBconn::$DATABASE);
        mysql_query($sql);
        mysql_close();
    }
    
    
    //2.0 Inserting new values:
    /**
     * Vlozi do tab. T_USER novy riadok.
     * 
     * @param fn first name
     * @param ln last name
     * @param lg login
     * @param pw password
     * @param rol user role
     * @throws java.sql.SQLException
     */
    public static function insertValuesUser($fn, $ln, $lg, $pw, $rol) {
        
        DBconn::connect();
        
        $sql = "INSERT INTO T_USER (first_name, last_name, login, password, role) "
                ."VALUES ('$fn','$ln','$lg','$pw','$rol')";

        mysql_query($sql);
        mysql_close();
    }

    //2.1
    /**
     * Upravi existujuce hodnoty v tab. T_USER.
     * 
     * @param uid user id
     * @param fn first name
     * @param ln last name
     * @param pw password
     * @throws java.sql.SQLException
     */
    public static function updateValuesUserA($uid, $fn, $ln, $pw) {
        
        DBconn::connect();
        
        $sql = "UPDATE T_USER SET first_name = '$fn', "
            ."last_name= '$ln', "
            ."password= '$pw'"
            ." WHERE id = $uid";
        
        mysql_query($sql);
        mysql_close();
    }

    //2.2
    /**
     * Upravi existujuce hodnoty v tab. T_USER.
     * 
     * @param uid
     * @param fn first name
     * @param ln last name
     * @param role
     * @param pw password
     * @throws java.sql.SQLException
     */
    public static function updateValuesUser($uid, $fn, $ln, $pw, $role) {
        
        DBconn::connect();
        
        $sql = "UPDATE T_USER SET first_name = '$fn', "
            ."last_name= '$ln', "
            ."password= '$pw', "
            ."role= '$role'"
            ." WHERE id = $uid";

        mysql_query($sql);
        mysql_close();
    }

    //2.3
    /**
     * Vlozi do tab. T_Q1 alebo T_Q2 novy riadok.
     * 
     * @param qTable nazov DB tabulky, (tj. T_Q1 alebo TQ_2)
     * @param gen gender
     * @param ag age group
     * @param ed education
     * @param ig income group
     * @param q1 question 1
     * @param q2 question 2
     * @param q3 question 3
     * @param q4 question 4
     * @param q5 question 5
     * @param q6 question 6
     * @param q7 question 7
     * @param uid user id
     * 
     * @throws java.sql.SQLException
     */
    public static function insertValuesQ($qTable, $gen, $ag, $ed, $ig, 
            $q1, $q2, $q3, $q4, $q5, $q6, $q7, $uid)  {

        DBconn::connect();
        
        $part1 = "INSERT INTO ".$qTable;
        
        
        switch ($qTable) {
            case "T_Q1":
                $part2 = " (gender, age_group, education, income, q1, q2, q3, user_id)";
                $part3 = " VALUES ('$gen', '$ag', '$ed', '$ig', '$q1', '$q2', '$q3', '$uid')";
                break;
            case "T_Q2":
                $part2 = " (gender, age_group, education, income, q1, q2, q3, q4, q5, q6, q7, user_id)";
                $part3 = " VALUES ('$gen', '$ag', '$ed', '$ig', '$q1', '$q2', '$q3', '$q4', '$q5', '$q6', '$q7'"
                        .", '$uid')";
                break;
            default:
                return;
        }
        
        $sql = $part1 . $part2 . $part3;
        
        mysql_query($sql);
        mysql_close();
        
    }

    
    //2.4
    /**
     * Vlozi novy riadok do tabulky T_QUERY
     * 
     * @param tn DB table name
     * @throws java.sql.SQLException
     */
    public static function insertValuesT_QUERY($tn) {
        DBconn::connect();
        
        $sql = "INSERT INTO T_QUERY (q_tableName) "
            ." VALUES ('$tn')";
        
        mysql_query($sql);
        mysql_close();
        
    }
    
    
    
    
    //3.
    /**
     * Drop any table in DB
     * 
     * @param tn DB table name
     * @throws java.sql.SQLException
     */
    private static function dropTable($tn) {
        
        DBconn::connect();
        
        $sql = "DROP TABLE ".$tn;
        mysql_query($sql);
        mysql_close();
        
    }
    
    
    
    
    //4.0 gets user id
    /**
     * Ziska id daneho uzivatela na zaklade znameho login-u
     * 
     * @param login login uzivatela
     * @return 
     * @throws java.sql.SQLException
     */
    public static function getUserId($lg) {

        DBconn::connect();
        
        $sql = "SELECT id FROM T_USER WHERE login LIKE '$lg'";
        //mysql_select_db(DBconn::$DATABASE);
        $result = mysql_query($sql);
        
        $id= mysql_fetch_array($result);
        
        mysql_close();
        return $id[0];
    }

    //4.1  
    /**
     * gets users first name
     * 
     * @param uid id uzivatela
     * @return 
     * @throws java.sql.SQLException
     */
    public static function getUserFn($uid) {
        
        DBconn::connect();
        
        $sql = "SELECT first_name FROM T_USER WHERE id = $uid";
        $vysledok = mysql_query($sql);
        
        list($first_name)= mysql_fetch_array($vysledok);
        mysql_close();
        return $first_name;
        
    }
    
    //4.2
    /**
     * gets users last name
     * 
     * @param uid id uzivatela
     * @return 
     * @throws java.sql.SQLException
     */
    public static function getUserLn($uid) {
        
        DBconn::connect();
        
        $sql = "SELECT last_name FROM T_USER WHERE id = $uid";

        $vysledok = mysql_query($sql);

        list($last_name)= mysql_fetch_array($vysledok);
        
        mysql_close();
        return $last_name;
        
    }

    //4.3
    /**
     * gets users login
     * 
     * @param uid id uzivatela
     * @return 
     * @throws java.sql.SQLException
     */
    public static function getUserLg($uid) {
        
        DBconn::connect();
        
        $sql = "SELECT login FROM T_USER WHERE id = $uid";

        $vysledok = mysql_query($sql);

        list($login)= mysql_fetch_array($vysledok);        
        
        mysql_close();
        return $login;
    }

    //4.4 gets users password 
    /**
     * gets users password
     * 
     * @param uid id uzivatela
     * @return 
     * @throws java.sql.SQLException
     */
    public static function getUserPw($uid) {
        DBconn::connect();
        
        $sql = "SELECT password FROM T_USER WHERE id = $uid";
        $vysledok = mysql_query($sql);

        list($password)= mysql_fetch_array($vysledok);       
        
        mysql_close();  
        return $password;
    }

    //4.5 gets user role 
    /**
     * gets users role
     * 
     * @param uid id uzivatela
     * @return 
     * @throws java.sql.SQLException
     */
    public static function getUserRole($uid) {
        DBconn::connect();
        
        $sql = "SELECT role FROM T_USER WHERE id = $uid";

        $vysledok = mysql_query($sql);

        list($role)= mysql_fetch_array($vysledok);
        
        
        mysql_close();
        return $role;
    }

    //4.
    /**
     * Zjistuje jestli existuje DB tabulka T_USER, 
     * na zaklade ceho usoudi, jestli ma spustit inicializaci DB.
     *
     * @return ano/ne pro existenci T_USER v databazi.
     */
    public static function existsT_USER() {

        DBconn::connect();
        
        try {
            
            $sql = "SELECT COUNT(*) FROM information_schema.tables WHERE " 
                ."table_schema = '".DBconn::$DATABASE."'". 
                " AND table_name = 'T_USER'";
            $result = mysql_query($sql);
            $row  = mysql_fetch_row($result);            
            
            if ($row[0] == 1){
                return true;
            } else {
                return false;
            }
            
        } catch (SQLException $e) {
            echo "Caught exception: ", $e->getMessage(), "\n";
            return false;
        } 
    }
    
    //5.5 
    /**
     * initialize Database. tj. vytvori prislusne DB tabulky.
     * a naplni je nevyhnutnymi udaji.
     * 
     */
    public static function initDB() {
        if (DBconn::existsT_USER() == false){
            DBconn::initDbSettings();
            DBconn::createTableUser();
            DBconn::createTableQ1();
            DBconn::createTableQ2();
            DBconn::createTableQueries();
            DBconn::insertValuesT_QUERY("T_Q1");
            DBconn::insertValuesT_QUERY("T_Q2");
            DBconn::insertValuesUser("Stefan", "Veres", "admin", CryptMD5::crypt("admin"), "A");            
            return true;
            
        } else {
            return false;
        }
    }
    
}
