<?php

namespace App\Controllers\Users;

use App\Controllers\General\ResponseController;
use App\Helpers\RequestHelper;
use App\Models\Students;

class StudentController
{
    public static function getAllStudents()
    {
        ResponseController::sentSuccessflyResponse(
            Students::_consult()->_all()->_cmsel()->_init()
        );
    }

    public static function getStudentById()
    {
        ResponseController::sentSuccessflyResponse(
            Students::_consult()->_all()->_cmsel()->_id(RequestHelper::getIdParam())->_init()
        );
    }

    public static function getStudentByCode()
    {
        ResponseController::sentSuccessflyResponse(
            Students::_consult()->_all()->_cmsel()->_row('code', RequestHelper::getIdParam())->_init()
        );
    }

    public static function getStudentByUserId()
    {
        ResponseController::sentSuccessflyResponse(
            Students::_consult()->_all()->_cmsel()->_row('user_id', RequestHelper::getIdParam())->_init()
        );
    }

    public static function insertStudent()
    {
        ResponseController::sentSuccessflyResponse(
            Students::_insert(null)->_init()
        );
    }

    public static function updateStudent()
    {
        ResponseController::sentSuccessflyResponse(
            Students::_update(null)->_id(RequestHelper::getIdParam())->_init()
        );
    }

    public static function deleteStudent()
    {
        ResponseController::sentSuccessflyResponse(
            Students::_delete()->_id(RequestHelper::getIdParam())->_init()
        );
    }
}