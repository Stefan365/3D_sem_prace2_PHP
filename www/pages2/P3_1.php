<?php 



/**
 * Vstupna invisible stranka. Kontrola prihlasovacich udajov.Nastavenie vstupov 
 *
 * @author Stefan Veres
 */

        try{
            $lg = filter_input(INPUT_POST, 'login');
            $pw = filter_input(INPUT_POST, 'password');
            
            //sifrovanie hesla:
            //$pwc = CryptMD5::crypt($pw);

            //A. Kontrola jestli je uzivatel prihlaseny (keby chcel obist prihlasovaciu stranku)
            if (!Pom::checkPassword($lg, $pw)){
                $message = "PLEASE LOGIN OR REGISTER!";
                header("Location: P1.php");
                die();
            }
            
            //po prihlaseni se nastavi hl. parametry session:
            Pom::cleanSesQuest();//vynuluje eventualne stare hodnoty 
            Pom::zapisSesUser();//zapise do session nove hodnoty
            
            //Vsechno je v poradku, chod na oficialnuvstupnu stranku:
            header("Location: P4.php");
            die();


        } catch (SQLException $ex) {
            echo "Caught exception: ", $ex->getMessage(), "\n";
            $_SESSION['message'] = "TRY IT AGAIN PLEASE, INCORRECT LOGIN OR PASSWORD!";
            //Posli spat: 
            header("Location: P3.php");
            die();
  
        }

