<?php

namespace App\Helpers;

use App\Controllers\General\ResponseController;
use Exception;

class RequestHelper
{
    public static $EVENT = null;
    public static $HEADERS = null;
    public static $BODY = null;
    public static $PARAMS = null;
    public static $COOKIES = null;
    public static $QUERYID = null;
    public static $HTTP = null;

    public static function getParams()
    {
        if (RequestHelper::$BODY === null) {
            throw new \UnexpectedValueException("Body not provided");
        } else {
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

        if (RequestHelper::$HTTP === null) {
            $ipaddress = 'UNKNOWN';
        } else if (isset(RequestHelper::$HTTP['sourceIp'])) {
            $ipaddress = RequestHelper::$HTTP['sourceIp'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    public static function getCookie($key)
    {
        $cookie = null;
        if (RequestHelper::$COOKIES == null)
            throw new \UnexpectedValueException('Cookies not provided');

        foreach (RequestHelper::$COOKIES as $cookieF) {
            if (isset($cookieF[$key])) {
                $cookie = $cookieF[$key];
            }
        }

        return $cookie;
    }

    public static function createCookie($long, $key)
    {
        $cookie = substr(bin2hex(random_bytes($long)), 0, $long);

        $cookieHeader = "$key=$cookie; Expires= " . (time() + 40000) . "; Path=/; HttpOnly; Secure; SameSite=Strict";

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
        $cookie = "$key=; Expires= " . (time() - 3600) . "; Path=/; HttpOnly; Secure; SameSite=Strict";
        ResponseController::$COOKIES_TO_SEND[] = $cookie;
    }
}