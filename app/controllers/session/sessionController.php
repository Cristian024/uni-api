<?php
namespace App\Controllers\Session;

use App\Controllers\General\ResponseController;
use App\Helpers\DatabaseHelper;
use App\Helpers\RequestHelper;
use App\Models\Session;

class SessionController{
    public static function getAllSessions(){
        ResponseController::sentSuccessflyResponse(Session::getSession(null));
    }

    public static function getSessionById(){
        $filter = DatabaseHelper::createFilterCondition("")->_eq("id", RequestHelper::getIdParam());
        ResponseController::sentSuccessflyResponse(Session::getSession($filter));
    }

    public static function getSessionByUserId(){
        $filter = DatabaseHelper::createFilterCondition("")->_eq("user_id", RequestHelper::getIdParam());
        ResponseController::sentSuccessflyResponse(Session::getSession($filter));
    }

    public static function deleteSessionById(){
        $data = Session::deleteSession('id');
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function deleteSessionByUserId(){
        $data = Session::deleteSession('user_id');
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function validateSessionStudent(){
        $data = Session::validateSession('student');
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function validateSessionEnterprise(){
        $data = Session::validateSession('enterprise');
        ResponseController::sentSuccessflyResponse($data);
    }
}