<?php

namespace App\Models;

use App\Controllers\General\DataBaseController;
use App\Controllers\General\ResponseController;
use App\Helpers\DatabaseHelper;
use App\Helpers\RequestHelper;

class Session
{
    public $id;
    public $user_id;
    public $session_date;
    public $cookie;
    public $user_ip;
    public $user_role;

    private static $SESSION_VALID_CODE = 201;

    function __construct($id, $user_id, $session_date, $cookie, $user_ip, $user_role)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->session_date = $session_date;
        $this->cookie = $cookie;
        $this->user_ip = $user_ip;
        $this->user_role = $user_role;
    }

    public static function getSession($filter)
    {
        $sql = DatabaseHelper::createFilterRows("sessions", "s")->_all()->_cmsel()->addFilter($filter);
        return DataBaseController::executeConsult($sql);
    }

    public static function insertSession($data)
    {
        return DataBaseController::executeInsert('sessions', Session::class, $data);
    }

    public static function deleteSession($filter)
    {
        return DataBaseController::executeDelete('sessions', $filter);
    }

    public static function validateSession($role)
    {
        $sessionResponse = new \stdClass;

        $cookie = RequestHelper::getCookie('session');

        if ($cookie == null)
            ResponseController::sentBadRequestResponse('Session cookie not provided');

        $filter = DatabaseHelper::createFilterCondition("")->_eq("cookie", $cookie);
        $result = Session::getSession($filter);

        if (count($result) == 0) {
            RequestHelper::deleteCookie('session');
            ResponseController::sentNotFoundResponse('Session not found');
        } else {
            $session = $result[0];

            if ($session['user_role'] != $role)
                ResponseController::sentBadRequestResponse('User is not authorized');

            $sessionResponse->code = Session::$SESSION_VALID_CODE;
            $sessionResponse->message = 'Session is valid';
            $sessionResponse->user_id = $result[0]['user_id'];
        }

        return $sessionResponse;
    }

    public static function createSession($user_id, $role)
    {
        date_default_timezone_set('America/Bogota');
        $session_date = date('Y/m/d H:i:s');
        $cookie = RequestHelper::createCookie(50, 'session');
        $ip = RequestHelper::getIPAddress();

        $session = new Session(null, $user_id, $session_date, $cookie, $ip, $role);

        $fields = DatabaseHelper::extractParams(Session::class, $session, 'insert');

        $result = Session::insertSession($fields);

        $session->id = $result->id;

        return $session;
    }

    public static function closeSession($user)
    {
        $session = RequestHelper::getCookie('session');
        RequestHelper::deleteCookie('session');

        if ($session == null)
            ResponseController::sentBadRequestResponse('Session is not provided');

        $filter = DatabaseHelper::createFilterCondition('')->_eq('cookie', $session);
        Session::deleteSession($filter);
    }
}