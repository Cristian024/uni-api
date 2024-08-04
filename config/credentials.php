<?php

namespace Config;

use App\Controllers\General\ResponseController;

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
        if ($useProduction) {
            Credentials::$SERVER = $_ENV['SERVER'];
            Credentials::$USER = $_ENV['USER'];
            Credentials::$PASSWORD = $_ENV['PASSWORD'];
            Credentials::$DATABASE = $_ENV['DATABASE'];
            Credentials::$PORT = $_ENV['PORT'];
            Credentials::$ACCESS_TOKEN = $_ENV['ACCESS_TOKEN'];
        } else {
            $route = __DIR__ . '/../config/develop.json';

            $develop_json = file_get_contents($route);

            $data = json_decode($develop_json, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                Credentials::$SERVER = $data['SERVER'];
                Credentials::$USER = $data['USER'];
                Credentials::$PASSWORD = $data['PASSWORD'];
                Credentials::$DATABASE = $data['DATABASE'];
                Credentials::$PORT = $data['PORT'];
                Credentials::$ACCESS_TOKEN = $data['ACCESS_TOKEN'];
            } else {
                ResponseController::sentBadRequestResponse('Develop JSON not provided');
            }
        }
    }
}