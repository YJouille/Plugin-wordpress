<?php
class Database
{   
    /**
     * connect Connection to database method   
     *
     * @return $dbb database object
     */
    public function connect()
    {
        
        //Database localisation localhost
        if(!defined('HOST')) define ('HOST', 'localhost');
        //User name
        if(!defined('USER')) define('USER', 'root');
        //Password
        if(!defined('PASSWD')) define('PASSWD', 'root');
        //Database name
        if(!defined('DBNAME')) define('DBNAME', 'meteo');

        //Database localisation server
        // if(!defined('HOST')) define ('HOST', 'localhost');
        // //User name
        // if(!defined('USER')) define('USER', 'yaminaj');
        // //Password
        // if(!defined('PASSWD')) define('PASSWD', 'hmz7w+ZA8wDuqw==');
        // //Database name
        // if(!defined('DBNAME')) define('DBNAME', 'yaminaj_travaux');

        try
         {
            $bdd = new PDO('mysql:host='. HOST.';dbname='.DBNAME, USER, PASSWD,[
                // Gestion des erreurs PHP/SQL
		        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
		        // Gestion du jeu de caractères
		        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
		        // Choix du retours des résultats
		        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            return $bdd; 
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
    }    
}