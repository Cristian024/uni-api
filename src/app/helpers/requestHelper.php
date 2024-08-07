<?php

namespace App\Helpers;

use App\Controllers\General\ResponseController;
use Exception;

class RequestHelper
{
    public static $HEADERS = null;
    public static $BODY = null;
    public static $PARAMS = null;
    public static $COOKIES = null;
    public static $QUERYID = null;

    public static function getParams()
    {
        if(RequestHelper::$BODY === null){
            throw new \UnexpectedValueException("Body not provided");
        }else{
            return RequestHelper::$BODY;
        }
    }

    public static function getParam($key)
    {
        $params = RequestHelper::getParams();
        if (isset($params[$key])) {
            return $params[$key];
        } else {
            return null;
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

        $cookieHeader = "$key=$cookie; Path=/; HttpOnly; Secure; SameSite=Strict";

        ResponseController::$COOKIES_TO_SEND[] = $cookieHeader;

        return $cookie;
    }

    public static function getIdParam()
    {
        if (RequestHelper::$QUERYID != null) {
            return RequestHelper::$QUERYID;
        } else {
            throw new \UnexpectedValueException('ID is required');
        }
    }

    public static function deleteCookie($key)
    {
        setcookie($key, "", time() - 3600, "/");
    }
}