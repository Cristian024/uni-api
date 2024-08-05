<?php

namespace App\Models;

use App\Controllers\General\ResponseController;
use App\Helpers\RequestHelper;

class Users extends Model
{
    public $id;
    public $email;
    public $password;
    public $register_date;
    public $role;
    public $state;
    public $block;

    function __construct($id, $email, $password, $register_date, $role, $state, $block)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->register_date = $register_date;
        $this->role = $role;
        $this->state = $state;
        $this->block = $block;
    }
    public static function userRegister()
    {
        $registerResponse = new \stdClass;

        $params = RequestHelper::getParams();

        if (!isset($params['password']))
            ResponseController::sentBadRequestResponse('Password not provided');

        if (!isset($params['role']))
            ResponseController::sentBadRequestResponse('Role not provided');

        if (!isset($params['email']))
            ResponseController::sentBadRequestResponse('Email not provided');

        $userExists = Users::userExists($params['email']);

        if ($userExists != null) {
            ResponseController::sentBadRequestResponse('User already exists');
        } else {
            $user = new Users(null, $params['email'], md5($params['password']), date('Y-m-d H:i:s'), $params['role'], 'active', true);
            $response = Users::_insert($user)->_init();

            if ($params['role'] == 'student') {
                $student = new Students(null, null, null, null, null, null, null, null, null, null, $response->id);
                Students::_insert($student)->_init();
            } else if ($params['role'] == "enterprise") {
                $enterprise = new Enterprises(null, null, null, null, null, null, $response->id);
                Enterprises::_insert($enterprise)->_init();
            }

            $session = Sessions::createSession($response->id, $params['role']);

            $registerResponse->message = 'User successfully registered';
            $registerResponse->user_id = $response->id;
            $registerResponse->session = $session;
        }

        return $registerResponse;
    }

    public static function userLogin()
    {
        $loginResponse = new \stdClass;

        $params = RequestHelper::getParams();

        if (!isset($params['query']))
            ResponseController::sentBadRequestResponse('Query parameters not provided (id, name or email)');

        if (!isset($params['password']))
            ResponseController::sentBadRequestResponse('Password not provided');

        $user = Users::userExists($params['query']);

        if ($user == null) {
            ResponseController::sentNotFoundResponse('User not found');
        } else if (md5($params['password']) != $user['password']) {
            ResponseController::sentBadRequestResponse('Incorrect password');
        } else {
            $session = Sessions::createSession($user['id'], $user['role']);
            $loginResponse->message = 'Session successfully created';
            $loginResponse->session = $session;
        }

        return $loginResponse;
    }

    public static function userLogout()
    {
        $logoutResponse = new \stdClass;

        $params = RequestHelper::getParams();

        if (!isset($params['user_id'])) {
            ResponseController::sentBadRequestResponse('User not provided');
        }

        Sessions::closeSession($params['user_id']);

        $logoutResponse->message = "Session was clossed";
        return $logoutResponse;
    }

    private static function userExists($row)
    {
        $filter = Filter::_create()->_eq('id', $row)->_or()->_eq('email', $row);
        $result = Users::_consult()->_all()->_cmsel()->_filter($filter)->_init();

        if (count($result) == 0) {
            return null;
        } else {
            return $result[0];
        }
    }
}
