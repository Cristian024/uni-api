<?php
namespace App\Controllers\Session;

use App\Controllers\General\ResponseController;
use App\Models\Session;

class SessionController{
    public static function getAllSessions(){
        $data = Session::getSession(null);
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function getSessionById(){
        $data = Session::getSession('id');
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function getSessionByUserId(){
        $data = Session::getSession('user_id');
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function deleteSessionById(){
        $data = Session::deleteSession('id');
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function deleteSessionByUserId(){
        $data = Session::deleteSession('user_id');
        ResponseController::sentSuccessflyResponse($data);
    }

    public static function validateSession(){
        $data = Session::validateSession();
        ResponseController::sentSuccessflyResponse($data);
    }
}