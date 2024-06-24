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
    public $last_name;
    public $age;
    public $email;
    public $password;
    public $cellphone;
    public $date_of_birth;
    public $gender;
    public $faculty;
    public $career;
    public $student_code;

    function __construct($id, $name, $last_name, $age, $email, $password, $cellphone, $date_of_birth, $gender, $faculty, $career, $student_code)
    {
        $this->id = $id;
        $this->name = $name;
        $this->last_name = $last_name;
        $this->age = $age;
        $this->email = $email;
        $this->password = $password;
        $this->cellphone = $cellphone;
        $this->date_of_birth = $date_of_birth;
        $this->gender = $gender;
        $this->faculty = $faculty;
        $this->career = $career;
        $this->student_code = $student_code;
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

        if (!isset($params['last_name']))
            ResponseController::sentBadRequestResponse('Last name not provided');

        if (!isset($params['email']))
            ResponseController::sentBadRequestResponse('Email not provided');

        $userExists = User::userExists($params['email']);

        if ($userExists != null) {
            ResponseController::sentBadRequestResponse('User already exists');
        } else {
            $user = new User(null, $params['name'], $params['last_name'], null, $params['email'], md5($params['password']), null, null, null, null, null, null);
            $fields = DatabaseHelper::extractParams(User::class, $user, 'insert');
            $response = User::insertUser($fields);

            $session = Session::createSession($response->id);

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
            $session = Session::createSession($user['id']);
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
