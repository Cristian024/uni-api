<?php

namespace App\Models;

use App\Controllers\General\DataBaseController;
use App\Controllers\General\ResponseController;
use App\Helpers\DatabaseHelper;
use App\Helpers\RequestHelper;
use App\Models\Session;
use App\Models\Student;

class User
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

    public static function getUsers($filter)
    {
        $sql = DatabaseHelper::createFilterRows("users", "u")->_all()->_cmsel()->addFilter($filter);
        return DataBaseController::executeConsult($sql);
    }

    public static function insertUser($data)
    {
        return DataBaseController::executeInsert('users', User::class, $data);
    }

    public static function updateUser($data)
    {
        return DataBaseController::executeUpdate('users', User::class, $data);
    }

    public static function deleteUser()
    {
        return DataBaseController::executeDelete('users', 'id');
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

        $userExists = User::userExists($params['email']);

        if ($userExists != null) {
            ResponseController::sentBadRequestResponse('User already exists');
        } else {
            $user = new User(null, $params['email'], md5($params['password']), date('Y-m-d H:i:s'), $params['role'], 'active', true);
            $fields = DatabaseHelper::extractParams(User::class, $user, 'insert');
            $response = User::insertUser($fields);

            if ($params['role'] == 'student') {
                $student = new Student(null, null, null, null, null, null, null, null, null, null, $response->id);
                $fields_s = DatabaseHelper::extractParams(Student::class, $student, 'insert');
                Student::insertStudent($fields_s);
            } else if ($params['role'] == "enterprise") {
                $enterprise = new Enterprise(null, null, null, null, null, null, $response->id);
                $fields_s = DatabaseHelper::extractParams(Enterprise::class, $enterprise, 'insert');
                Enterprise::insertEnterprise($fields_s);
            }

            $session = Session::createSession($response->id, $params['role']);

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

        $user = User::userExists($params['query']);

        if ($user == null) {
            ResponseController::sentNotFoundResponse('User not found');
        } else if (md5($params['password']) != $user['password']) {
            ResponseController::sentBadRequestResponse('Incorrect password');
        } else {
            $session = Session::createSession($user['id'], $user['role']);
            $loginResponse->message = 'Session successfully created';
            $loginResponse->session = $session;
        }

        return $loginResponse;
    }

    public static function userLogout(){
        $logoutResponse = new \stdClass;

        $params = RequestHelper::getParams();

        if(!isset($params['user_id'])){
            ResponseController::sentBadRequestResponse('User not provided');
        }

        Session::closeSession($params['user_id']);

        $logoutResponse->message = "Session was clossed";
        return $logoutResponse;
    }

    private static function userExists($row)
    {
        $filter = DatabaseHelper::createFilterCondition("")->_eq("id", $row)->_or()->_eq("email", $row);
        $result = User::getUsers($filter);

        if (count($result) == 0) {
            return null;
        } else {
            return $result[0];
        }
    }
}
