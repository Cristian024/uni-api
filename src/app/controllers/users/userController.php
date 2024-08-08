<?php

namespace App\Controllers\Users;

use App\Controllers\General\ResponseController;
use App\Helpers\RequestHelper;
use App\Models\Enterprises;
use App\Models\Filter;
use App\Models\Students;
use App\Models\Users;

class UserController
{
    public static function getAllUsers()
    {
        try {
            ResponseController::sentSuccessflyResponse(
                Users::_consult()->_all()->_cmsel()->_init()
            );
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }

    public static function getUserById()
    {
        try {
            ResponseController::sentSuccessflyResponse(
                Users::_consult()->_all()->_cmsel()->_id(RequestHelper::getIdParam())->_init()
            );
        } catch (\UnexpectedValueException $e) {
            ResponseController::sentBadRequestResponse($e->getMessage());
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }

    public static function getUserByAnyType()
    {
        try {
            $filter = Filter::_create()->_eq("id", RequestHelper::getIdParam());
            $result = Users::_consult()->_rows('id,role,email')->_cmsel()->_filter($filter)->_init();

            $filter_type = Filter::_create()->_eq("user_id", RequestHelper::getIdParam());

            if (sizeof($result) > 0) {
                $user = $result[0];
                switch ($user['role']) {
                    case 'student':
                        $student = Students::_consult()->_all()->_cmsel()->_filter($filter_type)->_init();
                        $student[0]['role'] = 'student';
                        $student[0]['email'] = $user['email'];
                        ResponseController::sentSuccessflyResponse(
                            $student
                        );
                        break;
                    case 'enterprise':
                        $enterprise = Enterprises::_consult()->_all()->_cmsel()->_filter($filter_type)->_init();
                        $enterprise[0]['role'] = 'enterprise';
                        $enterprise[0]['email'] = $user['email'];
                        ResponseController::sentSuccessflyResponse(
                            $enterprise
                        );
                        break;
                    default:
                        ResponseController::sentDatabaseErrorResponse('User has not role defined');
                        break;
                }
            } else {
                ResponseController::sentDatabaseErrorResponse('User not found');
            }
        } catch (\UnexpectedValueException $e) {
            ResponseController::sentBadRequestResponse($e->getMessage());
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }

    public static function insertUser()
    {
        try {
            ResponseController::sentSuccessflyResponse(
                Users::_insert(null)->_init()
            );
        } catch (\UnexpectedValueException $e) {
            ResponseController::sentBadRequestResponse($e->getMessage());
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }

    public static function updateUser()
    {
        try {
            ResponseController::sentSuccessflyResponse(
                Users::_update()->_id(RequestHelper::getIdParam())->_init()
            );
        } catch (\UnexpectedValueException $e) {
            ResponseController::sentBadRequestResponse($e->getMessage());
        } catch (\PDOException $e) {
            ResponseController::sentDatabaseErrorResponse($e->getMessage());
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }

    public static function deleteUser()
    {
        try {
            ResponseController::sentSuccessflyResponse(
                Users::_delete()->_id(RequestHelper::getIdParam())->_init()
            );
        } catch (\UnexpectedValueException $e) {
            ResponseController::sentBadRequestResponse($e->getMessage());
        } catch (\PDOException $e) {
            ResponseController::sentDatabaseErrorResponse($e->getMessage());
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }

    public static function userLogin()
    {
        try {
            ResponseController::sentSuccessflyResponse(Users::userLogin());
        } catch (\UnexpectedValueException $e) {
            ResponseController::sentBadRequestResponse($e->getMessage());
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }

    public static function userRegister()
    {
        try {
            ResponseController::sentSuccessflyResponse(Users::userRegister());
        } catch (\UnexpectedValueException $e) {
            ResponseController::sentBadRequestResponse($e->getMessage());
        } catch (\Exception $e) {
            ResponseController::sentInternalErrorResponse($e->getMessage());
        }
    }

    public static function userLogout()
    {
        try {
            ResponseController::sentSuccessflyResponse(Users::userLogout());
        } catch (\UnexpectedValueException $th) {
            ResponseController::sentBadRequestResponse($th->getMessage());
        } catch (\Exception $e){
            ResponseController::sentInternalErrorResponse($e->getMessage());
        } 
    }
}