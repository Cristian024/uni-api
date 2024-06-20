<?php

namespace App\Models;

use App\Controllers\General\DataBaseController;
use App\Controllers\General\ResponseController;
use App\Helpers\DatabaseHelper;
use App\Helpers\RequestHelper;
use App\Models\Session;

class User
{
    public $id;
    public $name;
    public $age;
    public $email;
    public $password;

    private static $USER_NOT_FOUND_CODE = 201;
    private static $INCORRECT_PASSWORD_CODE = 202;
    private static $USER_ALREADY_EXISTS = 203;

    function __construct($id, $name, $age, $email, $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
        $this->email = $email;
        $this->password = $password;
    }

    public static function getUsers($field)
    {
        $sql = "SELECT * FROM users";
        return DataBaseController::executeConsult($sql, $field);
    }

    public static function insertUser($data)
    {
        return DataBaseController::executeInsert('users', User::class, $data);
    }

    public static function updateUser()
    {
        return DataBaseController::executeUpdate('users', User::class);
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

        if (!isset($params['name']))
            ResponseController::sentBadRequestResponse('Name not provided');

        if (!isset($params['email']))
            ResponseController::sentBadRequestResponse('Email not provided');

        $userExists = User::userExists($params['email']);

        if ($userExists != null) {
            $registerResponse->code = User::$USER_ALREADY_EXISTS;
            $registerResponse->message = 'User already exists';
        } else {
            $user = new User(null, $params['name'], null, $params['email'], md5($params['password']));
            $fields = DatabaseHelper::extractParams(User::class, $user, 'insert');
            $response = User::insertUser($fields);

            $registerResponse->message = 'User successfully registered';
            $registerResponse->user_id = $response->id;
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
            $loginResponse->code = User::$USER_NOT_FOUND_CODE;
            $loginResponse->message = 'User not found';
        } else if (md5($params['password']) != $user['password']) {
            $loginResponse->code = User::$INCORRECT_PASSWORD_CODE;
            $loginResponse->message = 'Incorrect password';
        } else {
            $session = Session::createSession($user);
            $loginResponse->message = 'Session successfully created';
            $loginResponse->session = $session;
        }

        return $loginResponse;
    }

    private static function userExists($row)
    {
        $sql = "SELECT * FROM users WHERE id = '$row' || name = '$row' || email = '$row'";
        $result = DataBaseController::executeConsult($sql, null);

        if (count($result) == 0) {
            return null;
        } else {
            return $result[0];
        }
    }
}
