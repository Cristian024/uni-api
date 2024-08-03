<?php

namespace Config;

class Credentials
{
    /*
    ####PRODUCTION####
    public static $SERVER = "roundhouse.proxy.rlwy.net";
    public static $USER = "root";
    public static $PASSWORD = "mlHCNqynAOKwbMsRfsuWBevsHwXvesri";
    public static $DATABASE = "railway";
    public static $PORT = "33345";
    public static $ACCESS_TOKEN = "Fq0830jA9h5pEeAvdTW5wDglb9JFqBju5RDtls5xKGVVXJAPOwto3bB5ivvVU14E";
    */


    ####DEV####
    public static $SERVER = "";
    public static $USER = "";
    public static $PASSWORD = "";
    public static $DATABASE = "";
    public static $PORT = "";
    public static $ACCESS_TOKEN = "";

    public static function useProduction($useProduction)
    {
        if($useProduction){
            Credentials::$SERVER = $_ENV['SERVER'];
            Credentials::$USER = $_ENV['USER'];
            Credentials::$PASSWORD = $_ENV['PASSWORD'];
            Credentials::$DATABASE = $_ENV['DATABASE'];
            Credentials::$PORT = $_ENV['PORT'];
            Credentials::$ACCESS_TOKEN = $_ENV['ACCESS_TOKEN'];
        }
    }

}