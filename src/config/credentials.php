<?php

namespace Config;

use App\Controllers\General\ResponseController;

class Credentials
{
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