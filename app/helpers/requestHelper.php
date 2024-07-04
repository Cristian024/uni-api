<?php

namespace App\Helpers;

use App\Controllers\General\ResponseController;

class RequestHelper
{
    public static function getParams()
    {
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            return $data;
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }

    public static function getIPAddress()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public static function getCookie($key)
    {
        $cookie = null;
        if (isset($_COOKIE[$key])) {
            $cookie = $_COOKIE[$key];
        }

        return $cookie;
    }

    public static function createCookie($long, $key)
    {
        $cookie = substr(bin2hex(random_bytes($long)), 0, $long);

        setcookie($key, $cookie, time() + 3600000000, '/');

        return $cookie;
    }

    public static function getIdParam(){
        global $queryId;

        if($queryId != null){
            return $queryId;
        }else{
            ResponseController::sentBadRequestResponse("ID is required");
        }
    }

    public static function deleteCookie($key)
    {
        setcookie($key, "", time() - 3600, "/");
    }
}