<?php
namespace App\Controllers\Session;

use App\Controllers\General\ResponseController;
use App\Helpers\RequestHelper;
use App\Models\Sessions;

class SessionController{
    public static function getAllSessions(){
        ResponseController::sentSuccessflyResponse(
            Sessions::_consult()->_all()->_cmsel()->_init()
        );
    }

    public static function getSessionById(){
        ResponseController::sentSuccessflyResponse(
            Sessions::_consult()->_all()->_cmsel()->_id(RequestHelper::getIdParam())->_init()
        );
    }

    public static function getSessionByUserId(){
        ResponseController::sentSuccessflyResponse(
            Sessions::_consult()->_all()->_cmsel()->_row('user_id', RequestHelper::getIdParam())->_init()
        );
    }

    public static function deleteSessionById(){
        ResponseController::sentSuccessflyResponse(
            Sessions::_delete()->_id(RequestHelper::getIdParam())->_init()
        );
    }

    public static function deleteSessionByUserId(){
        ResponseController::sentSuccessflyResponse(
            Sessions::_delete()->_row('user_id', RequestHelper::getIdParam())->_init()
        );
    }

    public static function validateSessionStudent(){
        ResponseController::sentSuccessflyResponse(Sessions::validateSession('student'));
    }

    public static function validateSessionEnterprise(){
        ResponseController::sentSuccessflyResponse(Sessions::validateSession('enterprise'));
    }

    public static function validateSessionAny(){
        ResponseController::sentSuccessflyResponse(Sessions::validateSession('any'));
    }
}