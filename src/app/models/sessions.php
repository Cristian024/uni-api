<?php

namespace App\Models;

use App\Helpers\RequestHelper;

class Sessions extends Model
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

    public static function validateSession($role)
    {
        $sessionResponse = new \stdClass;

        $cookie = RequestHelper::getCookie('session');

        if ($cookie == null)
            throw new \UnexpectedValueException('Session cookie not provided');

        $result = Sessions::_consult()->_all()->_cmsel()->_filter(
            Filter::_create()->_eq('cookie', $cookie)
        )->_init();

        if (count($result) == 0) {
            RequestHelper::deleteCookie('session');
            throw new \UnexpectedValueException('Session not found');
        } else {
            $session = $result[0];

            if ($session['user_role'] != $role && $role != 'any')
                throw new \UnexpectedValueException('User is not authorized');

            $user = Users::_consult()->_all()->_cmsel()->_id($session['user_id'])->_init();

            if (sizeof($user) > 0) {
                $sessionResponse->code = Sessions::$SESSION_VALID_CODE;
                $sessionResponse->message = 'Session is valid';
                $sessionResponse->user_id = $session['user_id'];
                $sessionResponse->role = $session['user_role'];
            } else {
                RequestHelper::deleteCookie('session');
                throw new \UnexpectedValueException('User not found');
            }
        }

        return $sessionResponse;
    }

    public static function createSession($user_id, $role)
    {
        try {
            date_default_timezone_set('America/Bogota');
            $session_date = date('Y/m/d H:i:s');
            $cookie = RequestHelper::createCookie(50, 'session');
            $ip = RequestHelper::getIPAddress();

            $session = new Sessions(null, $user_id, $session_date, $cookie, $ip, $role);
            $result = Sessions::_insert($session)->_init();

            $session->id = $result->id;

            return $session;
        } catch (\Exception $e) {
            throw new \Exception('Error al crear la sesiónn');
        }
    }

    public static function closeSession($user)
    {
        $session = RequestHelper::getCookie('session');
        RequestHelper::deleteCookie('session');

        if ($session == null)
            throw new \UnexpectedValueException('Session has not provided');

        Sessions::_delete()->_filter(Filter::_create()->_eq('cookie', $session))->_init();
    }
}