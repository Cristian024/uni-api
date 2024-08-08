<?php

namespace App\Models;

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
            throw new \UnexpectedValueException('Password not provided');

        if (!isset($params['role']))
            throw new \UnexpectedValueException('Role not provided');

        if (!isset($params['email']))
            throw new \UnexpectedValueException('Email not provided');

        $userExists = Users::userExists($params['email']);

        if ($userExists != null) {
            throw new \Exception('User already exists');
        } else {
            if ($params['role'] != 'student' || $params['role'] != 'enterprise') {
                throw new \UnexpectedValueException("The role " . $params['role'] . " is not accepted");
            }

            $user = new Users(null, $params['email'], md5($params['password']), date('Y-m-d H:i:s'), $params['role'], 'active', true);
            $response = Users::_insert($user)->_init();

            switch ($params['role']) {
                case 'student':
                    $student = new Students(null, null, null, null, null, null, null, null, null, null, $response->id);
                    Students::_insert($student)->_init();
                    break;
                case 'role':
                    $enterprise = new Enterprises(null, null, null, null, null, null, $response->id);
                    Enterprises::_insert($enterprise)->_init();
                    break;
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
            throw new \UnexpectedValueException('Query parameters not provided (id, name or email)');

        if (!isset($params['password']))
            throw new \UnexpectedValueException('Password not provided');

        $user = Users::userExists($params['query']);

        if ($user == null) {
            throw new \Exception('User not found');
        } else if (md5($params['password']) != $user['password']) {
            throw new \UnexpectedValueException('Incorrect password');
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
            throw new \UnexpectedValueException('User not provided');
        }

        Sessions::closeSession($params['user_id']);

        $logoutResponse->message = "Session was clossed";
        return $logoutResponse;
    }

    private static function userExists($row)
    {
        try {
            $filter = Filter::_create()->_eq('id', $row)->_or()->_eq('email', $row);
            $result = Users::_consult()->_all()->_cmsel()->_filter($filter)->_init();

            if (count($result) == 0) {
                return null;
            } else {
                return $result[0];
            }
        } catch (\Exception $e) {
            throw new \Exception('Error in determining the existence of the user');
        }
    }
}
