<?php

namespace App\Controllers\Users;

use App\Controllers\General\ResponseController;
use App\Helpers\DatabaseHelper;
use App\Helpers\RequestHelper;
use App\Models\Enterprise;
use App\Models\Student;
use App\Models\User;

class UserController
{
    public static function getAllUsers()
    {
        ResponseController::sentSuccessflyResponse(User::getUsers(null));
    }

    public static function getUserById()
    {
        $filter = DatabaseHelper::createFilterCondition("")->_eq("id", RequestHelper::getIdParam());
        ResponseController::sentSuccessflyResponse(User::getUsers($filter));
    }

    public static function getUserByAnyType()
    {
        $filter = DatabaseHelper::createFilterCondition("")->_eq("id", RequestHelper::getIdParam());
        $result = User::getUsers($filter);

        $filter_type = DatabaseHelper::createFilterCondition("")->_eq("user_id", RequestHelper::getIdParam());

        if (sizeof($result) > 0) {
            $user = $result[0];
            switch ($user['role']) {
                case 'student':
                    ResponseController::sentSuccessflyResponse(Student::getStudent($filter_type));
                    break;
                case 'enterprise':
                    ResponseController::sentSuccessflyResponse(Enterprise::getEnterprise($filter_type));
                    break;
                default:
                    ResponseController::sentDatabaseErrorResponse('User role not defined');
                    break;
            }
        }else{
            ResponseController::sentDatabaseErrorResponse('User not found');
        }
    }

    public static function insertUser()
    {
        $data = User::insertUser(null);
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function updateUser()
    {
        $data = User::updateUser(null);
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function deleteUser()
    {
        $data = User::deleteUser();
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function userLogin()
    {
        $data = User::userLogin();
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function userRegister()
    {
        $data = User::userRegister();
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function userLogout()
    {
        $data = User::userLogout();
        ResponseController::sentSuccessflyResponse($data);
    }
}