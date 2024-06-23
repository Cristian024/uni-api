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

    private static $SESSION_VALID_CODE = 201;

    function __construct($id, $user_id, $session_date, $cookie, $user_ip)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->session_date = $session_date;
        $this->cookie = $cookie;
        $this->user_ip = $user_ip;
    }

    public static function getSession($field)
    {
        $sql = "SELECT * FROM sessions";
        return DataBaseController::executeConsult($sql, $field);
    }

    public static function insertSession($data)
    {
        return DataBaseController::executeInsert('sessions', Session::class, $data);
    }

    public static function deleteSession($column)
    {
        return DataBaseController::executeDelete('sessions', $column);
    }

    public static function validateSession()
    {
        $sessionResponse = new \stdClass;

        $cookie = RequestHelper::getCookie('session');

        if ($cookie == null)
            ResponseController::sentBadRequestResponse('Session cookie not provided');

        $sql = "SELECT * FROM sessions WHERE cookie = '$cookie'";
        $result = DataBaseController::executeConsult($sql, null);
        if (count($result) == 0) {
            ResponseController::sentNotFoundResponse('Session not found');
        } else {
            $sessionResponse->code = Session::$SESSION_VALID_CODE;
            $sessionResponse->message = 'Session is valid';
        }

        return $sessionResponse;
    }

    public static function createSession($user_id)
    {
        date_default_timezone_set('America/Bogota');
        $session_date = date('d/m/Y H:i:s');
        $cookie = RequestHelper::createCookie(50,'session');
        $ip = RequestHelper::getIPAddress();

        $session = new Session(null, $user_id, $session_date, $cookie, $ip);

        $fields = DatabaseHelper::extractParams(Session::class, $session, 'insert');

        $result = Session::insertSession($fields);

        $session->id = $result->id;

        return $session;
    }
}