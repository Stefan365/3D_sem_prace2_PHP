<?php

class CryptMD5 {
   
   public static function crypt($pass){
       return crypt($pass, 'ABCDEFGH');       
   }
}
